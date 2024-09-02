<?php

namespace App\Exports;

use App\Bank;
use App\Webhr;
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
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class BanksExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function query()
    {
        return Bank::query()->rightJoin('payrolls', 'payrolls.employee_id', '=', 'banks.employee_id')->whereNotNull('banks.employee_id');
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee Email',
            'Bank Account number',
            'Bank Account Type',
            'Branch Name',
            'Bank Name',
            'Netpay'
        ];
    }

    /**
     * @var Bank $bank
     */
    public function map($bank): array
    {
        return [
            $bank->employee->full_name,
            (Webhr::where('acc_id', $bank->employee->acc_id)->first())?Webhr::where('acc_id', $bank->employee->acc_id)->first()->email:'',
            $bank->bank_account_number,
            $bank->bank_account_type,
            $bank->branch_name,
            $bank->bank_name,
            $bank->net_income,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
          
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
        return 'Bank';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $size = Bank::rightJoin('payrolls', 'payrolls.employee_id', '=', 'banks.employee_id')->whereNotNull('banks.employee_id')->count() + 1;
                $dooo = $size + 1;
                $event->sheet->getDelegate()->setCellValue('F' . $dooo, "Grand Total");
                $event->sheet->getDelegate()->setCellValue('G' . $dooo, "=SUM(G2:G" . $size . ")");
                $cellRange = 'A1:G1'; // All headers
                // dd($size+1);
                $cellValues = 'A1:G' . $dooo;
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
