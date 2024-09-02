<?php

namespace App\Exports;

use App\Raw;
use App\Time;
use App\Webhr;
use App\Warning;
use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReprimandExport implements FromQuery, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
             'Webhr Username',
            'Full Name',
            'Type',
            'Date',
        ];
    }

    public function query()
    {
        $time = Time::all()->first();
        $start = $time->from;
        $end = $time->to;
        return Employee::query()->where(function($query) 
        {
            $query->whereNull('excuse')->orWhere('warnings.excuse',  '0');
        })->Join('warnings', function ($join) use($start,$end) {
            $join->on('employees.id', '=', 'warnings.employee_id')->whereBetween('date',[$start,$end]);
        })->join('webhrs', 'webhrs.acc_id', '=', 'employees.acc_id')->where('employees.is_active', 1)->select('employees.acc_id','webhrs.user_name','employees.full_name','warnings.date','warnings.type_id');
        //  return Employee::query()->Join('warnings', function ($join) use($start,$end) {
        //     $join->on('employees.id', '=', 'warnings.employee_id')->whereBetween('date',[$start,$end]);
        // })->select('employees.acc_id','employees.full_name','warnings.date','warnings.type_id');
    }

    /**
     * @var Absent $ab
     */
    public function map($ab): array
    {
        
        return [
            $ab->acc_id,
             $ab->user_name,
            $ab->full_name,
            $ab->type_id,
            $ab->date,

        ];
    }

}
