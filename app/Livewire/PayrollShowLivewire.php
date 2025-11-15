<?php

namespace App\Livewire;

use App\Models\Payroll;
use Livewire\Component;

class PayrollShowLivewire extends Component
{

    public $payroll;

    public function mount($id)
    {
        $this->payroll = Payroll::with(['employee','items'])->findOrFail($id);
    }

    public function render()
    {
        return view('pages.payroll.show_payroll')->layout('layouts.app');
    }
}
