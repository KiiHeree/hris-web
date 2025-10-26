<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\Employees;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ====== Roles (Spatie) ======
        $roles = ['admin', 'hrd', 'employee'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // ====== Department & Position ======
        $dept = Department::firstOrCreate(['name' => 'IT']);
        $pos = Position::firstOrCreate(['name' => 'Staff']);

        // ====== Admin: Fiony ======
        $admin = User::firstOrCreate(
            ['email' => 'fiony@example.com'],
            ['name' => 'Fiony', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        // ====== HRD: Intan ======
        $hrd = User::firstOrCreate(
            ['email' => 'intan@example.com'],
            ['name' => 'Intan', 'password' => bcrypt('password')]
        );
        $hrd->assignRole('hrd');

        // ====== Employee: Ella ======
        $staff = User::firstOrCreate(
            ['email' => 'ella@example.com'],
            ['name' => 'Ella', 'password' => bcrypt('password')]
        );
        $staff->assignRole('employee');

        Employees::firstOrCreate(
            ['user_id' => $staff->id],
            [
                'nik' => 'EMP001',
                'join_date' => now(),
                'department_id' => $dept->id,
                'position_id' => $pos->id,
                'salary_basic' => 5000000,
                'bank_account' => '1234567890',
            ]
        );

        $this->call([
            WorkScheduleSeeder::class,
            HolidaySeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
