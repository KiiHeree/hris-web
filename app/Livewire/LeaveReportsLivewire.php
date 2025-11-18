<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\User;
use Livewire\Component;

class LeaveReportsLivewire extends Component
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
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $this->data = Cuti::where('employee_id', $this->employee_id)->whereBetween('date', [$this->start_date, $this->end_date])->get();

        session()->flash('success', 'Leave data fetched successfully.');
    }

    public function render()
    {
        return view('pages.reports.leave-reports')->layout('layouts.app');
    }
}
