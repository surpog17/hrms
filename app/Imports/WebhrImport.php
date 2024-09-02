<?php

namespace App\Imports;

use App\Webhr;
use Exception;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;

class WebhrImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

            if (Webhr::where('user_name', $row[Str::slug('User Name', '_')])->exists() ) {
                return  Webhr::updateOrCreate(['user_name'     => $row[Str::slug('User Name', '_')]],[
            
             'webhr_id'     => $row[Str::slug('S#', '_')],
            
            'full_name'     => $row[Str::slug('Employee Name', '_')] ,
            'email'     => $row[Str::slug('Email Address', '_')],
            'designation' => $row[Str::slug('Designation', '_')],
            'type' => $row[Str::slug('Type', '_')],
            'department' => $row[Str::slug('Department', '_')],
            'status' => $row[Str::slug('Status', '_')],
            'phone_no' => $row[Str::slug('Mobile Number', '_')],
            'address' => $row[Str::slug('Notes', '_')],
            'dob' => $row[Str::slug('Date of Birth', '_')],
            'joining_date' => $row[Str::slug('Joining Date', '_')]
             
        ]);
            }
        // dd($row[Str::slug('User Name', '_')]);

        return new Webhr([
            //
             'webhr_id'     => $row[Str::slug('S#', '_')],
            'user_name'     => $row[Str::slug('User Name', '_')],
            'full_name'     => $row[Str::slug('Employee Name', '_')] ,
            'email'     => $row[Str::slug('Email Address', '_')],
            'designation' => $row[Str::slug('Designation', '_')],
            'type' => $row[Str::slug('Type', '_')],
            'department' => $row[Str::slug('Department', '_')],
            'status' => $row[Str::slug('Status', '_')],
            'phone_no' => $row[Str::slug('Mobile Number', '_')],
            'address' => $row[Str::slug('Notes', '_')],
            'dob' => $row[Str::slug('Date of Birth', '_')],
            'joining_date' => $row[Str::slug('Joining Date', '_')],
            'acc_id' => Webhr::max('acc_id') + 1
             
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
