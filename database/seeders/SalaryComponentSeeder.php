<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryComponentSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            // Allowance
            ['name' => 'Uang Makan',            'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 50000],
            ['name' => 'Tunjangan Jabatan',      'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 1500000],
            ['name' => 'Tunjangan Kehadiran',    'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 25000],
            ['name' => 'Tunjangan Keselamatan',  'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 50000],
            ['name' => 'Tunjangan Transport',    'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 500000],
            ['name' => 'Tunjangan Komunikasi',   'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 150000],
            ['name' => 'Tunjangan Kesehatan',    'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 200000],
            ['name' => 'Tunjangan Hari Raya',    'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 500000],
            ['name' => 'Bonus Kinerja',          'type' => 'allowance', 'calculation_type' => 'fixed', 'default_value' => 500000],

            // Overtime
            ['name' => 'Overtime',               'type' => 'overtime',  'calculation_type' => 'fixed', 'default_value' => 75000],

            // Deduction
            ['name' => 'Telat',                  'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 50000],
            ['name' => 'Alpha',                  'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 100000],
            ['name' => 'Potongan BPJS Kesehatan','type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 100000],
            ['name' => 'Potongan BPJS Tenaga Kerja', 'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 50000],
            ['name' => 'Potongan PPh 21',        'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 200000],
            ['name' => 'Potongan Kasbon',        'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 0],
            ['name' => 'Potongan Pinjaman',      'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 0],
        ];

        DB::table('salary_components')->insert($components);
    }
}