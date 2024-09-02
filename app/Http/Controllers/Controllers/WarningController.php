<?php

namespace App\Http\Controllers;

use App\Absent;
use App\Employee;
use App\Morning;
use App\Type;
use App\Warning;
use App\Webhr;
use App\WebhrAbsent;
use App\WebhrLate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PDF;
ini_set('max_execution_time', 500);
class WarningController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::all();
        $warning = Warning::orderBy('date', 'asc')->paginate(25);
        $types = Type::all();

        return view('warning')->with('employees', $employees)->with('warning', $warning)->with('types', $types);
    }
    public function store(Request $request)
    {

        Warning::updateOrCreate(['employee_id' => $request->employee, 'warn' => $request->warning_number], ['type_id' => $request->type, 'date' => $request->date, 'remark' => $request->remark, 'action' => $request->disciplinary, 'active' => 1]);

        return redirect()->route('warning.index')->with('success', 'Warning Created');
    }

    public function update(Request $request)
    {
        $warning = Warning::find($request->warning_id);
        $warning->update(['employee_id' => $request->employee, 'warn' => $request->warning_number, 'type_id' => $request->type, 'date' => $request->date, 'remark' => $request->remark, 'action' => $request->disciplinary, 'active' => 1]);

        return redirect()->route('warning.index')->with('success', 'Warning Created');
    }

    public function delete($id)
    {
        $warning = Warning::find($id);

        $warning->delete();

        return redirect()->route('warning.index')->with('danger', 'Warning Deleted');
    }
    public function offense($id, $min, $date)
    {
        if ($min < 15 && $min > 1) {
            $employee = Employee::where('acc_id', $id)->first();
            $type = Type::where('name', 'Latecommers')->first();
            $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
            $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $date]])->first();
            if ($warning) {
                if (!$check_date && $warning->warn == 1) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '2nd written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 2) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '3rd written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 3) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '4th written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 4) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '5th written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 5) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '6th written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn >= 6) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => $warning->warn + 1 . 'th written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1]);
                }
            } else {
                Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '1st written warning and deduction of 0.5 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1]);
            }
        } elseif ($min < 120 && $min > 15) {
            $employee = Employee::where('acc_id', $id)->first();
            $type = Type::where('name', 'Latecommers')->first();
            $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
            $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $date]])->first();
            if ($warning) {
                if (!$check_date && $warning->warn == 1) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '2nd written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '1/2']);
                } elseif (!$check_date && $warning->warn == 2) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '3rd written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '1']);
                } elseif (!$check_date && $warning->warn == 3) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '4th written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '2']);
                } elseif (!$check_date && $warning->warn == 4) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '5th written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '3']);
                } elseif (!$check_date && $warning->warn == 5) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '6th written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '5']);
                } elseif (!$check_date && $warning->warn == 6) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => $warning->warn + 1 . 'th written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . 'minutes late on ' . $date, 'active' => 1, 'action' => '10']);
                }
            } else {
                Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '1st written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1/4']);
            }
        } 
        // elseif ($min < 120 && $min > 30) {
        //     $employee = Employee::where('acc_id', $id)->first();
        //     $type = Type::where('name', 'Latecommers')->first();
        //     $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
        //     $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $date]])->first();
        //     if ($warning) {

        //         if (!$check_date && $warning->warn == 1) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '2nd written warning and deduction of 1 day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1']);
        //         } elseif (!$check_date && $warning->warn == 2) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '3rd written warning and deduction of 2 day Salary for being minutes' . $min . ' minutes late on'  . $date, 'active' => 1, 'action' => '2']);
        //         } elseif (!$check_date && $warning->warn == 3) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '4th written warning and deduction of 3 day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '3']);
        //         } elseif (!$check_date && $warning->warn == 4) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '5th written warning and deduction of 5 day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '5']);
        //         } elseif (!$check_date && $warning->warn == 5) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '6th written warning and deduction of 10 day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '10']);
        //         } elseif (!$check_date && $warning->warn == 6) {
        //             $warning->update(['active' => 0]);
        //             Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => $warning->warn + 1 . '7th written warning and deduction of 10 day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '10']);
        //         }
        //     } else {
        //         Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '1st written warning and deduction of half day Salary for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1/2']);
        //     }
        // } 
        elseif ($min > 120) {
            $employee = Employee::where('acc_id', $id)->first();
            $type = Type::where('name', 'Absent')->first();
            $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
            $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $date]])->first();
            if ($warning) {
                if (!$check_date && $warning->warn == 1) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '2nd written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1']);
                } elseif (!$check_date && $warning->warn == 2) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => '3rd written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1']);
                } elseif (!$check_date && $warning->warn == 3) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $date, 'remark' => $warning->warn + 1 . 'th written warning and deduction of 1 day salary and two days deduction from annual leave balancewritten warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1, 'action' => '1']);
                }
            } else {
                Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $date, 'action' => 1, 'remark' => '1st written warning and deduction of 1 point from monthly variable pay attendance score for being ' . $min . ' minutes late on ' . $date, 'active' => 1]);
            }
        }
    }
    public function all_warning()
    {
        $morning = Morning::all();
        foreach ($morning as $morn) {
            $this->offense($morn->calculated->acc_id, ($morn->late / 60), $morn->date);
        }

        return redirect()->route('calculate.show')->with('success', 'All good!');
    }
    public function absent(Request $request)
    {
        $employee = Employee::where('acc_id', $request->id)->first();
        $type = Type::where('name', 'Absent')->first();
        $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
        $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $request->date]])->first();
        $absent = Absent::where([['acc_id', $request->id], ['date', $request->date], ['remark', 'un-planned']])->first();
        if ($absent) {
            if ($warning) {
                if (!$check_date && $warning->warn == 1) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $request->date, 'remark' => '2nd written warning with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being being Absent on ' . $request->date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 2) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $request->date, 'remark' => '3rd written warning with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $request->date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 3) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'date' => $request->date, 'remark' => '4th written warning with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $request->date, 'active' => 1]);
                }
            } else {
                Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $request->date, 'remark' => '1st written warning with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $request->date, 'active' => 1]);
            }
        }
        return response()->json(['message' => 'Updated']);
    }

    public function calAbsent($id, $date)
    {
        $employee = Employee::where('acc_id', $id)->first();
        $type = Type::where('name', 'Absent')->first();
       
        $warning = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['active', 1]])->first();
        $check_date = Warning::where([['employee_id', $employee->id], ['type_id', $type->id], ['date', $date]])->first();
        $absent = WebhrAbsent::where([['employee_id', $employee->id], ['date', $date]])->first();
        if ($absent) {
            if ($warning) {
                if (!$check_date && $warning->warn == 1) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'action' => 1, 'date' => $date, 'remark' => '2nd written warning  with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn == 2) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'action' => 1, 'date' => $date, 'remark' => '3rd written warning  with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $date, 'active' => 1]);
                } elseif (!$check_date && $warning->warn >= 3) {
                    $warning->update(['active' => 0]);
                    Warning::create(['employee_id' => $employee->id, 'warn' => $warning->warn + 1, 'type_id' => $type->id, 'action' => 1, 'date' => $date, 'remark' => $warning->warn + 1 . 'th written warning  with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $date, 'active' => 1]);
                }
            } else {
                Warning::create(['employee_id' => $employee->id, 'warn' => 1, 'type_id' => $type->id, 'date' => $date, 'action' => 1, 'remark' => '1st written warning  with 1-day salary deduction, 2 days deduction from annual leave, and deduction of 2 points from monthly VP Score for being Absent on ' . $date, 'active' => 1]);
            }
        }
    }

    public function webhrWarning()
    {      $absent = WebhrAbsent::where('validated', 1)->where('id','>=',1000)->get();
        $late = WebhrLate::where('validated', 1)->where('id','>=',692)->get();
        foreach ($absent as $a) {
            if($a->employee){
                $this->calAbsent($a->employee->acc_id, $a->date);
            }
        }
      
        return redirect()->route('warning.index')->with('success', 'Warning Given');
      
      
    
      

    }
    

    function hoursToMinutes($hours)
    {
        $minutes = 0;
        if (strpos($hours, ':') !== false) {
            // Split hours and minutes.
            list($hours, $minutes) = explode(':', $hours);
        }
        return $hours * 60 + $minutes;
    }

    public function generate()
    {
        $employees = Employee::all();
        $warning = Warning::paginate(5);
        $types = Type::all();

        return view('generateWarning')->with('employees', $employees)->with('warning', $warning)->with('types', $types);
    }

    public function excusedindex()
    {
        $employees = Employee::all();
        $warning = Warning::orderBy('date', 'desc')->paginate(5);
        $types = Type::all();

        return view('excused')->with('employees', $employees)->with('warning', $warning)->with('types', $types);
    }
    public function excused(Request $request)
    {
        $warning = Warning::find($request->id);
        $warning->update(['excuse' => $request->active]);
        if ($request->active) {
            return response()->json(['message' => 'Employee Excused']);
        }

        return response()->json(['message' => 'Employee condemned']);
    }
    public function email(Request $req)
    {

        $array = explode('-', $req->daterange);
        $start = trim($array[0]);
        $time = strtotime($start);

        $newstart = date('Y-m-d', $time);
        $end = trim($array[1]);
        $endtime = strtotime($end);
        $newend = date('Y-m-d', $endtime);

        $warning = Warning::whereBetween('date', [$newstart, $newend])->get();
        $loopval = 1;

        foreach ($warning as $war) {
            $webhr = Webhr::where('acc_id', $war->employee->acc_id)->first();
            if ($webhr == null || $war->excuse == 1) { } else {
                if ($webhr->acc_id == $war->employee->acc_id) {
                    if($webhr->email){
                    
                    $employee = Employee::find($war->employee_id);

                    $data = array(
                        'id' => $webhr->acc_id,
                        'email' => $webhr->email,
                        'name' => $webhr->full_name,
                    );
                    $loopval += 1;

                    $pdf = PDF::loadView('reptemplate', compact('webhr', 'war', 'employee','loopval'));



                    // Mail::to($user->email)->send(new payroll_mail($user));
                    try {
                        Mail::send('emails.warning', ["pass_data" => $data], function ($message) use ($pdf, $webhr) {
                            $message->from('iefinance@ienetworksolutions.com', 'IE-HRNoReply@ienetworksolutions.com');
    
                            // $message->to($webhr->email)->cc('meried@ienetworksolutions.com')->cc('eliyas@ienetworksolutions.com')->cc('iefinance@ienetworksolutions.com')->subject($webhr->full_name. ' Reprimand');
                            $message->to('sophbeke@gmail.com')->subject($webhr->full_name. ' Reprimand');
                            // $message->to('eliyas@ienetworksolutions.com')->cc('iefinance@ienetworksolutions.com')->subject($webhr->full_name. ' Reprimand');
    
    
                            $message->attachData($pdf->output(), "reprimand.pdf");
                        });
                        $war->name=1;
                        $war->save();
                    } catch (\Exception $e) {
                        $war->name=$e;
                        $war->save();
                        continue;
                    }
                    }
                }
            }
        }  
        
        // Mail::to(Auth::user()->email)->send(new Payroll());
        // return redirect('/');

        return redirect('/home');
    }
    public function personalemail($id)
    {
        
        $warning = Warning::where('id', $id)->get();
        $loopval = 1;

        foreach ($warning as $war) {
            $webhr = Webhr::where('acc_id', $war->employee->acc_id)->first();
            if ($webhr == null || $war->excuse == 1) { } else {
                if ($webhr->acc_id == $war->employee->acc_id) {
                    if($webhr->email){
                    
                    $employee = Employee::find($war->employee_id);

                    $data = array(
                        'id' => $webhr->acc_id,
                        'email' => $webhr->email,
                        'name' => $webhr->full_name,
                    );
                    $loopval += 1;

                    $pdf = PDF::loadView('reptemplate', compact('webhr', 'war', 'employee','loopval'));



                    // Mail::to($user->email)->send(new payroll_mail($user));
                    
                        Mail::send('emails.warning', ["pass_data" => $data], function ($message) use ($pdf, $webhr) {
                            $message->from('iefinance@ienetworksolutions.com', 'IE-HRNoReply@ienetworksolutions.com');
    
                            $message->to($webhr->email)->cc('meried@ienetworksolutions.com')->cc('eliyas@ienetworksolutions.com')->cc('biniyam@ienetworksolutions.com')->cc('iefinance@ienetworksolutions.com')->subject($webhr->full_name. ' Reprimand');
                            // $message->to('sophbeke@gmail.com')->subject($webhr->full_name. ' Reprimand');
                            // $message->to('eliyas@ienetworksolutions.com')->cc('iefinance@ienetworksolutions.com')->subject($webhr->full_name. ' Reprimand');
    
    
                            $message->attachData($pdf->output(), "reprimand.pdf");
                        });
                    }
                }
            }
        }  
        
        // Mail::to(Auth::user()->email)->send(new Payroll());
        // return redirect('/');

        return redirect()->back();
    }
}
