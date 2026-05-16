<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employees;
use App\Models\EmployeeSalaryComponent;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GeneratePayrolls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:generate-payrolls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Payroll';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Periode tanggal 5 ke 5
        $now = Carbon::now();
        $start = $now->copy()->subMonth()->day(5)->startOfDay();
        $end = $now->copy()->day(4)->endOfDay();

        $employees = Employees::all();

        foreach ($employees as $employee) {
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$start, $end])
                ->get();

            if ($attendances->isEmpty()) continue;

            $basic = $employee->salary_basic ?? 0;
            $alphaCount = $attendances->where('status', 'alpha')->count();
            $lateCount = $attendances->where('status', 'telat')->count();
            $overtimeHours = $attendances->sum('overtime_hours');

            // get salary component
            $salaryComponent = EmployeeSalaryComponent::where('employee_id', $employee->id)->get();
            // deduction
            $alphaDeduction = 0;
            $lateDeduction = 0;
            // allowance
            $mealAllowance = 0;
            $positionAllowance = 0;
            $attendanceAllowance = 0;
            $safetyAllowance = 0;
            $overtime = 0;
            $items = [];
            foreach ($salaryComponent as $sc) {
                $salaryName = $sc->salaryComponent->name;
                if ($sc->salaryComponent->type == 'deduction') {
                    if ($salaryName == 'Telat') {
                        $lateDeduction = floor($lateCount / 3) * $sc->value;
                        if ($lateDeduction > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Late ({$lateCount} times)",
                                'amount' => $lateDeduction,
                            ];
                        }
                    } else if ($salaryName == 'Alpha') {
                        $alphaDeduction = $alphaCount * $sc->value;
                        if ($alphaDeduction > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Alpha ({$alphaCount} days)",
                                'amount' => $alphaDeduction,
                            ];
                        }
                    }
                } else {
                    $attendance = $attendances->where('status', 'hadir')->count();
                    if ($salaryName == 'Uang Makan') {
                        $mealAllowance = $attendance * $sc->value;
                        if($mealAllowance > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Uang Makan ({$attendance} Hari)",
                                'amount' => $mealAllowance,
                            ];
                        }
                    } else if ($salaryName == 'Tunjangan Jabatan') {
                        $positionAllowance = $sc->value;
                         if($positionAllowance > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Tunjangan Jabatan",
                                'amount' => $positionAllowance,
                            ];
                        }
                    } else if ($salaryName == 'Tunjangan Kehadiran') {
                        $attendanceAllowance = $attendance * $sc->value;
                         if($attendanceAllowance > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Tunjangan Kehadiran ({$attendance} Hari)",
                                'amount' => $attendanceAllowance,
                            ];
                        }
                    } else if ($salaryName == 'Tunjangan Keselamatan') {
                        $safetyAllowance = $sc->value;
                        if($safetyAllowance > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Tunjangan Keselamatan",
                                'amount' => $safetyAllowance,
                            ];
                        }
                    } else if ($salaryName == 'Overtime') {
                        $overtime = $overtimeHours * $sc->value;
                        if ($overtimeHours > 0) {
                            $items[] = [
                                'salary_component_id' => $sc->salary_component_id,
                                'description' => "Overtime ({$overtimeHours} hours)",
                                'amount' => $overtime,
                            ];
                        }
                    }
                }       
            }
            $allowance = $mealAllowance + $positionAllowance + $attendanceAllowance + $safetyAllowance + $overtime;
            $deduction = $lateDeduction + $alphaDeduction;
            $net = $basic + $overtime + $allowance - $deduction;

            // Buat / update payroll utama
            $payroll = Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'period' => now()->subMonth()->format('Y-m'),
                    'salary_basic' => $basic,
                    'total_allowance' => $allowance,
                    'total_deduction' => $deduction,
                    'net_salary' => $net,
                    'status' => 'draft', 
                ],
            );

            // Hapus item lama biar ga double
            $payroll->items()->delete();

            // Simpan item-itemnya
            foreach ($items as $item) {
                PayrollItem::create([
                    'payroll_id' => $payroll->id,
                    'salary_component_id' => $item['salary_component_id'],
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                ]);
            }

            $this->info("Payroll generated for {$employee->full_name}");
        }

        $this->info('Payroll generation completed successfully!');
    }
}
