<?php

namespace App\Exports\Sheets;

use App\Calculated;
use App\Morning;
use App\Raw;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;


class RawSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'acc_id',
            'Name',
            'Date',
            'TimeTable',
            'checkin',
            'checkout'
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $calculated = Calculated::where('active',1)->first();
        return Raw::query()->whereBetween('date', [$calculated->from, $calculated->to])->where([[DB::raw('WEEKDAY(date)'), '<', 5]])->join('employees',function($join){
            $join->on('raws.acc_id','=','employees.acc_id')
            ->where('employees.is_active','=',1);
        })->orderBy('raws.acc_id','ASC')->orderBy('raws.date','ASC');
        // dd($emp);

        // return Raw::query()->where([[DB::raw('WEEKDAY(date)'), '<', 5]])->orderBy('acc_id','ASC')->orderBy('date','ASC');
        // return $emp;
    }

    /**
     * @var Raw $raw
     */
    public function map($raw): array
    {
        return [
            $raw->acc_id,
            $raw->name,
            $raw->date,
            $this->timetable($raw->morning),
            $this->checktime($raw->check_in),
            $this->checktime($raw->check_out)
        ];
    }


    /**
     * @return string
     */
    public function title(): string
    {
        return 'Raw Attendance';
    }

    public function timetable($time){
        if($time == 1){
            return "Morning";
        }else{
            return "Afternoon";
        }
    }
    public function checktime($time){
        if($time == "00:00:00"){
            return "";
        }else{
            return $time;
        }
    }
}
