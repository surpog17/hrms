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

class MeritImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)

    {
        // dd($row);
        try {
            $employees = Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first()->id;

            if (!$employees) {
                return null;
            }

            if (!Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first()) {
                return null;
            }

        } catch (Exception $e) {
            return null;
        }

        $employee = Employee::where('acc_id', Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first()->acc_id)->first();
        if(!$employee){
            //  return null;
                   dd($row);
        }
        return Merit::updateOrCreate([
            'employee_id' => Employee::where('acc_id', Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first()->acc_id)->first()->id,
            'merit_type_id' => 12],[  'date'     => date("Y-m-d"),
            'amount_type' => 3,
            'remark' => $this->getAmount(Webhr::where('user_name', $row[Str::slug('webhr_username', '_')])->first()->acc_id, $row[Str::slug('variable_total', '_')], $row[Str::slug('variable_ammount', '_')]),
            'type' =>$row[Str::slug('variable_total', '_')],
            'value' =>$row[Str::slug('variable_ammount', '_')],
            'name' => $row[Str::slug('fullname', '_')],
            'vp' => json_encode($row)
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
public function getType($type){
    $value = 0;
    switch($type){
        case "Officers/Engineers":
            $value = 1;
            break;
        case "Team leads":
            $value = 2;
            break;
        case "Managers":
            $value = 2;
            break;
        case "Drivers and Janitors":
            $value = 1;
            break;
    defualt:
        $value = 0;
        break;
    }
    return $value;
}
public function getAmount($id, $percent, $amount){
  $emp = Employee::where('acc_id', $id)->first();
  $gross = ($emp->basic_salary * 0.15 + $emp->basic_salary)/ (100 - $percent);
  $vp = $gross *$amount;

    return $vp;
}
    public function format_date($date)
    {
        $time = strtotime($date);

        $newformat = date('Y-m-d', $time);

        return $newformat;
    }


}
