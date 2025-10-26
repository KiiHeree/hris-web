<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('attendance:generate-from-leaves')->dailyAt('00:05');
        $schedule->command('alpha:generate-daily-attendance-alpha')->dailyAt('12:00');
        $schedule->command('attendance:generate-from-leaves')->dailyAt('00:05')->appendOutputTo(storage_path('logs/attendance-job.log'));
        $schedule->command('payroll:generate-payrolls')->monthlyOn('5','00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
