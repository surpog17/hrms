<?php

namespace App\Imports;

use App\Raw;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class RawsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        
        if( !is_numeric((int)$row[Str::slug('AC-No.', '_')])){
            return null;
        }
        
        if (Raw::where([['acc_id', $row[Str::slug('AC-No.', '_')]], ['date', $this->format_date($row[Str::slug('Date', '_')])], ['morning', $this->get_morning($row[Str::slug('Timetable', '_')])]])->exists() or Raw::where([['acc_id', $row[Str::slug('AC-No.', '_')]], ['date', $this->format_date($row[Str::slug('Timetable', '_')])], ['afternoon', $this->get_afternoon($row[Str::slug('Timetable', '_')])]])->exists()) {
            return null;
        }
        
        

        return new Raw([
            'acc_id'     => $row[Str::slug('AC-No.', '_')],
            'name'     => $row[Str::slug('Name', '_')],
            'date'     => $this->format_date($row[Str::slug('Date', '_')]),
            'morning'  => $this->get_morning($row[Str::slug('Timetable', '_')]),
            'afternoon' => $this->get_afternoon($row[Str::slug('Timetable', '_')]),
            'check_in'     => $this->format_time($row[Str::slug('Clock In', '_')]),
            'check_out'     => $this->format_time($row[Str::slug('Clock Out', '_')]),
        ]);
    }

    public function get_morning($morning)
    {
        if ($morning == "Morning") {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_afternoon($afternoon)
    {
        if ($afternoon == "Afternoon") {
            return 1;
        } else {
            return 0;
        }
    }

    public function format_date($date)
    {
        $time = strtotime($date);

        $newformat = date('Y-m-d', $time);
        // dd($newformat);

        return $newformat;
    }

    public function format_time($time)
    {

        return date("H:i:s", strtotime($time));
    }
}
