<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Overtime;
use App\Models\WorkScedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttendanceLivewire extends Component
{
    public $status;

    public function mount()
    {
        $this->getStatusAttendance();        
    }

    public function getStatusAttendance()
    {
        $today = Carbon::now()->toDateString();
        $dayOfWeek = strtolower(Carbon::now()->isoFormat('dddd')); // senin, selasa, dst
        $id = Auth::user()->employee->id;
        $attendance = Attendance::where('employee_id', $id)->where('date', $today)->first();

        // Cek libur nasional
        $isHoliday =  Holiday::whereDate('date', $today)->exists();

        // Cek jadwal kerja hari ini
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        // Kalau hari ini libur nasional atau bukan hari kerja, skip
        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            $this->status = 'libur';
        } elseif (!$attendance) {
            $this->status = 'not_checked_in';
        } elseif ($attendance->status != 'telat' && $attendance->status != 'hadir' && $attendance->status != 'alpha') {
            $this->status = 'done';
        } elseif (!$attendance->check_out) {
            $this->status = 'checked_in';
        } else {
            $this->status = 'done';
        }
    }

    public function AttendanceProces($status_attendance, $employee_id = null)
    {
        Carbon::setLocale('id');
        $today = Carbon::now();
        $formatDay = strtolower($today->translatedFormat('l'));
        $workSchedule = WorkScedule::where('day_of_week', $formatDay)->first();
        $hours = Carbon::now()->format('H:i:s');
        $attendance = '';
        $check_out_time = Carbon::parse($workSchedule['end_time']);
        $diffInHours = $check_out_time->diffInHours($hours, false);
        $start_time = Carbon::now()->setTimeFromTimeString($workSchedule['start_time']);

        // Gunakan employee_id dari parameter atau dari Auth
        $emp_id = $employee_id ?? Auth::user()->employee->id;

        if ($status_attendance == 'not_checked_in') {
            $attendance = Attendance::create([
                'employee_id' => $emp_id,
                'date' => $today,
                'check_in' => $hours,
                'status' => now()->gt($start_time) ? 'telat' : 'hadir',
                'source' => $employee_id ? 'face_recognition' : 'manual',
            ]);
        } elseif ($status_attendance == 'checked_in') {
            $attendance = Attendance::where('employee_id', $emp_id)
                ->where('date', $today->toDateString())
                ->update(['check_out' => $hours]);

            if ($diffInHours > 2) {
                Overtime::create([
                    'employee_id' => $emp_id,
                    'date' => $today,
                    'start_time' => $check_out_time,
                    'end_time' => $hours,
                    'total_hours' => $diffInHours,
                    'status' => 'pending',
                ]);
            }
        }

        if ($attendance) {
            session()->flash('success', '✅ Attendance has been recorded successfully!');
            $this->dispatch('reinitComponents');
            $this->getStatusAttendance();
        } else {
            session()->flash('error', '❌ Failed to record attendance. Please try again.');
        }
    }

    public function attendanceByFace($employee_id)
    {
        $status = $this->getStatusByEmployeeId($employee_id);
        
        if (in_array($status, ['not_checked_in', 'checked_in'])) {
            $this->AttendanceProces($status, $employee_id);
        }
    }

    public function getStatusByEmployeeId($employee_id)
    {
        $today = Carbon::now()->toDateString();
        $dayOfWeek = strtolower(Carbon::now()->isoFormat('dddd'));
        $attendance = Attendance::where('employee_id', $employee_id)->where('date', $today)->first();
        $isHoliday = Holiday::whereDate('date', $today)->exists();
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            return 'libur';
        } elseif (!$attendance) {
            return 'not_checked_in';
        } elseif (!$attendance->check_out && in_array($attendance->status, ['hadir', 'telat'])) {
            return 'checked_in';
        } else {
            return 'done';
        }
    }

    public function render()
    {
        $this->getStatusAttendance();
        return view('pages.dashboard')->layout('layouts.app');
    }
}
