<?php

namespace App\Livewire;

use App\Models\Payroll;
use Livewire\Attributes\On;
use Livewire\Component;

class PayrollManagementLivewire extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $data;

    public function mount()
    {
        $this->get_payroll();
    }

    public function get_payroll()
    {
        $period = now()->subMonth()->format('Y-m');
        $this->data = Payroll::where('period', $period)->get();
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
        return view('pages.payroll.payroll_management')->layout('layouts.app');
    }
}
