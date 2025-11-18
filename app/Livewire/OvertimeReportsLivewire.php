<?php

namespace App\Livewire;

use App\Models\Overtime;
use App\Models\User;
use Livewire\Component;

class OvertimeReportsLivewire extends Component
{
    public $data = [], $employee;
    public $employee_id, $start_date, $end_date;

    public function mount()
    {
        $this->get_data();
    }

    public function get_data()
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

        $this->data = Overtime::where('employee_id', $this->employee_id)->whereBetween('date', [$this->start_date, $this->end_date])->get();

        session()->flash('success', 'Overtime data fetched successfully.');
    }

    public function render()
    {
        return view('pages.reports.overtime-reports')->layout('layouts.app');
    }
}
