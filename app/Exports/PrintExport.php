<?php

namespace App\Exports;

use App\Webhr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrintExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ['ID', 'Full Name', 'Position', 'Phone Number', 'Sub City', 'Woreda', 'Home Number', 'DOB'];
    }
    public function query()
    {
        return Webhr::query()->select('acc_id', 'full_name',  'phone_no', 'designation', 'address', 'dob')->where('status', 'Active');
    }
    public function map($ab): array
    {

        return [
            $ab->acc_id,
            $ab->full_name,
            
            $ab->designation,
            $ab->phone_no,
            $ab->address == null ? ' ' : $this->subcity($ab->address),
            $ab->address == null ? ' ' : $this->woreda($ab->address),
            $ab->address == null ? ' ' : $this->house($ab->address),
            $ab->dob,
        ];
    }
    public function subcity($str)
    {
        $var = explode(",", $str);
       if(array_key_exists(0, $var)){
           return $var[0];
       }
       else{
           return " ";
       }
        
    }
    public function woreda($str)
    {
        $var = explode(",", $str);
         if(array_key_exists(1, $var)){
           return $var[1];
       }
       else{
           return " ";
       }
    }
    public function house($str)
    {
        $var = explode(",", $str);
        if(array_key_exists(2, $var)){
           return $var[2];
       }
       else{
           return " ";
       }
    }
}
