<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cuti;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\WorkScedule;
use Carbon\Carbon;

class GenerateDailyAttendanceFromLeaves extends Command
{
    protected $signature = 'attendance:generate-from-leaves';
    protected $description = 'Generate attendance records automatically from approved leave requests';

    public function handle()
    {
        $today = Carbon::today();
        $dayOfWeek = strtolower($today->isoFormat('dddd')); // senin, selasa, dst

        // 🔹 Cek libur nasional
        $isHoliday =  Holiday::whereDate('date', $today)->exists();

        // 🔹 Cek jadwal kerja hari ini
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        // Kalau hari ini libur nasional atau bukan hari kerja, skip
        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            $this->info('🛑 Today is a holiday or non-working day. Skipping leave generation.');
            return;
        }

        // 🔹 Ambil semua cuti yang statusnya approved dan aktif hari ini
        $leaves = Cuti::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        if ($leaves->isEmpty()) {
            $this->info('ℹ️ No approved leaves for today.');
            return;
        }

        foreach ($leaves as $leave) {
            // Skip kalau udah ada data attendance (misal manual)
            $exists = Attendance::where('employee_id', $leave->employee_id)
                ->whereDate('date', $today)
                ->exists();

            if ($exists) continue;

            Attendance::updateOrCreate(
                [
                    'employee_id' => $leave->employee_id,
                    'date' => $today->toDateString(),
                ],
                [
                    'status' => $leave->type, // izin / sakit / cuti
                    'note' => $leave->deskripsi,
                    'source' => 'auto-scheduler',
                ]
            );

            $this->info("✅ Attendance generated for employee #{$leave->employee_id} ({$leave->type})");
        }

        $this->info('🎉 Leave attendance generation completed successfully!');
    }
}
