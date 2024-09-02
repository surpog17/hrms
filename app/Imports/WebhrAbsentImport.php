<?php

namespace App\Imports;

use App\Employee;
use App\Webhr;
use App\WebhrAbsent;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class WebhrAbsentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {

            $employees = Webhr::where('user_name', $row[Str::slug('User Name', '_')])->first()->acc_id;

            // dd($employees);


            if (!$employees) {
                return null;
            }

            if (!Employee::where('acc_id', $employees)->first()) {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
        return WebhrAbsent::updateOrCreate([
            'employee_id' => Employee::where('acc_id', $employees)->first()->id,
            'date'     => $this->format_date($row[Str::slug('Date', '_')]),
            'validated' => 1
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function format_date($date)
    {
        $time = strtotime($date);

        $newformat = date('Y-m-d', $time);

        return $newformat;
    }
}
