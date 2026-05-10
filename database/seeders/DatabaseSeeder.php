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

        // ====== HRD: Ella ======
        $hrd = User::firstOrCreate(
            ['email' => 'ella@example.com'],
            ['name' => 'Ella', 'password' => bcrypt('password')]
        );
        $hrd->assignRole('hrd');

        // ====== Employee: Intan ======
        $staff = User::firstOrCreate(
            ['email' => 'intan@example.com'],
            ['name' => 'Intan', 'password' => bcrypt('password')]
        );
        $staff->assignRole('employee');

        $users = User::all();
        foreach($users as $key => $user) {
            Employees::firstOrCreate(
                ['user_id' => $user->id],
                [
                    // identity
                    'employee_code' => 'EMP00'.$key+1,
                    'nik' => 'EMP00'.$key+1,

                    // relations
                    'department_id' => $dept->id ?? null,
                    'position_id' => $pos->id ?? null,
                    'employment_status_id' => 1,
                    'manager_id' => null,

                    // basic info
                    'full_name' => $user->name ?? 'Staff Default',
                    'gender' => 'L', // atau 'P'
                    'birth_date' => '2000-01-01',
                    'birth_place' => 'Unknown',

                    // contact
                    'address' => 'Alamat default',
                    'telp' => '08123456789',
                    'email' => $user->email ?? 'staff@mail.com',

                    // employment
                    'join_date' => now(),
                    'resign_date' => null,

                    // finance
                    'salary_basic' => 5000000,
                    'bank_name' => 'BCA',
                    'bank_account' => '1234567890',
                    'npwp' => null,

                    // misc
                    'notes' => null,
                ]
            );
        }

        $this->call([
            WorkScheduleSeeder::class,
            HolidaySeeder::class,
            // AttendanceSeeder::class,
            // EmploymentStatusSeeder::class,
        ]);
    }
}
