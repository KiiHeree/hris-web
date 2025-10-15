<?php

namespace App\Livewire;

use App\Models\Attendance;
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
        $id = Auth::id();
        $attendance = Attendance::where('employee_id', $id)->where('date', $today)->first();

        if (!$attendance) {
            $this->status = 'not_checked_in';
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
