<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\User;
use Livewire\Component;

class AttendanceLogLivewire extends Component
{
    public $data, $employee, $employee_id, $start_date, $end_date;

    public function mount()
    {
        $this->employee = User::role('employee')->get();
    }

    public function filter()
    {
        $this->validate([
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $this->data = Attendance::where('employee_id', $this->employee_id)
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->get();
    }

    public function render()
    {
        return view('pages.attendance.attendance_log')->layout('layouts.app');
    }
}
