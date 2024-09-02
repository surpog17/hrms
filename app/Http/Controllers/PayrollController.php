<?php

namespace App\Http\Controllers;

use DB;
use File;
use Mail;
use App\Bank;
use App\Award;
use App\Webhr;
use App\Deduct;
use App\Payroll;
use App\Employee;
use Carbon\Carbon;
use App\Exports\BanksExport;
use Illuminate\Http\Request;
use App\Exports\PayrollsExport;
use App\Mail\PayrollMail;
use App\Merit;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
ini_set('max_execution_time', 500);
//
class PayrollController extends Controller
{
    //
    public function index()
    {
        $employee = Employee::where([['is_active', 1],['basic_salary','!=',null]])->get();
        Payroll::truncate();
        foreach ($employee as $emp) {
            $payroll = new Payroll;
            $payroll->employee_id = $emp->id;
            $payroll->save();
        }

        return $this->allowance();
    }
    public function allowance()
    {

        $payroll = Payroll::all();


        foreach ($payroll as $pay) {
            $emp = Employee::find($pay->employee_id);
            if ($emp == NULL) { } else {
                $pay->trans_allowance = ($emp->basic_salary) * 0.15;
                $pay->gross_salary = ((($emp->basic_salary) * 0.15) + $emp->basic_salary);
                $pay->save();
            }
        }


        return $this->totalaward();
    }

    public function totalaward()
    {
        $payroll = Payroll::all();


        foreach ($payroll as $pay) {
            $totalaward = Award::where('employee_id', $pay->employee_id)->first();
            if ($totalaward == NULL) { } else {
                $pay->total_award = ($totalaward->ieb) + ($totalaward->allowance)+ ($totalaward->position_allowance) + ($totalaward->eodb) + ($totalaward->cdb) + ($totalaward->mpeqb) + ($totalaward->speqb) + ($totalaward->tvcqb) + ($totalaward->bepeqb) + ($totalaward->fhaqb) + ($totalaward->tpcqb)
                + ($totalaward->exam_bonus) + ($totalaward->bonus) + ($totalaward->operationincentive) + ($totalaward->adminincentive) + ($totalaward->operationleadership) + ($totalaward->cashcollection);


                $pay->save();
            }
        }

        return $this->tax_trans();
    }

