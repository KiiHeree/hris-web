<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\User;
use App\Models\WorkScedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dengan role employee
        $employees = User::role('employee')->get();

        if ($employees->isEmpty()) {
            $this->command->info('⚠️ Tidak ada user dengan role employee.');
            return;
        }

        $startDate = Carbon::now()->subMonth()->startOfMonth(); // bulan lalu tanggal 1
        $endDate = Carbon::now()->endOfMonth();

        foreach ($employees as $employee) {
            $this->command->info("👷 Generate attendance buat {$employee->name}");

            $date = $startDate->copy();
            while ($date->lte($endDate)) {

                $dayOfWeek = strtolower($date->isoFormat('dddd')); // senin, selasa, dst

                // 🔹 Cek libur nasional
                $isHoliday =  Holiday::whereDate('date', $date)->exists();

                // 🔹 Cek jadwal kerja hari ini
                $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

                if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
                    $date->addDay();
                    continue;
                }

                // Randomize check-in dan check-out
                $checkIn = Carbon::parse($date->format('Y-m-d') . ' 08:' . rand(0, 59));
                $checkOut = Carbon::parse($date->format('Y-m-d') . ' 17:' . rand(0, 59));

                // Tentukan status (kadang izin/sakit/random aja)
                $statusChance = rand(1, 100);
                if ($statusChance <= 5) {
                    $status = 'izin';
                } elseif ($statusChance <= 8) {
                    $status = 'sakit';
                } else if ($statusChance <= 10) {
                    $status = 'alpha';
                } elseif ($statusChance <= 12) {
                    $status = 'telat';
                } else {
                    $status = 'hadir';
                }

                Attendance::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                    ],
                    [
                        'check_in' => $status === 'hadir' ? $checkIn : null,
                        'check_out' => $status === 'hadir' ? $checkOut : null,
                        'status' => $status,
                        'note' => $status !== 'hadir' ? ucfirst($status) . ' (auto dummy)' : null,
                        'source' => 'seeder',
                    ]
                );

                $date->addDay();
            }
        }

        $this->command->info('✅ Dummy attendance berhasil digenerate untuk 1 bulan!');
    }
}
