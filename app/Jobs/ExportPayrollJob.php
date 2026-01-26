<?php

namespace App\Jobs;

use App\Exports\PayrollExport;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ExportPayrollJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $employee_id, public $period)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->employee_id != 0 && $this->period != '0000-00') {
            $employee = User::where('id', $this->employee_id)->first();
            Excel::store(new PayrollExport($this->employee_id, $this->period), 'export/payroll/laporan-periode-' . $this->period . '-employee-' . $employee->name . '.xlsx', 'public');
        } elseif ($this->period != '0000-00') {
            Excel::store(new PayrollExport($this->employee_id, $this->period), 'export/payroll/laporan-periode-' . $this->period . '.xlsx', 'public');
        } elseif ($this->employee_id != 0) {
            $employee = User::where('id', $this->employee_id)->first();
            Excel::store(new PayrollExport($this->employee_id, $this->period), 'export/payroll/laporan-employee-' . $employee->name . '.xlsx', 'public');
        } else {
            Cache::put("export_false", true, now()->addMinutes(1));
        }
        Cache::put("export_done", true, now()->addMinutes(1));
    }
}