    public function tax_trans()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {

            if (($pay->trans_allowance) > 600) {
                $pay->tax_tran_allowance = (($pay->trans_allowance) - 600);
                $pay->save();
            } else {
                $pay->tax_tran_allowance = 0;
                $pay->save();
            }
        }
        return $this->emp_pension();
    }

    public function emp_pension()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {
            $ded = Deduct::where('employee_id', $pay->employee_id)->first();
            $dedvalues = 0;
            if($ded){
                $dedvalues = $ded->absent;
            }
            $emp = Employee::find($pay->employee_id);
            if ($emp == NUll or ($emp->probation == 1) or (($emp->basic_salary) < ($dedvalues + 1000))) { } else {
                $pay->emp_pension = (($emp->basic_salary-$dedvalues) * 0.07);
                $pay->comp_pension = (($emp->basic_salary-$dedvalues) * 0.11);
                $pay->save();
            }
        }
        return $this->taxable_income();
    }

    public function taxable_income()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {

            $emp = Employee::find($pay->employee_id);
            $ded = Deduct::where('employee_id', $pay->employee_id)->first();
            if ($emp == NUll) { } else {
                $pay->taxable_income = (($emp->basic_salary) + ($pay->total_award) + ($pay->tax_tran_allowance));
                $pay->save();
                if ($ded == NUll) { } else {
                    if((($pay->taxable_income) - ($ded->absent))<0){
                        $pay->taxable_income = 0;
                        $pay->save();
                    }else{
                        $pay->taxable_income = (($pay->taxable_income) - ($ded->absent));
                        $pay->save();
                    }
                }
            }
        }
        return $this->tax();
    }

    public function tax()
    {
        $payroll = Payroll::all();


        foreach ($payroll as $pay) {
            $taxable = $pay->taxable_income;

            if ($taxable < 600) {
                $pay->tax = 0;
                $pay->save();
            } elseif ($taxable <= 1650 and $taxable > 600) {
                $pay->tax = ($taxable * 0.1) - 60;
                $pay->save();
            } elseif ($taxable <= 3200 and $taxable > 1650) {
                $pay->tax = ($taxable * 0.15) - 142.5;
                $pay->save();
            } elseif ($taxable <= 5250 and $taxable > 3200) {
                $pay->tax = ($taxable * 0.2) - 302.5;
                $pay->save();
            } elseif ($taxable <= 7800 and $taxable > 5250) {
                $pay->tax = ($taxable * 0.25) - 565;
                $pay->save();
            } elseif ($taxable <= 10900 and $taxable > 7800) {
                $pay->tax = ($taxable * 0.30) - 955;
                $pay->save();
            } elseif ($taxable > 10900) {
                $pay->tax = ($taxable * 0.35) - 1500;
                $pay->save();
            }
        }

        return $this->total_deduction();
    }
    public function total_deduction()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {

            $ded = Deduct::where('employee_id', $pay->employee_id)->first();

            if ($ded == NUll) {
                $pay->total_deduction = (($pay->tax) + ($pay->emp_pension));
                $pay->save();
            } else {
                $pay->total_deduction = (($pay->tax) + ($ded->absent) + ($ded->other)+ ($ded->exam) + ($ded->latecommer) + ($ded->pma) + ($ded->car) + ($ded->medical) + ($ded->loan) + ($pay->emp_pension));
                $pay->save();
            }
        }
        return $this->gross();
    }

    public function gross()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {
            $emp = Employee::find($pay->employee_id);
            if ($emp == NULL) { } else {
                $pay->gross_income = (($pay->total_award) + ($pay->trans_allowance) + ($emp->basic_salary));
                $pay->save();
            }
        }
        return $this->net();
    }

    public function net()
    {
        $payroll = Payroll::all();

        foreach ($payroll as $pay) {
            $pay->net_income = (($pay->gross_income) - ($pay->total_deduction));
            $pay->save();
        }
        return $this->view();
    }

    public function view()
    {
        $payroll = Payroll::orderBy('employee_id')->get();
        $emp = Employee::all();
        return view('payroll')->with('payroll', $payroll)->with('emp', $emp);
    }

    public function bank_view()
    {
        $bank = Banks::orderBy('employee_id')->get();
        $payroll = Payroll::all();
        return view('view_bank')->with('payroll', $payroll)->with('bank', $bank);
    }

    public function export_excel()
    {
        return Excel::download(new PayrollsExport, 'IEPayroll.xlsx');
    }

    public function export_bank()
    {
        return Excel::download(new BanksExport, 'Bank.xlsx');
    }
    public function testemail()
    {
        $payroll = Payroll::all();


        foreach ($payroll as $pay) {
            $webhr = Webhr::where('webhrs.acc_id', $pay->employee->acc_id)->where('employees.is_active',1)->join('employees', 'employees.acc_id', 'webhrs.acc_id')->first();
            if ($webhr){
               // if ($webhr->acc_id == 192) {
                    if($webhr->email){
                    # code...
                    $ded = Deduct::where('employee_id', $pay->employee_id)->first();
                    $award = Award::where('employee_id', $pay->employee_id)->first();
                    $employee = Employee::find($pay->employee_id);

                    $data = array(
                        'id' => $webhr->acc_id,
                        'email' => $webhr->email,
                        'name' => $webhr->full_name,
                    );

                    // $customPaper = array(0,0,567.00,283.80);
                    $pdf = PDF::loadView('paysliptemplate', compact('webhr', 'pay', 'award', 'ded', 'employee'));



                    // Mail::to($user->email)->send(new payroll_mail($user));
                    Mail::send('emails.payroll', ["pass_data" => $data], function ($message) use ($pdf, $webhr) {
                        $message->from('iefinance@ienetworksolutions.com', 'IEFinanceNoReply@ienetworksolutions.com');

                        //$message->to($webhr->email)->cc('iefinance@ienetworksolutions.com')->subject('Generated Payroll');
                         $message->to($webhr->email)->cc('iefinance@ienetworksolutions.com')->bcc('hawi@ienetworks.co')->subject('Generated Payroll');

                        $message->attachData($pdf->output(), "IE-payroll.pdf");
                    });
                    //}

                }
            }
        }

        // Mail::to(Auth::user()->email)->send(new Payroll());
        // return redirect('/');

        return redirect('/home');
    }

    public function email()
    {
        set_time_limit(0);
        /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('DomPDF');

        $payroll = Payroll::all();
        $sentEmails = [];
        $successfulEmails = [];
        $failedEmails = [];

        foreach ($payroll as $pay) {
            try {
                $webhr = Webhr::where('webhrs.acc_id', $pay->employee->acc_id)
                    ->where('employees.is_active', 1)
                    ->join('employees', 'employees.acc_id', 'webhrs.acc_id')
                    ->first();
                    $merit = Merit::where('employee_id', $webhr->id)->first();
                    if($merit)
                    {
                        $merit->vp_data= json_decode($merit->vp);
                    }

                // Check if webhr exists and email hasn't been sent yet
                if ($webhr && $webhr->email && !in_array($webhr->email, $sentEmails)) {
                    // Mark the email as sent
                    $sentEmails[] = $webhr->email;

                    $ded = Deduct::where('employee_id', $pay->employee_id)->first();
                    $award = Award::where('employee_id', $pay->employee_id)->first();
                    $bank = Bank::where('employee_id', $pay->employee_id)->first();
                    $employee = Employee::find($pay->employee_id);

                    // Check if required objects exist before accessing their properties
                    if (!$employee || !$bank) {
                        throw new \Exception('Employee or Bank data is missing for Payroll ID: ' . $pay->id);
                    }

                    // Prepare the template
                    $template = new TemplateProcessor('PaySlipTemplate.docx');
                    $Paymentdate = now()->format('Y-m-d');
                    $salaryYear = Carbon::now()->subMonths(1)->format('Y');
                    $salaryMonth = Carbon::now()->subMonths(1)->format('M');

                    // Fill template values
                    $template->setValue('salaryYear', $salaryYear);
                    $template->setValue('salaryMonth', $salaryMonth);
                    $template->setValue('name', $webhr->full_name);
                    $template->setValue('job_title', htmlspecialchars($webhr->designation));
                    $template->setValue('date_hired', 'N/A');
                    $template->setValue('tin', 'N/A');
                    $template->setValue('location', 'HQ-Addis Ababa');
                    $template->setValue('pay_date', $Paymentdate);
                    $template->setValue('basic_salary', $employee->basic_salary);
                    $template->setValue('trans_allowance', $pay->trans_allowance);
                    $template->setValue('gross_salary', number_format($pay->gross_salary, 2));
                    $template->setValue('net_income', number_format($pay->net_income, 2));
                    $template->setValue('bank_name', $bank->bank_name);
                    $template->setValue('bank_account_number', $bank->bank_account_number);
                    $template->setValue('amount', number_format($pay->net_income, 2));

                    //Bonus

                    if ($award == null) {
                        $template->setValue('variable_pay', '0.00');
                        $template->setValue('vp_percent', '0.00');
                        $template->setValue('vp_tottal', '0.00');
                        $template->setValue('allowance', '0.00');
                        $template->setValue('exam_bonus', '0.00');
                        $template->setValue('ieb', '0.00');
                        $template->setValue('eodb', '0.00');
                        $template->setValue('cdb', '0.00');
                        $template->setValue('mpeqb', '0.00');
                        $template->setValue('speqb', '0.00');
                        $template->setValue('tvcqb', '0.00');
                        $template->setValue('tpcqb', '0.00');
                        $template->setValue('bepeqb', '0.00');
                        $template->setValue('fhaqb', '0.00');
                        $template->setValue('bonus', '0.00');
                        $template->setValue('total_award', number_format($pay->total_award, 2));
                    } else {
                        $template->setValue('variable_pay', $award->allowance);
                        $template->setValue('vp_percent', $merit->value);
                        $template->setValue('vp_tottal', $merit->type);
                        $template->setValue('allowance', $award->position_allowance);
                        $template->setValue('exam_bonus', $award->exam_bonus);
                        $template->setValue('ieb', $award->ieb);
                        $template->setValue('eodb', $award->eodb);
                        $template->setValue('cdb', $award->cdb);
                        $template->setValue('mpeqb', $award->mpeqb);
                        $template->setValue('speqb', $award->speqb);
                        $template->setValue('tvcqb', $award->tvcqb);
                        $template->setValue('tpcqb', $award->tpcqb);
                        $template->setValue('bepeqb', $award->bepeqb);
                        $template->setValue('fhaqb', $award->fhaqb);
                        $template->setValue('bonus', $award->bonus);
                        $template->setValue('total_award', number_format($pay->total_award, 2));
                    }

                    //deduction

                    if ($ded == null) {
                        $template->setValue('tax', $pay->tax);
                        $template->setValue('emp_pension', $pay->emp_pension);
                        $template->setValue('medical', '0.00');
                        $template->setValue('absent', '0.00');
                        $template->setValue('pma', '0.00');
                        $template->setValue('car', '0.00');
                        $template->setValue('exam', '0.00');
                        $template->setValue('latecommer', '0.00');
                        $template->setValue('other', '0.00');
                        $template->setValue('loan', '0.00');
                        $template->setValue('total_deduction', number_format($pay->total_deduction));
                    } else {
                        $template->setValue('tax', $pay->tax);
                        $template->setValue('emp_pension', $pay->emp_pension);
                        $template->setValue('medical', $ded->medical);
                        $template->setValue('absent', $ded->absent);
                        $template->setValue('pma', $ded->pma);
                        $template->setValue('car', $ded->car);
                        $template->setValue('exam', $ded->exam);
                        $template->setValue('latecommer', $ded->latecommer);
                        $template->setValue('other', $ded->other);
                        $template->setValue('loan', $ded->loan);
                        $template->setValue('total_deduction', number_format($pay->total_deduction));
                    }

                    // Save and convert to PDF
                    $fileName = 'PaySlip_' . $webhr->acc_id . '_' . now()->timestamp;
                    $docPath = public_path($fileName . '.docx');
                    $template->saveAs($docPath);
                    $content = IOFactory::load($docPath);
                    $pdfPath = public_path($fileName . '.pdf');
                    $pdfWriter = IOFactory::createWriter($content, 'PDF');
                    $pdfWriter->save($pdfPath);

                    // Mail::to('samuel.abewa@gmail.com')->send(new PayrollMail($webhr, $fileName . '.pdf'));
                    Mail::to($webhr['email'])->send(new PayrollMail($webhr, $fileName . '.pdf'));
                    $successfulEmails[] = $webhr->email;

                }
            } catch (\Exception $e) {
                $failedEmails[] = [
                        'email' => isset($webhr->email) ? $webhr->email : 'No email',
                        'message' => $e->getMessage(),
                    ];
            }
        }

        //  return response()->json([
        //     'successfulEmails' => $successfulEmails,
        //     'failedEmails' => $failedEmails,
        // ]);
        return redirect()->back();
    }

    public function emailCheck()
    {
        $payroll = Payroll::all();
        $successfulEmails = [];
        $failedEmails = [];
        $unknown = [];

        foreach ($payroll as $pay) {
            try {
                $webhr = Webhr::where('webhrs.acc_id', $pay->employee->acc_id)
                    ->where('employees.is_active', 1)
                    ->join('employees', 'employees.acc_id', 'webhrs.acc_id')
                    ->first();

                if ($webhr && $webhr->email) {
                    $successfulEmails[] = [
                        'payroll_id' => $pay->id,
                        'name' => $webhr->full_name, // Assuming 'full_name' is the name field in Webhr
                        'email' => $webhr->email,
                        'webhr' => $webhr
                    ];
                } else {
                    $failedEmails[] = [
                        'payroll_id' => $pay->id,
                        'name' => isset($webhr->full_name) ? $webhr->full_name : 'Unknown Name',
                        'email' => isset($webhr->email) ? $webhr->email : 'No email or Inactive Employee',
                    ];
                }
            } catch (\Exception $e) {
                $unknown[] = [
                    'payroll_id' => $pay->id,
                    'name' => $webhr->full_name,
                    'email' => 'Error: ' . $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'successfulEmails' => $successfulEmails,
            'failedEmails' => $failedEmails,
            'unknown' => $unknown,
        ]);
    }

    public function personalemail($id)
    {
        $payroll = Payroll::where('id', $id)->get();

        /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('DomPDF');

        // $template = new TemplateProcessor('PaySlipTemplate.docx');

        foreach ($payroll as $pay) {
            $template = new TemplateProcessor('PaySlipTemplate.docx');
            $webhr = Webhr::where('webhrs.acc_id', $pay->employee->acc_id)
                ->where('employees.is_active', 1)
                ->join('employees', 'employees.acc_id', 'webhrs.acc_id')
                ->first();
                $merit = Merit::where('employee_id', $webhr->id)->first();
                if($merit)
                {
                    $merit->vp_data= json_decode($merit->vp);
                }

            if ($webhr) {
                // if ($webhr->acc_id == 192) {
                if ($webhr->email) {
                    # code...
                    $ded = Deduct::where(
                        'employee_id',
                        $pay->employee_id
                    )->first();
                    $award = Award::where(
                        'employee_id',
                        $pay->employee_id
                    )->first();
                    $bank = Bank::where(
                        'employee_id',
                        $pay->employee_id
                    )->first();
                    $employee = Employee::find($pay->employee_id);

                    $data = [
                        'id' => $webhr->acc_id,
                        'email' => $webhr->email,
                        'name' => $webhr->full_name,
                    ];

                    //Payment information
                    $Paymentdate = date('Y-m-d');

                    $salaryYear = Carbon::createFromFormat(
                        'Y-m-d',
                        $Paymentdate
                    )
                        ->subMonths(1)
                        ->format('Y');
                    $salaryMonth = Carbon::createFromFormat(
                        'Y-m-d',
                        $Paymentdate
                    )
                        ->subMonths(1)
                        ->format('M');

                    $template->setValue('salaryYear', $salaryYear);
                    $template->setValue('salaryMonth', $salaryMonth);

                    //Empoyee information
                    $text =htmlspecialchars($webhr->designation);

                    $template->setValue('name', $webhr->full_name);
                    $template->setValue('job_title', $text);
                    $template->setValue('date_hired', 'N/A');
                    $template->setValue('tin', 'N/A');
                    $template->setValue('location', 'HQ-Addis Ababa');
                    $template->setValue('pay_date', $Paymentdate);

                    //Earnings
                    $template->setValue(
                        'basic_salary',
                        $employee->basic_salary
                    );
                    $template->setValue(
                        'trans_allowance',
                        $pay->trans_allowance
                    );
                    $template->setValue('gross_salary', number_format($pay->gross_salary));

                    //Bonus

                    if ($award == null) {
                        $template->setValue('variable_pay', '0.00');
                        $template->setValue('vp_percent', '0.00');
                        $template->setValue('vp_tottal', '0.00');
                        $template->setValue('allowance', '0.00');
                        $template->setValue('exam_bonus', '0.00');
                        $template->setValue('ieb', '0.00');
                        $template->setValue('eodb', '0.00');
                        $template->setValue('cdb', '0.00');
                        $template->setValue('mpeqb', '0.00');
                        $template->setValue('speqb', '0.00');
                        $template->setValue('tvcqb', '0.00');
                        $template->setValue('tpcqb', '0.00');
                        $template->setValue('bepeqb', '0.00');
                        $template->setValue('fhaqb', '0.00');
                        $template->setValue('bonus', '0.00');
                        $template->setValue('total_award', number_format($pay->total_award));
                    } else {
                        $template->setValue('variable_pay', $award->allowance);
                        $template->setValue('vp_percent', $merit->value);
                        $template->setValue('vp_tottal', $merit->type);
                        $template->setValue('allowance', $award->position_allowance);
                        $template->setValue('exam_bonus', $award->exam_bonus);
                        $template->setValue('ieb', $award->ieb);
                        $template->setValue('eodb', $award->eodb);
                        $template->setValue('cdb', $award->cdb);
                        $template->setValue('mpeqb', $award->mpeqb);
                        $template->setValue('speqb', $award->speqb);
                        $template->setValue('tvcqb', $award->tvcqb);
                        $template->setValue('tpcqb', $award->tpcqb);
                        $template->setValue('bepeqb', $award->bepeqb);
                        $template->setValue('fhaqb', $award->fhaqb);
                        $template->setValue('bonus', $award->bonus);
                        $template->setValue('total_award', number_format($pay->total_award));
                    }

                    //deduction

                    if ($ded == null) {
                        $template->setValue('tax', $pay->tax);
                        $template->setValue('emp_pension', $pay->emp_pension);
                        $template->setValue('medical', '0.00');
                        $template->setValue('absent', '0.00');
                        $template->setValue('pma', '0.00');
                        $template->setValue('car', '0.00');
                        $template->setValue('exam', '0.00');
                        $template->setValue('latecommer', '0.00');
                        $template->setValue('other', '0.00');
                        $template->setValue('loan', '0.00');
                        $template->setValue(
                            'total_deduction',
                            number_format($pay->total_deduction)
                        );
                    } else {
                        $template->setValue('tax', $pay->tax);
                        $template->setValue('emp_pension', $pay->emp_pension);
                        $template->setValue('medical', $ded->medical);
                        $template->setValue('absent', $ded->absent);
                        $template->setValue('pma', $ded->pma);
                        $template->setValue('car', $ded->car);
                        $template->setValue('exam', $ded->exam);
                        $template->setValue('latecommer', $ded->latecommer);
                        $template->setValue('other', $ded->other);
                        $template->setValue('loan', $ded->loan);
                        $template->setValue(
                            'total_deduction',
                            number_format($pay->total_deduction)
                        );
                    }

                    //netpay
                    $template->setValue('net_income', number_format($pay->net_income));

                    //payment_method
                    $template->setValue('bank_name', $bank->bank_name);
                    $template->setValue(
                        'bank_account_number',
                        $bank->bank_account_number
                    );
                    $template->setValue('amount', number_format($pay->net_income));

                    /*@ Save Temporary Word File With New Name */
                    $saveDocPath = ('new-result.docx');
                    if (file_exists($saveDocPath)) {
                        unlink($saveDocPath);
                    }
                    $template->saveAs($saveDocPath);

                    // Load temporarily create word file
                    $Content = IOFactory::load($saveDocPath);

                    //Save it into PDF
                    $savePdfPath = ('new-result.pdf');

                    /*@ If already PDF exists then delete it */
                    if (file_exists($savePdfPath)) {
                        unlink($savePdfPath);
                    }
                    //Save it into PDF

                    $PDFWriter = IOFactory::createWriter($Content, 'PDF');
                    $PDFWriter->save($savePdfPath);

                    $file = $savePdfPath;

                    if (isset($webhr['email'])) {
                        $pdfPath = 'new-result.pdf';
                        // Mail::to('samuel.abewa@gmail.com')
                        Mail::to($webhr['email'])
                            ->send(new PayrollMail($webhr, $pdfPath));
                    } else {
                        return response()->json(['error' => 'Email address not found.'], 404);
                    }

                }
            }
        }

        return redirect()->back();
    }
}
