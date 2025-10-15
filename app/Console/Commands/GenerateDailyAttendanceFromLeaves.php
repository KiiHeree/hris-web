<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cuti;
use App\Models\Attendance;
use Carbon\Carbon;

class GenerateDailyAttendanceFromLeaves extends Command
{
    protected $signature = 'attendance:generate-from-leaves';
    protected $description = 'Generate attendance records automatically from approved leave requests';

    public function handle()
    {
        $today = Carbon::today();

        // Ambil semua cuti yang statusnya approved & aktif hari ini
        $leaves = Cuti::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        if ($leaves->isEmpty()) {
            $this->info('No approved leaves for today.');
            return;
        }

        foreach ($leaves as $leave) {
            Attendance::updateOrCreate(
                [
                    'employee_id' => $leave->employee_id,
                    'date' => $today->toDateString(),
                ],
                [
                    'status' => $leave->type, // izin/sakit/cuti
                    'note' => $leave->deskripsi,
                    'source' => 'auto-scheduler',
                ]
            );

            $this->info("Attendance generated for employee #{$leave->employee_id} ({$leave->type})");
        }

        $this->info('✅ Attendance generation completed successfully!');
    }
}
