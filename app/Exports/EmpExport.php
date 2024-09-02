<?php

namespace App\Exports;


use App\Webhr;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;

class EmpExport implements WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */


     public function registerEvents(): array
     {
         return [
             BeforeWriting::class => function(BeforeWriting $event) {
             
                $sheet = $event->writer->getSheetByIndex(0);

                $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
             },
         ];
     }
     private function populateSheet($sheet){

        // Populate the static cells


        // Create the collection based on received ids
        $webhrs = Webhr::where('status', 'Active')->get();
     

        // Party starts at row 3
        $sheet->setCellValue('A1', 'Employee ID');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Department Name');
       
        

        $iteration = 3;
        $sheet->getDelegate()->getComment('A1')->getText()->createTextRun('Field name,primary key?unique?allow null values?(pin,true,false,false) Personnel ID can not start with zero!');
        $sheet->getDelegate()->getComment('B1')->getText()->createTextRun('Field name,primary key?unique?allow null values?(name,false,false,true)');
        $sheet->getDelegate()->getComment('C1')->getText()->createTextRun('Field name,primary key?unique?allow null values?(lastName,false,false,true)');
        $sheet->getDelegate()->getComment('D1')->getText()->createTextRun('Field name,primary key?unique?allow null values?(deptCode,false,false,true)');
     
       

        foreach ($webhrs as $ab) {

            // Create cell definitions
            $A = "A".($iteration);
            $B = "B".($iteration);
            $C = "C".($iteration);
            $D = "D".($iteration);
           


            // Populate dynamic content


            $sheet->setCellValue($A, $ab->acc_id);
            $sheet->setCellValue($B , $this->firstname($ab->full_name));
            $sheet->setCellValue($C, $this->lastname($ab->full_name));
            $sheet->setCellValue($D, 'Existing Employee');
        
           

            $cellRangeTarget = $A.':'.$D;

            // Copy style of Row 3 onto new rows - RowHeight is not being copied, need to adjust manually...
            if($iteration > 2)
            {
                $sheet->duplicateStyle($sheet->getStyle('A2'), $cellRangeTarget);

            }

            $iteration++;
        }

    }

    public function firstname($str)
    {
        $var  = explode(" ", $str);
        return $var[0];
    }
    public function lastname($str)
    {
        $var  = explode(" ", $str);
        return $var[1];
    }
    public function subcity($str)
    {
        $var = explode(",", $str);
        return $var[0];
    }
    public function woreda($str)
    {
        $var = explode(",", $str);
        return $var[1];
    }
    public function house($str)
    {
        $var = explode(",", $str);
        return $var[2];
    }
}
