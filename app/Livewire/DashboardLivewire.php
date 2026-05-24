<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employees;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\WorkScedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardLivewire extends Component
{
    public $status;

    public function mount()
    {
        if (Auth::user()->hasRole('employee')) {
            $this->getStatusAttendance();
        }
    }

    public function getStatusAttendance()
    {
        $today = Carbon::now()->toDateString();
        $dayOfWeek = strtolower(Carbon::now()->isoFormat('dddd'));
        $id = Auth::user()->employee->id;
        $attendance = Attendance::where('employee_id', $id)->where('date', $today)->first();
        $isHoliday = Holiday::whereDate('date', $today)->exists();
        $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

        if ($isHoliday || !$workSchedule || !$workSchedule->is_working_day) {
            $this->status = 'libur';
        } elseif (!$attendance) {
            $this->status = 'not_checked_in';
        } elseif (!in_array($attendance->status, ['hadir', 'telat', 'alpha'])) {
            $this->status = 'done';
        } elseif (!$attendance->check_out) {
            $this->status = 'checked_in';
        } else {
            $this->status = 'done';
        }
    }

    public function render()
    {
        $today = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->subMonth()->format('Y-m');
        $user = Auth::user();

        if ($user->hasRole('employee')) {
            $employee = $user->employee;

            // Absensi bulan ini
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereYear('date', Carbon::now()->year)
                ->whereMonth('date', Carbon::now()->month)
                ->get();

            $stats = [
                'hadir'  => $attendances->whereIn('status', ['hadir', 'telat'])->count(),
                'izin'   => $attendances->whereIn('status', ['izin', 'sakit', 'cuti'])->count(),
                'alpha'  => $attendances->where('status', 'alpha')->count(),
                'telat'  => $attendances->where('status', 'telat')->count(),
            ];

            // Payroll terakhir
            $latestPayroll = Payroll::where('employee_id', $employee->id)
                ->latest()
                ->first();

            // Jadwal kerja hari ini
            $dayOfWeek = strtolower(Carbon::now()->isoFormat('dddd'));
            $workSchedule = WorkScedule::where('day_of_week', $dayOfWeek)->first();

            // Absensi hari ini
            $todayAttendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $today)
                ->first();

            return view('pages.dashboard', compact(
                'stats', 'latestPayroll', 'workSchedule', 'todayAttendance', 'employee'
            ))->layout('layouts.app');

        } else {
            // Admin/Manajer
            $totalEmployees = Employees::count();
            $todayAttendances = Attendance::where('date', $today)->get();

            $adminStats = [
                'total_karyawan' => $totalEmployees,
                'hadir'          => $todayAttendances->whereIn('status', ['hadir', 'telat'])->count(),
                'izin'           => $todayAttendances->whereIn('status', ['izin', 'sakit', 'cuti'])->count(),
                'alpha'          => $todayAttendances->where('status', 'alpha')->count(),
            ];

            // Payroll bulan ini
            $payrollStats = [
                'total'  => Payroll::where('period', $currentMonth)->count(),
                'draft'  => Payroll::where('period', $currentMonth)->where('status', 'draft')->count(),
                'paid'   => Payroll::where('period', $currentMonth)->where('status', 'paid')->count(),
                'amount' => Payroll::where('period', $currentMonth)->where('status', 'paid')->sum('net_salary'),
            ];

            // dd($payrollStats);

            // 5 karyawan belum absen hari ini
            $notAttended = Employees::whereDoesntHave('attendances', function ($q) use ($today) {
                $q->where('date', $today);
            })->limit(5)->get();

            return view('pages.dashboard', compact(
                'adminStats', 'payrollStats', 'notAttended'
            ))->layout('layouts.app');
        }
    }
}