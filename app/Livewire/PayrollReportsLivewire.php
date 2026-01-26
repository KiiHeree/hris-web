<?php

namespace App\Livewire;

use App\Exports\PayrollExport;
use App\Jobs\ExportLaporanJob;
use App\Jobs\ExportPayrollJob;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PayrollReportsLivewire extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $data = [], $employee;
    public $employee_id = 0, $period = '0000-00';
    public $btn_report, $is_exporting, $export_ready;

    public function mount()
    {
        $this->employee = User::role('employee')->get();
        $this->btn_report = false;
    }

    public function filter()
    {
        $query = Payroll::with('employee');
        if ($this->employee_id != 0 && $this->period != '0000-00') {
            $this->data = $query->where('employee_id', $this->employee_id)->where('period', $this->period)->get();
            $this->btn_report = true;

            session()->flash('success', 'Payroll data fetched successfully.');
        } elseif ($this->period != '0000-00') {
            $this->data = $query->where('period', $this->period)->get();
            $this->btn_report = true;

            session()->flash('success', 'Payroll data fetched successfully.');
        } elseif ($this->employee_id != 0) {
            $this->data = $query->where('employee_id', $this->employee_id)->get();
            $this->btn_report = true;

            session()->flash('success', 'Payroll data fetched successfully.');
        } else {
            session()->flash('error', 'No payroll data found');
        }
    }

    public function export_reports()
    {
        if ($this->employee_id != 0 || $this->period != '0000-00') {
            ExportPayrollJob::dispatch($this->employee_id, $this->period);
            $this->is_exporting = true;
            $this->export_ready = false;
            session()->flash('success', 'Payroll Export sedang berjalan');
        } else {
            session()->flash('error', 'No payroll data found');
        }
        $this->btn_report = false;
    }

    public function export_status()
    {
        if (Cache::get('export_done')) {
            $this->is_exporting = false;
            $this->export_ready = true;
            if ($this->employee_id != 0 && $this->period != '0000-00') {
                $employee = User::where('id', $this->employee_id)->first();
                $this->dispatch('exportReady', fileUrl: 'export/payroll/laporan-periode-' . $this->period . '-employee-' . $employee->name . '.xlsx');
            } elseif ($this->period != '0000-00') {
                $this->dispatch('exportReady', fileUrl: 'export/payroll/laporan-periode-' . $this->period . '.xlsx');
            } elseif ($this->employee_id != 0) {
                $employee = User::where('id', $this->employee_id)->first();
                $this->dispatch('exportReady', fileUrl: 'export/payroll/laporan-employee-' . $employee->name . '.xlsx');
            }
            session()->flash('success', 'export payroll selesai');
        } elseif (Cache::get('export_false')) {
            session()->flash('success', 'export payroll gagal');
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
