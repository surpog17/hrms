<?php

namespace App\Exports\Sheets;

use App\Absent;
use App\Calculated;
use App\Raw;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;



class AbsentSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
            'Name',
            'Date',
        ];
    }

    public function query()
    {
        return Absent::query()->where('remark', 0)->orderBy('acc_id', 'ASC');
    }

    /**
     * @var Absent $ab
     */
    public function map($ab): array
    {
        return [
            $ab->acc_id,
            $ab->name,
            $ab->date,
        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Absent';
    }

}
