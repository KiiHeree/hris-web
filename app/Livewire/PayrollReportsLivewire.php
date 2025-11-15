<?php

namespace App\Livewire;

use App\Models\Payroll;
use App\Models\User;
use Livewire\Component;

class PayrollReportsLivewire extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $data = [], $employee;
    public $employee_id = '', $period = '';

    public function mount()
    {
        $this->employee = User::role('employee')->get();
    }

    public function filter()
    {
        $query = Payroll::with('employee');
        if ($this->employee_id != '' && $this->period != '') {
            $this->data = $query->where('employee_id', $this->employee_id)->where('period', $this->period)->get();
            session()->flash('success', 'Payroll data fetched successfully.');
        } elseif ($this->period != '') {
            $this->data = $query->where('period', $this->period)->get();
            session()->flash('success', 'Payroll data fetched successfully.');
        } elseif ($this->employee_id != '') {
            $this->data = $query->where('employee_id', $this->employee_id)->get();
            session()->flash('success', 'Payroll data fetched successfully.');
        } else {
            session()->flash('error', 'No payroll data found');
        }
    }


    public function approve_payroll($id)
    {
        $update_payroll = Payroll::where('id', $id)->first();

        $update_payroll->update([
            'status' => 'paid'
        ]);

        if ($update_payroll) {
            $this->dispatch('refreshComponent');
            session()->flash('success', 'The data has been updated successfully');
        } else {
            session()->flash('error', 'Failed to updated the data. Please try again');
        }
    }

    public function render()
    {
        return view('pages.reports.payroll-reports')->layout('layouts.app');
    }
}
