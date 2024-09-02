<?php

namespace App\Exports\PayrollSheet;

use App\Payroll;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PayrollSheet implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function query()
    {
        return Payroll::query();
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Basic Salary',
            'Transport Allowance',
            'Taxable Transport Allowance',
            'Total Award',
            'Gross Salary',
            'Taxable Income',
            'Tax',
            
            'Employee Pension',
            'Company Pension',
           
            'Total Deduction',
            
            'Net Income'
        ];
    }

    /**
    * @var Payroll $payroll
    */
    public function map($payroll): array
    {
        return [
            $payroll->employee->full_name,
            $payroll->employee->basic_salary,
            $payroll->trans_allowance,
            $payroll->tax_tran_allowance,
             $payroll->total_award,
             $payroll->gross_income,
            $payroll->taxable_income,
            $payroll->tax,
           
            $payroll->emp_pension,
            $payroll->comp_pension,
          
            $payroll->total_deduction,
           
            $payroll->net_income,
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
            'J' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Payroll';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $size = Payroll::all()->count()+1;
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
               
                $cellRange = 'A1:L1'; // All headers
                // dd($size+1);
                $cellValues = 'A1:L' .$dooo;
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
