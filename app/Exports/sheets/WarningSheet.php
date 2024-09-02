<?php

namespace App\Exports\Sheets;


use App\Calculated;
use App\Raw;
use App\Type;
use App\Warning;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;



class WarningSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
            'First Name',
            'Last Name',
            'Type',
            'Displinary Measure'
        ];
    }

    public function query()
    {
        $morning = Type::where('name','Morning Late')->get();
        $cal = Calculated::where('active',1)->first();
        $start = $cal->from;
        $end = $cal->to;
        return Warning::query()->whereBetween('date',[$start,$end])->where('type_id',$morning[0]->id);
    }

    /**
     * @var Warning $war
     */
    public function map($war): array
    {
        return [
            $war->employee->acc_id,
            $war->employee->first_name,
            $war->employee->last_name,
            $war->type->name,
            $war->remark,

        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Morning Late';
    }


}
