<?php

namespace App\Exports\PayrollSheet;

use App\Deduct;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DeductionSheet implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function query()
    {
        return Deduct::query()->rightJoin('payrolls', 'payrolls.employee_id', '=', 'deducts.employee_id')->whereNotNull('deducts.employee_id');
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Medical',
            'Absentism',
            'Car Maintenance',
            'PMA',
            'Exam Failed',
            'Other Deduction',
            'LateCome',
            'Loan',
            'Tax',
            'Employee Deduction',
            'Company Deduction',
            'Total Deduction',
        ];
    }

    /**
     * @var Payroll $deduct
     */
    public function map($deduct): array
    {
        return [
            $deduct->employee->full_name,
            $deduct->medical,
            $deduct->absent,
            $deduct->car,
            $deduct->pma,
            $deduct->exam,
            $deduct->other,
            $deduct->latecommer,
            $deduct->loan,
            $deduct->tax,
            $deduct->emp_pension,
            $deduct->comp_pension,
            $deduct->total_deduction,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Deduction';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $size = Deduct::rightJoin('payrolls', 'payrolls.employee_id', '=', 'deducts.employee_id')->whereNotNull('deducts.employee_id')->count()+1;
                // $size = Payroll::all()->count()+1;
                $dooo = $size+1;
                $event->sheet->getDelegate()->setCellValue('A' .$dooo, "Grand Total");
                $event->sheet->getDelegate()->setCellValue('B' .$dooo, "=SUM(B2:B". $size.")");
                $event->sheet->getDelegate()->setCellValue('C' .$dooo, "=SUM(C2:C". $size.")");
                $event->sheet->getDelegate()->setCellValue('D' .$dooo, "=SUM(D2:D". $size.")");
                $event->sheet->getDelegate()->setCellValue('E' .$dooo, "=SUM(E2:E". $size.")");
                $event->sheet->getDelegate()->setCellValue('F' .$dooo, "=SUM(F2:F". $size.")");
                $event->sheet->getDelegate()->setCellValue('G' .$dooo, "=SUM(G2:G". $size.")");
                $event->sheet->getDelegate()->setCellValue('H' .$dooo, "=SUM(H2:H". $size.")");
                $event->sheet->getDelegate()->setCellValue('I' .$dooo, "=SUM(I2:I". $size.")");
                $event->sheet->getDelegate()->setCellValue('J' .$dooo, "=SUM(J2:J". $size.")");
                $event->sheet->getDelegate()->setCellValue('K' .$dooo, "=SUM(K2:K". $size.")");
                $event->sheet->getDelegate()->setCellValue('L' .$dooo, "=SUM(L2:L". $size.")");
                $event->sheet->getDelegate()->setCellValue('M' .$dooo, "=SUM(M2:M". $size.")");
                $cellRange = 'A1:M1'; // All headers
                // dd($size+1);
                $cellValues = 'A1:M' .$dooo;
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellValues)->getFont()->setName('Times New Roman');
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellValues)->applyFromArray($styleArray);
            },
        ];
    }
}
