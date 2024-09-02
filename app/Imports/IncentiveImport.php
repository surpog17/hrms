<?php

namespace App\Imports;

use App\Employee;
use App\Webhr;
use App\WebhrLate;
use App\Merit;
use Exception;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncentiveImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
       
        
        try {
            $webuser = Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first();
            $employees = Employee::where('acc_id', $webuser->acc_id)->first()->id;

            if (!$employees) {
                return null;
            }

            if (!Employee::where('acc_id', $webuser->acc_id)->first()) {
                return null;
            }
            if(!$this->get_merit_type($row[Str::slug('type', '_')])){
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
         $webuser = Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first();
      $merit = Merit::where('employee_id', Employee::where('acc_id', $webuser->acc_id)->first()->id)->where('date', date("Y-m-d"))->where('merit_type_id', $this->get_merit_type($row[Str::slug('type', '_')]))
                ->where('amount_type', $row[Str::slug('amount_type', '_')])->first();
        return Merit::updateOrCreate([
            'employee_id' => Employee::where('acc_id', $webuser->acc_id)->first()->id,
            'date'     => date("Y-m-d"),
            'merit_type_id' => $this->get_merit_type($row[Str::slug('type', '_')]),
           
              'amount_type'     => $row[Str::slug('amount_type', '_')]
              ],
              [ 'remark'     =>$merit? floatval($merit->remark) + $row[Str::slug('bonus', '_')]:$row[Str::slug('bonus', '_')]
              ]
              
        );
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function format_date($date)
    {
        $time = strtotime($date);

        $newformat = date('Y-m-d', $time);

        return $newformat;
    }
    
    public function get_merit_type($type)
    {
        if($type==0){
            return 2;
        }elseif($type==1){
            return 4;
        }elseif($type==2){
            return 3;
        }elseif($type==3){
            return 5;
        }
        elseif($type==4){ 
            return 6;
        }
         elseif($type==5){
            return 9;
        }
          elseif($type==6){
            return 8;
        }
          elseif($type==7){
            return 14;
        }
          elseif($type==8){
            return 15;
        }
          elseif($type==9){
            return 16;
        }
          elseif($type==10){
            return 17;
        }
        
        
        else{
            return null;
        }
    }
}
