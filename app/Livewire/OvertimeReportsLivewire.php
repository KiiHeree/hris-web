<?php

namespace App\Livewire;

use App\Models\Overtime;
use Livewire\Component;

class OvertimeReportsLivewire extends Component
{
    public $data;

    public function mount() {
        $this->get_data();
    }

    public function get_data() {
        $this->data = Overtime::all();
    }

    public function render()
    {
       return view('pages.reports.overtime-reports')->layout('layouts.app');
    }
}
