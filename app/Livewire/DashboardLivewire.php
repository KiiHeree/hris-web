<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardLivewire extends Component
{
    public function render()
    {
        return view('pages.dashboard')->layout('layouts.app');
    }
}
