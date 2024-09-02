<?php

namespace App\Exports\Sheets;


use App\Calculated;
use App\Raw;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;



class MorningOver implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
            'Name',
            'Morning Over',
        ];
    }

    public function query()
    {
        return Calculated::query()->where('morning_ovetime','>',0)->orderBy('acc_id','ASC');
    }

    /**
     * @var Calculated $cal
     */
    public function map($cal): array
    {
        return [
            $cal->acc_id,
            $cal->name,
            $this->format_time($cal->morning_ovetime),
        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Morning Over';
    }

    public function format_time($init)
    {
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        return "$hours:$minutes:$seconds";
    }
}
