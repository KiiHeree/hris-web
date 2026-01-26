<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(public $employee_id, public $period) {}
    public function array(): array
    {
        $query = Payroll::with('employee');
        $data = '';
        if ($this->employee_id != 0 && $this->period != '0000-00') {
            $data = $query->where('employee_id', $this->employee_id)->where('period', $this->period)->get();
        } elseif ($this->period != '0000-00') {
            $data = $query->where('period', $this->period)->get();
        } elseif ($this->employee_id != 0) {
            $data = $query->where('employee_id', $this->employee_id)->get();
        } else {
            $data = '';
        }

        // dd($data);

        $data_export = [];
        $loop = 1;
        foreach ($data as $d) {
            $data_export[] = [
                $loop++,
                $d->employee->name,
                $d->period,
                number_format($d->salary_basic),
                number_format($d->net),
                $d->status
            ];
        }

        return $data_export;
    }

    public function headings(): array
    {
        return ['No', 'Employee', 'Period', 'Salary Basic', 'Salary Net', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        // Header Styling
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E90FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM],
            ],
        ]);

        $rowCount = count($this->array()) + 1;
        $sheet->getStyle("A2:F{$rowCount}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [];
    }
}
