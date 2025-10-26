<?php

namespace App\Console\Commands;

use App\Models\Attendance;
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
        // 🔥 Periode tanggal 5 ke 5
        $now = Carbon::now();
        $start = $now->copy()->subMonth()->day(5)->startOfDay();
        $end = $now->copy()->day(4)->endOfDay();

        $employees = User::role('employee')->get();

        foreach ($employees as $employee) {
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$start, $end])
                ->get();

            if ($attendances->isEmpty()) continue;

            $basic = $employee->employee->salary_basic ?? 0;
            $alphaCount = $attendances->where('status', 'alpha')->count();
            $lateCount = $attendances->where('status', 'telat')->count();
            $overtimeHours = $attendances->sum('overtime_hours');

            // 🔹 Perhitungan
            $alphaDeduction = $alphaCount * ($basic * 0.05);
            $lateDeduction = floor($lateCount / 3) * ($basic * 0.05);
            $allowance = $attendances->where('status', 'hadir')->count() * 100000;
            $overtimePay = $overtimeHours * ($basic * 0.02);
            $net = $basic + $overtimePay + $allowance - ($alphaDeduction + $lateDeduction);

            // 🔹 Buat / update payroll utama
            $payroll = Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'period' => now()->subMonth()->format('Y-m'),
                    'salary_basic' => $basic,
                    'net' => $net,
                    'status' => 'draft',
                ],
            );

            // 🔹 Hapus item lama biar ga double
            $payroll->items()->delete();

            // 🔹 Insert item baru
            $items = [
                [
                    'type' => 'allowance',
                    'description' => 'Uang Makan',
                    'amount' => $allowance,
                ],
            ];

            if ($overtimeHours > 0) {
                $items[] = [
                    'type' => 'overtime',
                    'description' => "Overtime ({$overtimeHours} hours)",
                    'amount' => $overtimePay,
                ];
            }

            if ($alphaDeduction > 0) {
                $items[] = [
                    'type' => 'deduction',
                    'description' => "Alpha ({$alphaCount} days)",
                    'amount' => -$alphaDeduction,
                ];
            }

            if ($lateDeduction > 0) {
                $items[] = [
                    'type' => 'deduction',
                    'description' => "Late ({$lateCount} times)",
                    'amount' => -$lateDeduction,
                ];
            }

            // Simpan item-itemnya
            foreach ($items as $item) {
                PayrollItem::create([
                    'payroll_id' => $payroll->id,
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                ]);
            }

            $this->info("✅ Payroll generated for {$employee->name}");
        }

        $this->info('💰 Payroll generation completed successfully!');
    }
}
