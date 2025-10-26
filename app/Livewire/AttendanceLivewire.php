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
        if (Auth::user()->getRoleNames()->first() == 'employee') {
            $this->getStatusAttendance();
        }
    }

    public function getStatusAttendance()
    {
        $today = Carbon::now()->toDateString();
        $dayOfWeek = strtolower($today->isoFormat('dddd')); // senin, selasa, dst
        $id = Auth::id();
        $attendance = Attendance::where('employee_id', $id)->where('date', $today)->first();

        // 🔹 Cek libur nasional
        $isHoliday =  Holiday::whereDate('date', $today)->exists();

        // 🔹 Cek jadwal kerja hari ini
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

    public function AttendanceProces($status_attendance)
    {
        $today = Carbon::now();
        $hours = Carbon::now()->format('H:i:s');
        $check_out_time = Carbon::parse('16:00');
        $attendance = '';
        $diffInHours = $check_out_time->diffInHours($hours, false);

        if ($status_attendance == 'not_checked_in') {
            $attendance = Attendance::create([
                'employee_id' => Auth::id(),
                'date' => $today,
                'check_in' => $hours,
                'status' => now()->gt(now()->setTime(8, 0)) ? 'telat' : 'hadir',
            ]);
        } elseif ($status_attendance == 'checked_in') {
            $attendance = Attendance::where('employee_id', Auth::id())->update([
                'check_out' => $hours,
            ]);

            if ($diffInHours > 2) {
                Overtime::create([
                    'employee_id' => Auth::id(),
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

    public function render()
    {
        return view('pages.dashboard')->layout('layouts.app');
    }
}
