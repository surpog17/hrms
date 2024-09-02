<?php

namespace App\Exports\Sheets;

use App\Morning;
use App\Raw;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;



class MorningLate implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
            'Name',
            'Total Late',
            'Date',
            'Late',
        ];
    }

    public function query()
    {
        return Morning::query();
    }

    /**
     * @var Morning $morning
     */
    public function map($morning): array
    {
        return [
            $morning->calculated->acc_id,
            $morning->calculated->name,
            $this->format_time($morning->calculated->morning_late),
            $morning->date,
            $this->format_time($morning->late),
        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Morning Late';
    }

    public function format_time($init)
    {
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        return "$hours:$minutes:$seconds";
    }
}
