<?php

namespace App\Exports;

use App\Exports\Sheets\AbsentWarningSheet;
use App\Exports\Sheets\AfternoonOver;
use App\Exports\Sheets\LunchLate;
use App\Exports\Sheets\MorningLate;
use App\Exports\Sheets\MorningOver;
use App\Exports\Sheets\NonSickSheet;
use App\Exports\Sheets\PlannedSheet;
use App\Exports\Sheets\ProjectSheet;
use App\Exports\Sheets\RawSheet;
use App\Exports\Sheets\SickSheet;
use App\Exports\Sheets\UnPlannedSheet;
use App\Exports\Sheets\WarningSheet;
use App\Exports\Sheets\WeekendOver;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new RawSheet;
        $sheets[] = new WarningSheet;
        $sheets[] = new PlannedSheet;
        $sheets[] = new AbsentWarningSheet;
        $sheets[] = new SickSheet;
        $sheets[] = new NonSickSheet;
        $sheets[] = new ProjectSheet;
        $sheets[] = new LunchLate;
        $sheets[] = new MorningOver;
        $sheets[] = new AfternoonOver;
        $sheets[] = new WeekendOver;


        return $sheets;
    }
}
