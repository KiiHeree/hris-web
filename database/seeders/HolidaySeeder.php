<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $holidays = [
            ['date' => '2025-01-01', 'description' => 'Tahun Baru Masehi'],
            ['date' => '2025-03-31', 'description' => 'Nyepi (Tahun Baru Saka)'],
            ['date' => '2025-04-18', 'description' => 'Wafat Isa Almasih'],
            ['date' => '2025-05-01', 'description' => 'Hari Buruh Internasional'],
            ['date' => '2025-05-29', 'description' => 'Kenaikan Isa Almasih'],
            ['date' => '2025-06-01', 'description' => 'Hari Lahir Pancasila'],
            ['date' => '2025-06-06', 'description' => 'Hari Raya Idul Adha'],
            ['date' => '2025-07-17', 'description' => 'Tahun Baru Islam 1447 H'],
            ['date' => '2025-08-17', 'description' => 'Hari Kemerdekaan RI'],
            ['date' => '2025-12-25', 'description' => 'Hari Natal'],
        ];

        Holiday::insert($holidays);
    }
}
