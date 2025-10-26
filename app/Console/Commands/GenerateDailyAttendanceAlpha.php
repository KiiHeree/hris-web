<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Cuti;
use App\Models\Holiday;
use App\Models\User;
use App\Models\WorkScedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateDailyAttendanceAlpha extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alpha:generate-daily-attendance-alpha';
    protected $description = 'Generate attendance records automatically from approved leave requests';


    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $dayOfWeek = strtolower($today->isoFormat('dddd')); // senin, selasa, dst

        // Cek hari libur nasional
        $isHoliday = Holiday::whereDate('date', $today)->exists();

        // Ambil jadwal kerja hari ini
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        // Kalau libur nasional atau bukan hari kerja, skip aja
        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            $this->info('🛑 Today is a holiday or non-working day. Skipping alpha generation.');
            return;
        }

        // Ambil semua employee yang gak punya record attendance hari ini
        // dan gak lagi cuti/izin/sakit (approved)
        $employees = User::role('employee')
            ->with(['attendance' => function ($query) use ($today) {
                $query->whereDate('date', $today);
            }])
            ->get();

        foreach ($employees as $emp) {
            $hasAttendance = $emp->attendance->where('date', $today->toDateString())->first();

            // Skip kalau udah punya data attendance
            if ($hasAttendance) continue;

            // Skip kalau lagi cuti/izin/sakit (approved & aktif hari ini)
            $onLeave = Cuti::where('employee_id', $emp->id)
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->exists();

            if ($onLeave) continue;

            // Buat record alpha
            Attendance::updateOrCreate(
                [
                    'employee_id' => $emp->id,
                    'date' => $today->toDateString(),
                ],
                [
                    'status' => 'alpha',
                    'note' => 'Tidak hadir tanpa keterangan',
                    'source' => 'auto-scheduler',
                ]
            );

            $this->info("⚠️ Alpha recorded for employee #{$emp->id}");
        }

        $this->info('✅ Alpha generation completed successfully!');
    }
}
