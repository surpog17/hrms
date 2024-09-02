<?php

namespace App\Exports;

use App\Exports\PayrollSheet\AwardSheet;
use App\Exports\PayrollSheet\DeductionSheet;
use App\Exports\PayrollSheet\PayrollSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new PayrollSheet;
        $sheets[] = new DeductionSheet;
        $sheets[] = new AwardSheet;

        return $sheets;
    }
}
