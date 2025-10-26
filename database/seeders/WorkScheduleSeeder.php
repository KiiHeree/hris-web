<?php

namespace Database\Seeders;

use App\Models\WorkScedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['day_of_week' => 'senin',  'start_time' => '08:00:00', 'end_time' => '16:00:00', 'is_working_day' => true],
            ['day_of_week' => 'selasa', 'start_time' => '08:00:00', 'end_time' => '16:00:00', 'is_working_day' => true],
            ['day_of_week' => 'rabu',   'start_time' => '08:00:00', 'end_time' => '16:00:00', 'is_working_day' => true],
            ['day_of_week' => 'kamis',  'start_time' => '08:00:00', 'end_time' => '16:00:00', 'is_working_day' => true],
            ['day_of_week' => 'jumat',  'start_time' => '08:00:00', 'end_time' => '16:00:00', 'is_working_day' => true],
            ['day_of_week' => 'sabtu',  'start_time' => null,       'end_time' => null,       'is_working_day' => false],
            ['day_of_week' => 'minggu', 'start_time' => null,       'end_time' => null,       'is_working_day' => false],
        ];

        WorkScedule::insert($data);
    }
}
