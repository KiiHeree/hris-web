<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\User;
use Livewire\Component;

class AttendanceReportsLivewire extends Component
{
    public $employee, $data = [];
    public $employee_id, $start_date, $end_date;

    public function mount()
    {
        $this->employee = User::role('employee')->get();
    }

    public function filter()
    {
        $this->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($this->start_date != '' && $this->end_date != '' && $this->employee_id != '') {
            $this->data = Attendance::with('employee')->where('employee_id', $this->employee_id)->whereBetween('date', [$this->start_date, $this->end_date])->get();
            session()->flash('success', 'Attendance data fetched successfully.');
        } elseif ($this->start_date != '') {
            $this->data = Attendance::with('employee')->whereBetween('date', [$this->start_date, $this->end_date])->get();
            session()->flash('success', 'Attendance data fetched successfully.');
        } else {
            session()->flash('error', 'Attendance data not found.');
        }

        $this->dispatch('reinitComponents');

    }

    public function render()
    {
        return view('pages.reports.attendance-reports')->layout('layouts.app');
    }
}
