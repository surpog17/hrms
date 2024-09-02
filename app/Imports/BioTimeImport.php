<?php

namespace App\Imports;

use App\Raw;
use App\WebhrLate;
use Exception;
use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BioTimeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // return $row;
        // dd($row);
         $employees = Employee::where('acc_id', $row[Str::slug('Employee ID', '_')])->first();
        if($employees){
      
         Raw::updateOrCreate([
            'acc_id' => $row[Str::slug('Employee ID', '_')],

            'date'     =>  $row[Str::slug('Date', '_')] ,
            'morning'  => 1,
            'afternoon' => 0],['name'   => $row[Str::slug('First Name', '_')] ,
            'check_in' => $row[Str::slug('Clock In', '_')],
            'check_out' =>$row[Str::slug('Break Out', '_')],
        ]);
        if($this->getLunchLate($row[Str::slug('Break Hours', '_')], $row[Str::slug('Break Total Hours', '_')]) != -1){
          WebhrLate::updateOrCreate([
            'employee_id' =>$employees->id,
            'date'     => $row[Str::slug('Date', '_')],
            'validated' => 1
        ], [
            'lunch_late'     => $this->getLunchLate($row[Str::slug('Break Hours', '_')], $row[Str::slug('Break Total Hours', '_')]),
          
        ]);
        }
     return Raw::updateOrCreate([
            'acc_id' => $row[Str::slug('Employee ID', '_')],

            'date'     =>$row[Str::slug('Date', '_')],
            'morning'  => 0,
            'afternoon' => 1],[ 'name'   => $row[Str::slug('First Name', '_')] ,
           'check_in' => $row[Str::slug('Break In', '_')],
            'check_out' =>$row[Str::slug('Clock Out', '_')],
        ]);
        
        }
        else{
            return null;
        }
    }
  public function headingRow(): int
    {
        return 3;
    }

  
public function getLunchLate($break, $duration){
  
    if(date("H:i", strtotime($break)) > date("H:i", strtotime($duration))){
          return  date("H:i", strtotime($break) - strtotime($duration));
    }
  else{
      return -1;
  }
}
    public function format_time($time)
    {
        return date("H:i:s", strtotime($time));
    }

}
