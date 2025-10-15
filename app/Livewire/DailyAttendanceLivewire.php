<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class DailyAttendanceLivewire extends Component
{
    public $data,$date;
    public function mount()
    {
        $this->data = User::role('employee')->with(['attendance' => function ($query) {
            $query->whereDate('date', Carbon::today()->format('Y-m-d'));
        }])->get();
        $this->date = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        return view('pages.attendance.daily_attendance')->layout('layouts.app');
    }
}
