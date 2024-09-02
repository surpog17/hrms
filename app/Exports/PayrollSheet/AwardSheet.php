<?php

namespace App\Exports\PayrollSheet;

use App\Award;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
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

class AwardSheet implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function query()
    {
        return Award::query()->rightJoin('payrolls', 'payrolls.employee_id', '=', 'awards.employee_id')->whereNotNull('awards.employee_id');
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Variable Pay',
            'Allowance',
            'Exam Bonus',
            'Implementation Effectiveness Bonus',
            'Effective Order and Delivery Bonus',
            'Closed Deals Bonus',
            'Management Performance Evaluation Quarterly Bonus',
            'Staff Performance Evaluation Quarterly Bonus',
            'Timely VAT Collection Quarterly Bonus',
            'Timely Payment Collection Quarterly Bonus',
            'Best Employees Productivity and Engagement Quarterly Bonus',
            'Facilities High Availability Quarterly Bonus',
            'Cash Collection Bonus',
            'Operation Incentive',
            'Operation Leadership Incentive',
            'Admin Incentive',
            
            
            'Bonus',
            'Total Award',
        ];
    }

    /**
     * @var Payroll $award
     */
    public function map($award): array
    {
        return [
            $award->employee->full_name,
            $award->allowance,
             $award->position_allowance,
            $award->exam_bonus,
            $award->ieb,
            $award->eodb,
            $award->cdb,
            $award->mpeqb,
            $award->speqb,
            $award->tvcqb,
            $award->tpcqb,
            $award->bepeqb,
            $award->fhaqb,
            
             $award->cashcollection,
            $award->operationincentive,
            $award->operationleadership,
            $award->adminincentive,
            $award->bonus,
            $award->total_award,
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
            'N' => NumberFormat::FORMAT_NUMBER,
            'O' => NumberFormat::FORMAT_NUMBER,
            'P' => NumberFormat::FORMAT_NUMBER,
            'Q' => NumberFormat::FORMAT_NUMBER,
            'R' => NumberFormat::FORMAT_NUMBER,
            'S' => NumberFormat::FORMAT_NUMBER,

        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Award';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $size = Award::rightJoin('payrolls', 'payrolls.employee_id', '=', 'awards.employee_id')->whereNotNull('awards.employee_id')->count()+1;
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
                $event->sheet->getDelegate()->setCellValue('N' .$dooo, "=SUM(N2:N". $size.")");
                 $event->sheet->getDelegate()->setCellValue('O' .$dooo, "=SUM(O2:O". $size.")");
                $event->sheet->getDelegate()->setCellValue('P' .$dooo, "=SUM(P2:P". $size.")");
                $event->sheet->getDelegate()->setCellValue('Q' .$dooo, "=SUM(Q2:Q". $size.")");
                $event->sheet->getDelegate()->setCellValue('R' .$dooo, "=SUM(R2:R". $size.")");
                 $event->sheet->getDelegate()->setCellValue('S' .$dooo, "=SUM(S2:S". $size.")");
                $cellRange = 'A1:S1'; // All headers
                // dd($size+1);
                $cellValues = 'A1:S' .$dooo;
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(19);
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
