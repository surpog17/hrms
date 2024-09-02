<?php

namespace App\Http\Controllers;

use App\Award;
use App\Calculated;
use App\Category;
use App\Deduct;
use App\Employee;
use App\Webhr;
use App\Loan;
use App\Merit;
use App\MeritType;
use App\Morning;
use App\NewResign;
use App\Payroll;
use App\Warning;
use DateTime;
use \NumberFormatter;
use Exception;
use App\Medicalinsurance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\TblWidth;

class WordController extends Controller
{
    //
    public function createWordDocx($start = null, $end = null)
    {
        $template = new TemplateProcessor('payrolltemplate.docx');
        $template->setValue('date', date('d F, Y (l)', strtotime($end)));
        $template->setValue('name', 'Eyerusalem');
        $template->setValue('month', date('F', strtotime($start)));
        $template->setValue('year', date('Y', strtotime($start)));
        $warning = Warning::whereBetween('date', [$start, $end])->get();
        $values = array();
        foreach ($warning as $war) {
            if (!$war->excuse) {
                $warningtext = "--- Formal Reminder ---";
                 if ($war->action && $war->type_id == 1) {
                    $warningtext = $war->action . ' Day Salary';
                }
                $val = array(
                    "userId" => $war->employee->full_name,
                    "userName" => $warningtext,
                    "userAddress" => $war->remark
                );
                $values[] = $val;
            }
            // $values = [
            //     ['userId' => 1, 'userName' => 'Batman', 'userAddress' => 'Gotham City'],
            //     ['userId' => 2, 'userName' => 'Superman', 'userAddress' => 'Metropolis'],
            // ];
        }

        // ($values);

        $template->cloneRowAndSetValues('userId', $values);

        $merit_type = MeritType::where('name', 'Exam')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "examuserId" => $e->employee->full_name,
                "examuserName" => $e->date,
                "examuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
       
        $template->cloneRowAndSetValues('examuserId', $exam_m);
        
        // cash collection type
        
          $merit_type = MeritType::where('name', 'Cash Collection')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $cashc = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "cashcid" => $e->employee->full_name,
                "cashcd" => $e->date,
                "cashcamount" => $remark
            );
            $cashc[] = $val;
        }
       
        $template->cloneRowAndSetValues('cashcid', $cashc);
        


        
        
         // Ops incentive
        
          $merit_type = MeritType::where('name', 'Operation Incentive')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $opsi = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            
            $val = array(
                "opsiid" => $e->employee->full_name,
                "opsid" => $e->date,
                "opsiamount" => $remark
            );
            $opsi[] = $val;
        }
       
        $template->cloneRowAndSetValues('opsiid', $opsi);
        
        
          // admin incentive
        
          $merit_type = MeritType::where('name', 'Admin Incentive')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $admini = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "adminiid" => $e->employee->full_name,
                "adminid" => $e->date,
                "adminiamount" => $remark
            );
            $admini[] = $val;
        }
        
       
        $template->cloneRowAndSetValues('adminiid', $admini);
        
        //Operation Leadership Incentive
        
        
        
          $merit_type = MeritType::where('name', 'Operation Leadership Incentive')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $opli = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "opliid" => $e->employee->full_name,
                "oplid" => $e->date,
                "opliamount" => $remark
            );
            $opli[] = $val;
        }
        
       
        $template->cloneRowAndSetValues('opliid', $opli);
        
        
        
        
        
        
        
        
        
        //loyalty program
         $merit_type = MeritType::where('name', 'Loyalty Program')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
           
            $val = array(
                "loyaltyid" => $e->employee->full_name,
                "loyaltydate" => $e->date,
                "loyaltyamount" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('loyaltyid', $exam_m);
        

        $merit_type = MeritType::where('name', 'Implementation Effectiveness Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "iebuserId" => $e->employee->full_name,
                "iebuserName" => $e->date,
                "iebuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('iebuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Effective Order and Delivery Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "eodbuserId" => $e->employee->full_name,
                "eodbuserName" => $e->date,
                "eodbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('eodbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Closed Deals Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "cdbuserId" => $e->employee->full_name,
                "cdbuserName" => $e->date,
                "cdbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('cdbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Management Performance Evaluation Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "mpeqbuserId" => $e->employee->full_name,
                "mpeqbuserName" => $e->date,
                "mpeqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('mpeqbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Staff Performance Evaluation Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "speqbuserId" => $e->employee->full_name,
                "speqbuserName" => $e->date,
                "speqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('speqbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Timely VAT Collection Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "tvcqbuserId" => $e->employee->full_name,
                "tvcqbuserName" => $e->date,
                "tvcqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('tvcqbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Timely Payment Collection Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "tpcqbuserId" => $e->employee->full_name,
                "tpcqbuserName" => $e->date,
                "tpcqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('tpcqbuserId', $exam_m);

        $merit_type = MeritType::where('name', 'Best Employees Productivity and Engagement Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
            $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
           
            $val = array(
                "bepeqbuserId" => $e->employee->full_name,
                "bepeqbuserName" => $e->date,
                "bepeqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('bepeqbuserId', $exam_m);


        $merit_type = MeritType::where('name', 'Facilities High Availability Quarterly Bonus')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "fhaqbuserId" => $e->employee->full_name,
                "fhaqbuserName" => $e->date,
                "fhaqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('fhaqbuserId', $exam_m);
        
        //allowance
        
         $merit_type = MeritType::where('name', 'Allowance')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        $exam_m = array();
        foreach ($exam_merit as $e) {
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            $val = array(
                "alhaqbuserId" => $e->employee->full_name,
                "alhaqbuserName" => $e->date,
                "alhaqbuserAddress" => $remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('alhaqbuserId', $exam_m);


        $merit_type = MeritType::where('name', 'Variable Pay')->first();
        $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
        
        $exam_m = array();
        foreach ($exam_merit as $e) {
            
              $remark = "ETB " . $e->remark;
            if($e->amount_type == 1){
                 $remark =  $e->remark . " Days of Salary";
            }
            // if(!$e->employee){
            //     dd($e);
            // }
            $val = array(
                "allowanceuserId" => $e->employee,
                "allowanceuserId" => isset($e->employee->first_name) ? $e->employee->first_name :"unkown allowance user",
                "allowancepercent" => $e->type,
                "allowanceactual" =>$e->value,
                "allowanceuserAddress" => "ETB " . $e->remark
            );
            $exam_m[] = $val;
        }
        // ($exam_m);
        $template->cloneRowAndSetValues('allowanceuserId', $exam_m);


        $medical_type = Category::where('name', 'Medical')->first();
        $medical_merit = Loan::where('category_id', $medical_type->id)->whereBetween('date', [$start, $end])->get();
        $medical_m = array();
        foreach ($medical_merit as $e) {
            $emp = Employee::find($e->employee_id);
            $mi = Medicalinsurance::find(4);
            $companyrate = 0;
            $userrate = 1;
            if($emp){
                 $mi = Medicalinsurance::find($emp->medical_insurance);
                 $userrate = $mi->useramount/100;
                
             $companyrate= $mi->companyamount/100;
                
            }
            
            $val = array(
                "medicaluserId" => $e->employee->full_name,
                "medicaluserName" => $e->current_amount * $userrate,
                "medicaluserAddress" => $e->current_amount * $companyrate,
                "medicaltype" => round($userrate * 100, 0). '%'
            );
            $medical_m[] = $val;
        }

        $template->cloneRowAndSetValues('medicaluserId', $medical_m);
        // $template->cloneRow('anotheruserId', 5);

        $resigned_type = NewResign::where('remark', 0)->whereBetween('date', [$start, $end])->get();
        $resigned_m = array();
        foreach ($resigned_type as $e) {
            $val = array(
                "resigneduserId" => $e->employee->full_name,
                "resigneduserName" => $e->date
            );
            $resigned_m[] = $val;
        }

        $template->cloneRowAndSetValues('resigneduserId', $resigned_m);

        $new_type = NewResign::where('remark', 1)->whereBetween('date', [$start, $end])->get();
        $new_m = array();
        foreach ($new_type as $e) {
            $val = array(
                "newuserId" => $e->employee->full_name,
                "newuserName" => $e->date
            );
            $new_m[] = $val;
        }

        $template->cloneRowAndSetValues('newuserId', $new_m);

        $cat = Category::where('name', 'Loan')->first();
        $employee = Loan::where('category_id', $cat->id)->select('employee_id', 'total_amount', 'current_amount')->groupBy('employee_id')->get();

        // ($employee);
        $total = array();
        $loan_m = array();
        foreach ($employee as $emp) {

            $loan = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->get();
            $t = array(
                "loanuserId" => $emp->employee->full_name,
                "loanuserName" => $emp->total_amount,
                "loancurrent" => $emp->current_amount,
                "loanuserAddress" => null,
                "loanpaid" => null,
                "loanremainamount" => null


            );
            $total[] = $t;
            foreach ($loan as $l) {

                $date = $l->date;

                $val = array(
                    "loanuserId" => null,
                    "loanuserName" => null,
                    "loancurrent" => null,
                    "loanuserAddress" => date('F, Y', strtotime($date)),
                    "loanpaid" => $l->paid_amount,
                    "loanremainamount" => $l->remaining_amount
                );
                $loan_m[] = $val;
                $total[] = $val;
            }
            // ($loan_m);

            // $total[] = $t;
        }
        // ($total);

        // ($loan_m);
        $template->cloneRowAndSetValues('loanuserId', $total);

        $cat = Category::where('name', 'Training Payment')->first();
        $employee = Loan::where('category_id', $cat->id)->select('employee_id', 'total_amount', 'current_amount')->groupBy('employee_id')->get();
        // ($employee);
        $total = array();
        $loan_m = array();
        $val = array();
        $t = array();
        foreach ($employee as $emp) {

            $loan = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->get();
            $t = array(
                "examloanuserId" => $emp->employee->full_name,
                "examloanuserName" => $emp->total_amount,
                "examloancurrent" => $emp->current_amount,
                "examloanuserAddress" => null,
                "examloanpaid" => null,
                "examloanremainamount" => null


            );
            $total[] = $t;
            foreach ($loan as $l) {

                $date = $l->date;

                $val = array(
                    "examloanuserId" => null,
                    "examloanuserName" => null,
                    "examloancurrent" => null,
                    "examloanuserAddress" => date('F, Y', strtotime($date)),
                    "examloanpaid" => $l->paid_amount,
                    "examloanremainamount" => $l->remaining_amount
                );
                $loan_m[] = $val;
                $total[] = $val;
            }
            // ($loan_m);

            // $total[] = $t;
        }
        // ($total);

        // ($loan_m);
        $template->cloneRowAndSetValues('examloanuserId', $total);

        $cat = Category::where('name', 'Car Maintenance')->first();
        $employee = Loan::where('category_id', $cat->id)->select('employee_id', 'total_amount', 'current_amount')->groupBy('employee_id')->get();
        // ($employee);
        $total = array();
        $loan_m = array();
        $val = array();
        $t = array();
        foreach ($employee as $emp) {

            $loan = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->get();
            $t = array(
                "carloanuserId" => $emp->employee->full_name,
                "carloanuserName" => $emp->total_amount,
                "carloancurrent" => $emp->current_amount,
                "carloanuserAddress" => null,
                "carloanpaid" => null,
                "carloanremainamount" => null


            );
            $total[] = $t;
            foreach ($loan as $l) {

                $date = $l->date;

                $val = array(
                    "carloanuserId" => null,
                    "carloanuserName" => null,
                    "carloancurrent" => null,
                    "carloanuserAddress" => date('F, Y', strtotime($date)),
                    "carloanpaid" => $l->paid_amount,
                    "carloanremainamount" => $l->remaining_amount
                );
                $loan_m[] = $val;
                $total[] = $val;
            }
            // ($loan_m);

            // $total[] = $t;
        }
        // ($total);

        // ($loan_m);
        $template->cloneRowAndSetValues('carloanuserId', $total);



        $cat = Category::where('name', 'PMA')->first();
        $employee = Loan::where('category_id', $cat->id)->select('employee_id', 'total_amount', 'current_amount')->groupBy('employee_id')->get();
        // ($employee);
        $total = array();
        $loan_m = array();
        $val = array();
        $t = array();
        foreach ($employee as $emp) {

            $loan = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->get();
            $t = array(
                "pmaloanuserId" => $emp->employee->full_name,
                "pmaloanuserName" => $emp->total_amount,
                "pmaloancurrent" => $emp->current_amount,
                "pmaloanuserAddress" => null,
                "pmaloanpaid" => null,
                "pmaloanremainamount" => null


            );
            $total[] = $t;
            foreach ($loan as $l) {

                $date = $l->date;

                $val = array(
                    "pmaloanuserId" => null,
                    "pmaloanuserName" => null,
                    "pmaloancurrent" => null,
                    "pmaloanuserAddress" => date('F, Y', strtotime($date)),
                    "pmaloanpaid" => $l->paid_amount,
                    "pmaloanremainamount" => $l->remaining_amount
                );
                $loan_m[] = $val;
                $total[] = $val;
            }
            // ($loan_m);

            // $total[] = $t;
        }
        // ($total);

        // ($loan_m);
        $template->cloneRowAndSetValues('pmaloanuserId', $total);

        //Un Paid Leave
        $cat = Category::where('name', 'leave')->first();
        $employee = Loan::where('category_id', $cat->id)->select('employee_id', 'total_amount', 'current_amount')->groupBy('employee_id')->get();
        // ($employee);
        $total = array();
        $loan_m = array();
        $val = array();
        $t = array();
        foreach ($employee as $emp) {

            $loan = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->get();
            $totalammoount = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->sum('total_amount');
            $currentammoount = Loan::where([['employee_id', $emp->employee_id], ['category_id', $cat->id]])->orderBy('date', 'ASC')->sum('current_amount');
            $t = array(
                "leaveloanuserId" => $emp->employee,
                "leaveloanuserId" => isset($emp->employee->first_name) ? $emp->employee->first_name : "unknown loan user",
                "leaveloanuserName" => $totalammoount . " Days of Salary",
                "leaveloancurrent" => $currentammoount . " Days of Salary",
                "leaveloanuserAddress" => null,
                "leaveloanpaid" => null,
                "leaveloanremainamount" => null


            );
            $total[] = $t;
            foreach ($loan as $l) {

                $date = $l->date;

                $val = array(
                    "leaveloanuserId" => null,
                    "leaveloanuserName" => null,
                    "leaveloancurrent" => null,
                    "leaveloanuserAddress" => date('F, Y', strtotime($date)),
                    "leaveloanpaid" => $l->paid_amount . " Days of Salary",
                    "leaveloanremainamount" => $l->remaining_amount . " Days of Salary"
                );
                $loan_m[] = $val;
                $total[] = $val;
            }
            // ($loan_m);

            // $total[] = $t;
        }
        // ($total);

        // ($loan_m);
        $template->cloneRowAndSetValues('leaveloanuserId', $total);





        $title = new TextRun();
        $title->addText('This title has been set ', array('bold' => true, 'italic' => true, 'color' => 'blue'));
        $title->addText('dynamically', array('bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single'));
        $template->setComplexBlock('title', $title);

        $inline = new TextRun();
        $inline->addText('by a red italic text', array('italic' => true, 'color' => 'red'));
        $template->setComplexValue('inline', $inline);

        // $table = new Table(array('borderSize' => 12, 'borderColor' => 'green', 'width' => 6000, 'unit' => TblWidth::TWIP));
        // $table->addRow();
        // $table->addCell(150)->addText('Cell A1');
        // $table->addCell(150)->addText('Cell A2');
        // $table->addCell(150)->addText('Cell A3');
        // $table->addRow();
        // $table->addCell(150)->addText('Cell B1');
        // $table->addCell(150)->addText('Cell B2');
        // $table->addCell(150)->addText('Cell B3');
        // $template->setComplexBlock('table', $table);


        $template->saveAs('Sample_07_TemplateCloneRow.docx');
    }

    public function downloadWordDocx(Request $req)
    {

        $array = explode('-', $req->daterange);
        $start = trim($array[0]);
        $time = strtotime($start);

        $newstart = date('Y-m-d', $time);
        $end = trim($array[1]);
        $endtime = strtotime($end);
        $newend = date('Y-m-d', $endtime);

        Deduct::truncate();
        Award::truncate();
        $this->createWordDocx($newstart, $newend);
        $val = 0;
        if ($req->pay == "on") {
            $warning = Warning::whereBetween('date', [$newstart, $newend])->get();
            // ($warning);
            foreach ($warning as $w) {
                $emp = Employee::find($w->employee_id);
                if ($emp->basic_salary && !$w->excuse) {
                    if ($w->type->name == "Absent") {
                        if(is_numeric($w->action) && $w->action > 0){
                            $amt = 0;
                            if(Deduct::where('employee_id',$emp->id)->first()){
                                $amt = (float) Deduct::where('employee_id',$emp->id)->first()->absent;
                                $amt += ((($emp->basic_salary * 1.15) * $w->action) / 30);
                            }else{
                                $amt = 0;
                                $amt += ((($emp->basic_salary * 1.15) * $w->action) / 30);
                            }
                            
                            
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "absent" => $amt 
                            ]);
                        }elseif($w->action == "1/4"){
                            $amt = 0;
                            if(Deduct::where('employee_id',$emp->id)->first()){
                                $amt = (float) Deduct::where('employee_id',$emp->id)->first()->absent;
                                $amt += ((($emp->basic_salary * 1.15) * 0.25) / 30);
                            }else{
                                $amt = 0;
                                $amt += ((($emp->basic_salary * 1.15) * 0.25) / 30);
                            }
                            
                            
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "absent" => $amt 
                            ]);
                        }elseif($w->action == "1/2"){
                            $amt = 0;
                            if(Deduct::where('employee_id',$emp->id)->first()){
                                $amt = (float) Deduct::where('employee_id',$emp->id)->first()->absent;
                                $amt += ((($emp->basic_salary * 1.15) * 0.5) / 30);
                            }else{
                                $amt = 0;
                                $amt += ((($emp->basic_salary * 1.15) * 0.5) / 30);
                            }
                            
                            
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "absent" => $amt 
                            ]);
                        }
                    } 
                    else {
                        if(is_numeric($w->action) && $w->action > 0){
                            if(Deduct::where('employee_id',$emp->id)->first()){
                            $lte = (float) Deduct::where('employee_id',$emp->id)->first()->latecommer;
                            }else{
                                $lte=0;
                            }
                            
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "latecommer" => ($lte+((($emp->basic_salary * 1.15) * $w->action) / 30))
                            ]);
                        }elseif($w->action == "1/4"){
                            if(Deduct::where('employee_id',$emp->id)->first()){
                                $lte = (float) Deduct::where('employee_id',$emp->id)->first()->latecommer;
                            }else{
                                $lte=0;
                            }
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "latecommer" => ($lte+((($emp->basic_salary * 1.15) * 0.25) / 30))
                            ]);

                        }elseif($w->action == "1/2"){
                            if(Deduct::where('employee_id',$emp->id)->first()){
                                $lte = (float) Deduct::where('employee_id',$emp->id)->first()->latecommer;
                            }else{
                                $lte=0;
                            }
                            
                            Deduct::updateOrCreate([
                                'employee_id' => $emp->id
                            ], [
                                "latecommer" => ($lte+((($emp->basic_salary * 1.15) * 0.5) / 30))
                            ]);

                        }
                    }
                }
            } 
            $merit_type = MeritType::where('name', 'Exam')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                if(is_numeric($m->remark) && $m->remark > 0){
                    Award::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "exam_bonus" => $m->remark
                    ]);
                }
            }
            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Implementation Effectiveness Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "ieb" => $value
                        ]);
                    }
                };
            }
            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Cash Collection')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "cashcollection" => $value
                        ]);
                    }
                };
            }
            

             $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Operation Incentive')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "operationincentive" => $value
                        ]);
                    }
                };
            }
            
            

             $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Admin Incentive')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "adminincentive" => $value
                        ]);
                    }
                };
            }
             $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Operation Leadership Incentive')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "operationleadership" => $value
                        ]);
                    }
                };
            }
            
            
            
            
            
            
            $merit_type = null;
            $exam_merit = null;

            $merit_type = MeritType::where('name', 'Effective Order and Delivery Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
               
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "eodb" => $value
                        ]);
                    }
                };
            }
            
            //allowance
             $merit_type = null;
            $exam_merit = null;

            $merit_type = MeritType::where('name', 'Allowance')->first();
            
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
           
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
          
               
                if ($emp->basic_salary) {
                    
                  
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "position_allowance" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Closed Deals Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "cdb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Management Performance Evaluation Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "mpeqb" => $value
                        ]);
                    }
                };
            }
            
            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Loyalty Program')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
         
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "mpeqb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Staff Performance Evaluation Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "speqb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Timely VAT Collection Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "tvcqb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Timely Payment Collection Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "tpcqb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Best Employees Productivity and Engagement Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "bepeqb" => $value
                        ]);
                    }
                };
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Facilities High Availability Quarterly Bonus')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();
            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);
                 $value = $m->remark;
            if($m->amount_type == 1){
                 $value =  (($emp->basic_salary * 1.15) * $m->remark) / 30;
            }
                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "fhaqb" => $value
                        ]);
                    }
                }
            }

            $merit_type = null;
            $exam_merit = null;
            $merit_type = MeritType::where('name', 'Variable Pay')->first();
            $exam_merit = Merit::where('merit_type_id', $merit_type->id)->get();

            foreach ($exam_merit as $m) {
                $emp = Employee::find($m->employee_id);

                if ($emp->basic_salary) {
                    if(is_numeric($m->remark) && $m->remark > 0){
                        Award::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "allowance" => $m->remark
                        ]);
                    }
                };
            }
            
            
          

            $medical_type = Category::where('name', 'Medical')->first();
            $medical_merit = Loan::where('category_id', $medical_type->id)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($medical_merit as $m) {
                  $emp = Employee::find($m->employee_id);
            $mi = Medicalinsurance::find(4);
            $companyrate = 0;
            $userrate = 1;
            if($emp){
                 $mi = Medicalinsurance::find($emp->medical_insurance);
                 $userrate = $mi->useramount/100;
                
             $companyrate= $mi->companyamount/100;
                
            }
                
                
                
                if(is_numeric($m->current_amount) && $m->current_amount > 0){
                    Deduct::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "medical" => $m->current_amount*$userrate
                    ]);
                }
            }
            $resigned_type = NewResign::where('remark', 0)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($resigned_type as $r) {
                $emp = Employee::find($r->employee_id);
                $emp->update(['is_active', 0]);
            }
            $new_type = NewResign::where('remark', 1)->whereBetween('date', [$newstart, $newend])->get();
            $cat = Category::where('name', 'Loan')->first();
            $loan = Loan::where('category_id', $cat->id)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($loan as $m) {
                if(is_numeric($m->current_amount) && $m->current_amount > 0){
                    Deduct::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "loan" => $m->current_amount
                    ]);
                }
            }
            $examfailcat = Category::where('name', 'Training Payment')->first();
            $examfailloan = Loan::where('category_id', $examfailcat->id)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($examfailloan as $m) {
                if(is_numeric($m->current_amount) && $m->current_amount > 0){
                    Deduct::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "exam" => $m->current_amount
                    ]);
                }
            }
            $maintancecat = Category::where('name', 'Car Maintenance')->first();
            $carmaintanceloan = Loan::where('category_id', $maintancecat->id)->whereBetween('date', [$newstart, $newend])->get();
            // ($carmaintanceloan);
            foreach ($carmaintanceloan as $m) {
                if(is_numeric($m->current_amount) && $m->current_amount > 0){
                    Deduct::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "car" => $m->current_amount
                    ]);
                }
            }
            //made updates here on April 11
            $pmacat = Category::where('name', 'PMA')->first();
            $pmaloan = Loan::where('category_id', $pmacat->id)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($pmaloan as $m) {
                  $total = Loan::where('category_id', $pmacat->id)->whereBetween('date', [$newstart, $newend])->where('employee_id', $m->employee_id)->sum('current_amount');
                if(is_numeric($m->current_amount) && $m->current_amount > 0){
                    Deduct::updateOrCreate([
                        'employee_id' => $m->employee_id
                    ], [
                        "pma" => $total
                    ]);
                }
            }

            $pmacat = Category::where('name', 'leave')->first();
            $pmaloan = Loan::where('category_id', $pmacat->id)->whereBetween('date', [$newstart, $newend])->get();
            foreach ($pmaloan as $m) {
                $valuess = Deduct::where('employee_id', $m->employee_id)->first();
                $v = 0;
                if ($valuess) {
                    if ($valuess->absent) {
                        $v = $valuess->absent;
                    }
                } else { }
                $emp = Employee::find($m->employee_id);
                if ($emp->basic_salary) {
                    if(is_numeric($m->current_amount) && $m->current_amount > 0){
                        Deduct::updateOrCreate([
                            'employee_id' => $m->employee_id
                        ], [
                            "absent" => $v + (($emp->basic_salary * 1.15) * $m->current_amount) / 30
                        ]);
                    }
                }
            }
        };
        $file = "Sample_07_TemplateCloneRow.docx";
        $headers = array('Content-Type: application/msword',);
        return response()->download($file, 'memo.docx', $headers);
    }

    public function memoindex()
    {
        return view('memocalculate');
    }

    public function wordwarning()
    {
        $template = new TemplateProcessor('reprimand.docx');
        $template->setValue('date', "June 02,2012");
        $template->setValue('name', 'Sophonias');
        $template->setValue('position', "Jr. Software Enginneer");
        $template->setValue('ref', '2020/5/89');

        $template->saveAs('reprimandresult.docx');

        // Set PDF renderer.
        // Make sure you have `tecnickcom/tcpdf` in your composer dependencies.
        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        // Path to directory with tcpdf.php file.
        // Rigth now `TCPDF` writer is depreacted. Consider to use `DomPDF` or `MPDF` instead.
        $rendererLibraryPath = base_path('/vendor/tecnickcom/tcpdf');
        Settings::setPdfRendererPath($rendererLibraryPath);

        $phpWord = IOFactory::load('reprimandresult.docx', 'Word2007');
        $phpWord->save('document.pdf', 'PDF');
    }

    public function bankword()
    {
        $template = new TemplateProcessor('banktemplate.docx');
        $nowval = new DateTime();
        $now = $nowval->format('d-m-Y');
        $refv = $nowval->format('ymd');
        $lastmonth =  $nowval->modify('-1 month');
        $nowdate = $nowval->format('d F, Y (l)');
        $template->setValue('date', $now);
        $template->setValue('ref', $refv );
        $template->setValue('bank', 'Enat Bank');
        $template->setValue('branch', 'Mexico Derartu Tulu branch');
        $template->setValue('month', $lastmonth->format('F') ." ". $lastmonth->format('Y'));
        $template->setValue('ieaccount', '0061101660052002');
        
        

        $payroll = Payroll::all();
        $val = 0;
        foreach ($payroll as $pay) {
            $val += $pay->net_income;
        }
        $template->setValue('amount', number_format($val, 2));
        $template->setValue('inwords',   $this->convert_number_to_words(round($val, 2)));
        $template->saveAs('Sample_07_BankTemplateCloneRow.docx');
    }
