<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employees;
use App\Models\Holiday;
use App\Models\Overtime;
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
        $employees = Employees::all();

        if ($employees->isEmpty()) {
            $this->command->info('⚠️ Tidak ada user dengan role employee.');
            return;
        }

        $startDate = Carbon::now()->subMonth()->startOfMonth(); // bulan lalu tanggal 1
        $endDate = Carbon::now()->endOfMonth();
        $check_out_time = Carbon::parse('16:00');

        // random hour
        function weightedRandom($weights)
        {
            $total = array_sum($weights);
            $rand = rand(1, $total);

            foreach ($weights as $hour => $weight) {
                if ($rand <= $weight) {
                    return $hour;
                }
                $rand -= $weight;
            }
        }
        $weightedHours = [
            16 => 80,
            17 => 50,
            18 => 30,
            19 => 20,
            20 => 10,
        ];



        foreach ($employees as $employee) {
            $this->command->info("Generate attendance buat {$employee->full_name}");

            $date = $startDate->copy();
            while ($date->lte($endDate)) {

                $dayOfWeek = strtolower($date->isoFormat('dddd')); // senin, selasa, dst

                //  Cek libur 
                $isHoliday =  Holiday::whereDate('date', $date)->exists();

                //  Cek jadwal kerja hari ini
                $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

                if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
                    $date->addDay();
                    continue;
                }

                // Randomize check-in dan check-out
                $checkIn = Carbon::parse(' 07:' . rand(0, 59));
                $hour = weightedRandom($weightedHours);
                $minute = rand(0, 59);
                $checkOut = Carbon::createFromTime($hour, $minute);

                $diffInHours =  $check_out_time->diffInHours($checkOut, false);

                // Tentukan status 
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

                if ($status == 'hadir' && $diffInHours >= 1) {
                    Overtime::create([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => Carbon::parse('16:00'),
                        'end_time' => $checkOut,
                        'total_hours' => $diffInHours,
                        'status' => 'approved',
                    ]);
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
                        'overtime_hours' => $diffInHours,
                        'note' => $status !== 'hadir' ? ucfirst($status) . ' (auto dummy)' : null,
                        'source' => 'seeder',
                    ]
                );

                $date->addDay();
            }
        }

        $this->command->info('Dummy attendance berhasil digenerate untuk 1 bulan!');
    }
}
