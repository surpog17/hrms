<?php

namespace App\Imports;

use App\Raw;
use Exception;
use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MachineImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        // dd($row['id']);
         $employees = Employee::where('acc_id', $row[Str::slug('ID', '_')])->first();
        if($employees){

         Raw::updateOrCreate([
            'acc_id' => $row[Str::slug('ID', '_')],

            'date'     =>  Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[Str::slug('Date Number', '_')])) ,
            'morning'  => 1,
            'afternoon' => 0],['name'   => $row[Str::slug('First Name', '_')] . ' ' . $row[Str::slug('Last Name', '_')],
            'check_in' => $this->checkin($row[Str::slug('Valid', '_')], 0, $row[Str::slug('Actual', '_')]),
            'check_out' => $this->checkout($row[Str::slug('Valid', '_')], 0,  $row[Str::slug('Actual', '_')]),
        ]);
        return Raw::updateOrCreate([
            'acc_id' => $row[Str::slug('ID', '_')],

            'date'     =>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[Str::slug('Date Number', '_')])),
            'morning'  => 0,
            'afternoon' => 1],[ 'name'   => $row[Str::slug('First Name', '_')] . ' ' . $row[Str::slug('Last Name', '_')],
            'check_in' => $this->checkin($row[Str::slug('Valid', '_')], 1 , $row[Str::slug('Actual', '_')]),
            'check_out' => $this->checkout($row[Str::slug('Valid', '_')], 1 , $row[Str::slug('Actual', '_')]),
        ]);
        ;
        }
        else{
            return null;
        }
    }
  public function headingRow(): int
    {
        return 3;
    }

    public function get_morning($punch, $actual) {
        $var = explode(";", $punch);
    if($actual == "13:30-17:30;07:30-12:30"){
        return $var[1];
    }
 
   
        
        return $var[0];
    }

    public function get_afternoon($punch, $actual)
    {
        $var = explode(";", $punch);
          if($actual == "13:30-17:30;07:30-12:30"){
        return count($var) == 2? $var[0] : "";
    }
        return count($var) == 2? $var[1] : "";
    }
    public function checkin($punch, $type, $actual)
    {


        $result = $type == 0? $this->get_morning($punch, $actual) : $this->get_afternoon($punch, $actual);

        $var = explode("-", $result);

        return $var[0];
    }
    public function checkout($punch, $type, $actual)
    {
        $result = $type == 0? $this->get_morning($punch, $actual) : $this->get_afternoon($punch, $actual);
        $var = explode("-", $result);
        
        return count($var) == 2? $var[1] : "";
    }

    public function format_time($time)
    {
        return date("H:i:s", strtotime($time));
    }

}
