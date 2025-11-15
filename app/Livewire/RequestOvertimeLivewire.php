<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequestOvertimeLivewire extends Component
{
    public $data;

    public function mount()
    {
        $this->get_data();
    }

    public function get_data()
    {
        $this->data = Overtime::where('status', 'pending')->get();
    }

    public function overtime_approve($status, $id)
    {
        $overtime = Overtime::where('id', $id)->first();

        $overtime->update([
            'status' => $status,
            'approver_id' => Auth::id()
        ]);

        if ($status == 'approved' && $overtime) {
            $update_attendance = Attendance::where('date', $overtime->date)->where('employee_id', $overtime->employee_id)->first();
            $update_attendance->update([
                'overtime_hours' => $overtime->total_hours
            ]);
            session()->flash('success', 'The data has been updated successfully');
            $this->get_data();
        } else {
            session()->flash('error', 'Failed to updated the data. Please try again');
        }
    }

    public function render()
    {
        return view('pages.attendance.overtime_request')->layout('layouts.app');
    }
}