public function fill(){
        $client = new \GuzzleHttp\Client();
     $request_body = array();

        $headers = [

            'Accept'        => 'application/json',

        ];
        
          try {
            $response = $client->request('GET','https://ienetwork.webhr.co/api/json/?key=1A3RGvaCtMXr9DLaNM87W0zQMr5u2YwJ&request=EMPLOYEES_EMPLOYEESLIST', array(
                'headers' => $headers,
                'json' => $request_body,
               )
            );
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $jArr = json_decode($body,true);
          $result = [];
           $uresult = [];
         
            foreach($jArr as $j){
                 if(is_array($j)){
                     
                    foreach($j as $employee){
                        $c = Webhr::where('user_name',$employee['UserName'])->first();
                  
                  
                    //existing employee with updates
                    
                    if($c){
                     $cc = Webhr::find($c->id);
                      
                      $cc->joining_date= $employee['JoiningDate'];
                      $cc->save();
                      
    
             
            
         }
                    }
                 }
            }
          }
         catch (\GuzzleHttp\Exception\BadResponseException $e) {
            // handle exception or api errors.
           return "Error!";
         }
        
    
       $users = Employee::where('employees.is_active', 1)->join('webhrs', 'webhrs.acc_id', '=', 'employees.acc_id')->select('employees.id','webhrs.full_name', 'webhrs.joining_date')->get();
      $count = 0;
      $arr= [];
      foreach($users as $user){
          $time = strtotime($user->joining_date);
            $newformat = date('Y-m-d',$time);
            $time2 = strtotime('1/07/2022');
            $newformat2 = date('Y-m-d',$time2);
          if($newformat < $newformat2 ){
          $arr[$count] = $user->full_name;
          $count ++;
              DB::table('warnings')->where('employee_id', $user->id)->delete();
          }
      }
       return $arr;
}
    public function downloadbank()
    {
        $this->bankword();
        $file = "Sample_07_BankTemplateCloneRow.docx";
        $headers = array('Content-Type: application/msword',);
        return response()->download($file, 'bankletter.docx', $headers);
    }
    function convert_number_to_words($num) {
         $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
return $f->format($num);
    }
       function convert_number_to_words2($num) {
          
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 

$rettxt .= $ones[substr($i,0,1)]." ". $hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and ". $decnum . "/100"; 
// if($decnum < 20){ 
// $rettxt .= $ones[$decnum]; 
// }elseif($decnum < 100){ 
// $rettxt .= $tens[substr($decnum,0,1)]; 
// $rettxt .= " ".$ones[substr($decnum,1,1)]; 
// } 
} 
return $rettxt; 
}
}
