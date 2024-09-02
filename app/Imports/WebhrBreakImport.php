<?php
namespace App\Imports;

use App\Employee;
use App\Webhr;
use App\WebhrBreak;
use App\WebhrAbsent;
use App\WebhrLate;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WebhrBreakImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            
            $employee = Webhr::where('user_name', $row[Str::slug('User Name', '_')])->first();
            if (!$employee) {
                return null; // Skip processing if employee not found
            }

            $acc_id = $employee->acc_id;

            if (!Employee::where('acc_id', $acc_id)->exists()) {
                return null; // Skip processing if corresponding employee not found
            }
            
            if($row[Str::slug('Break-Out Time', '_')] == '-' || $row[Str::slug('Break-in Time', '_')] == '-'){
                return WebhrAbsent::updateOrCreate([
                    'employee_id' => Employee::where('acc_id', $acc_id)->first()->id,
                    'date'        => $this->formatDate($row[Str::slug('Date', '_')]),
                    'validated' => 1
                ]);
            }else if($row[Str::slug('Late By Break-In (HH::MM)', '_')] == '-'){
                return null;
            }else {
                 return WebhrLate::updateOrCreate([
                    'employee_id' => Employee::where('acc_id', $acc_id)->first()->id,
                    'date'        => $this->formatDate($row[Str::slug('Date', '_')]),
                    'validated' => 1,
                    'type' => 'Lunch',
                    ], [
                        'late'     => $row[Str::slug('Late By Break-In (HH::MM)', '_')],
                    ]);
            }
       
        } catch (\Exception $e) {
            // Log or handle the exception if needed
            return null;
        }
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 2; // Assuming the header row is at index 1 (the first row)
    }

    public function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
