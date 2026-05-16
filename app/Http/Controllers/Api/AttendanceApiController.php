<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Overtime;
use App\Models\WorkScedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceApiController extends Controller
{
    public function faceCheckin(Request $request)
    {
        if ($request->header('X-Service-Secret') !== config('app.face_service_secret')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate(['employee_id' => 'required|integer|exists:employees,id']);

        $employee_id = $request->employee_id;
        $today = Carbon::now()->toDateString();
        $now = Carbon::now();
        $dayOfWeek = strtolower($now->isoFormat('dddd'));

        // 1. Cek libur & jadwal kerja
        $isHoliday = Holiday::whereDate('date', $today)->exists();
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            return response()->json(['success' => false, 'message' => 'Hari ini libur/tidak ada jadwal']);
        }

        $attendance = Attendance::where('employee_id', $employee_id)->where('date', $today)->first();
        $hours = $now->format('H:i:s');
        $start_time = Carbon::now()->setTimeFromTimeString($workSchedule['start_time']);
        $check_out_time = Carbon::parse($workSchedule['end_time']);
        
        if (auth()->check()) {
            if (auth()->user()->employee->id != $employee_id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Identitas wajah tidak cocok dengan akun login!'
                ]);
            }
        }

        if ($attendance) {
            // Ambil waktu dari check_in terakhir
            $lastAction = Carbon::parse($attendance->date . ' ' . $attendance->check_in);
            $diffInMinutes = $lastAction->diffInMinutes($now);

            // Jika kurang dari 5 menit, tolak request (ini akan mencegah double hit)
            if ($diffInMinutes < 5) {
                $sisaDetik = 300 - $lastAction->diffInSeconds($now);
                return response()->json([
                    'success' => false, 
                    'message' => "Sabar, tunggu " . ($sisaDetik) . " detik lagi untuk scan ulang.",
                    'employee_id' => $employee_id
                ]);
            }
        }
        // ----------------------------------

        if (!$attendance || !in_array($attendance->status, ['hadir', 'telat'])) {
            // Check in
            Attendance::create([
                'employee_id' => $employee_id,
                'date' => $today,
                'check_in' => $hours,
                'status' => $now->gt($start_time) ? 'telat' : 'hadir',
                'source' => 'face_recognition',
            ]);
            return response()->json(['success' => true, 'message' => 'Check in berhasil', 'action' => 'check_in', 'employee_id' => $employee_id]);

        } elseif (!$attendance->check_out) {
            // Check out
            $attendance->update(['check_out' => $hours]);

            // Logika Overtime
            $diffInHours = $check_out_time->diffInHours($hours, false);
            if ($diffInHours > 2) {
                Overtime::create([
                    'employee_id' => $employee_id,
                    'date' => $today,
                    'start_time' => $check_out_time->format('H:i:s'), // Pastikan formatnya string jam
                    'end_time' => $hours,
                    'total_hours' => $diffInHours,
                    'status' => 'pending',
                ]);
            }
            return response()->json(['success' => true, 'message' => 'Check out berhasil', 'action' => 'check_out', 'employee_id' => $employee_id]);
        }

        return response()->json(['success' => false, 'message' => 'Anda sudah menyelesaikan absensi hari ini', 'employee_id' => $employee_id]);
    }
}