<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Tetap',
                'type' => 'year',
                'duration' => 0, // 0 = tidak terbatas
                'description' => 'Karyawan tetap tanpa batas kontrak',
            ],
            [
                'name' => 'Kontrak 1 Tahun',
                'type' => 'year',
                'duration' => 1,
                'description' => 'Kontrak selama 1 tahun',
            ],
            [
                'name' => 'Kontrak 6 Bulan',
                'type' => 'month',
                'duration' => 6,
                'description' => 'Kontrak selama 6 bulan',
            ],
            [
                'name' => 'Magang 3 Bulan',
                'type' => 'month',
                'duration' => 3,
                'description' => 'Magang selama 3 bulan',
            ],
        ];

        foreach ($data as $item) {
            DB::table('employment_statuses')->updateOrInsert(
                ['name' => $item['name']],
                [
                    'type' => $item['type'],
                    'duration' => $item['duration'],
                    'description' => $item['description'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
