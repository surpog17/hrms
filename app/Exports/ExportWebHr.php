<?php

namespace App\Exports;

use App\Raw;
use App\Time;
use App\Webhr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportWebHr implements FromQuery, WithHeadings, WithMapping
{

    public function headings(): array
    {
        return [
            'Username',
            'Date',
            'Time In',
            'Time Out',
            'Lunch Break Out',
            'Lunch Break In',
        ];
    }

    public function query()
    {
        $time = Time::all()->first();
        $start = $time->from;
        $end = $time->to;
      
        return Raw::query()->select( 'raws.date', 'raws.acc_id')->whereBetween('raws.date', [$start, $end])->distinct();
    }

    /**
     * @var Absent $ab
     */
    public function map($ab): array
    {

        if ($this->timein($ab->date, $ab->acc_id) == "" && $this->timeout($ab->date, $ab->acc_id) == "" && $this->breakout($ab->date, $ab->acc_id) == "" && $this->breakin($ab->date, $ab->acc_id) == "") {
            return array(NULL);
        }

        return [
            Webhr::where('acc_id', $ab->acc_id)->first()?Webhr::where('acc_id', $ab->acc_id)->first()->user_name:'',
            $ab->date,
            $this->morningtimein($ab->date, $ab->acc_id),
            $this->timeout($ab->date, $ab->acc_id),
            $this->breakout($ab->date, $ab->acc_id),
            $this->breakin($ab->date, $ab->acc_id),

        ];
    }

    public function timein($date, $id)
    {

        $raw = Raw::where([['date', $date], ['acc_id', $id], ['morning', 1]])->first();
        if($raw){
            return $this->checktime($raw->check_in);
        }

       
    }
    public function morningtimein($date, $id)
    {

        $raw = Raw::where([['date', $date], ['acc_id', $id], ['morning', 1]])->first();
        if($raw){
            return $this->morningchecktime($raw->check_in);
        }
      
    }
    public function timeout($date, $id)
    {

        $raw = Raw::where([['date', $date], ['acc_id', $id], ['afternoon', 1]])->first();
        if($raw){
            return $this->checktime($raw->check_out);
        }
       
    }

    public function breakin($date, $id)
    {

        $raw = Raw::where([['date', $date], ['acc_id', $id], ['afternoon', 1]])->first();
        if($raw){
            return $this->checktime($raw->check_in);
        }
       
    }

    public function breakout($date, $id)
    {

        $raw = Raw::where([['date', $date], ['acc_id', $id], ['morning', 1]])->first();
        if($raw){
            return $this->checktime($raw->check_out);
        }

       
    }


    public function checktime($time)
    {
        if ($time == "00:00:00") {
            return "";
        } else {
            return $time;
        }
    }

    public function morningchecktime($time)
    {
        if ($time == "00:00:00") {
            return "10:30:00";
        } else {
            return $time;
        }
    }
}
