<?php

namespace App\Http\Controllers;

use App\Category;
use App\Employee;
use App\Loan;
use App\Medicalinsurance;
use Illuminate\Http\Request;
use DateTime;
use DB;

class LoanController extends Controller
{
    //
    public function index(Request $request)
    {
        if(is_numeric($request->employee_selected)){
            $employees = Employee::all();
            $loans = Loan::where('employee_id',$request->employee_selected)->orderBy('category_id', 'desc')->orderBy('employee_id', 'desc')->orderBy('date', 'desc')->paginate(30);
            $Categories = Category::all();
            
            $loemp = Loan::select('employee_id')->distinct()->get();
            $i = array();
            foreach($loemp as $lo){
                array_push($i,$lo->employee_id);
            }
            $users = DB::table('employees')
                        ->whereIn('id', $i)
                        ->get();
        }else{
            $employees = Employee::where('is_active', 1)->orderby('full_name', 'asc')->get();
            $loans = Loan::orderBy('category_id', 'desc')->orderBy('employee_id', 'desc')->orderBy('date', 'desc')->paginate(15);
            $Categories = Category::all();
            
            $loemp = Loan::select('employee_id')->distinct()->get();
            $i = array();
            foreach($loemp as $lo){
                array_push($i,$lo->employee_id);
            }
            $users = DB::table('employees')
                        ->whereIn('id', $i)
                        ->get();
        }       
        $medicalinsurances = Medicalinsurance::all();
        
        return view('loan')->with('employees', $employees)->with('loans', $loans)->with('categories', $Categories)->with('users',$users)->with('medicalinsurances', $medicalinsurances);
    }
    public function employeeloan(Request $request){
         $input = $request->all();
        $value = Employee::find($input['employee_id']);
        if($value){
             return $value->medical_insurance;
        }
       else{
           return 0;
       }
    }
    public function store(Request $request)
    {
        $Categories = Category::find($request->category);
        $insurance = Medicalinsurance::find($request->insurance);
        
        $emp = Employee::find($request->employee);
        if($emp){
            $emp->medical_insurance = $request->insurance;
            $emp->save();
        }
        $duration = $Categories->duration;
        if($request->duration_amount > 0 && $request->category == 5){
        
        $duration = $request->duration_amount;
            
        }
        
        
        
        $i = 1;
        $paid = 0;
        $remain = 0;
        while ($i <= $duration) {
            $date = new DateTime($request->date);
            $date->modify('+'. $i-1 .' month');
            $current = $request->total_amount / $duration;
            $paid += $current;
            $remain -= $current;
            Loan::create(['total_amount' => $request->total_amount, 'paid_amount' => $paid, 'current_amount' => $current, 'date' => $date, 'remaining_amount' => ($request->total_amount + $remain), 'employee_id' => $request->employee, 'category_id' => $request->category, 'duration' => $duration]);
            $i++;
        }


        return redirect()->route('loan.index')->with('success', 'Loan Created');
    }

    public function update(Request $request)
    {
        // ($request->warning_id);
        $loan = Loan::find($request->loan_id);
        $loan->update(['total_amount' => $request->total_amount, 'paid_amount' => $request->paid_amount, 'current_amount' => $request->current_amount, 'date' => $request->date, 'remaining_amount' => $request->remaining, 'employee_id' => $request->employee, 'category_id' => $request->category]);

        return redirect()->route('loan.index')->with('success', 'Loan Created');
    }

    public function delete($id)
    {
        $loan = Loan::find($id);

        $loan->delete();

        return redirect()->route('loan.index')->with('danger', 'Loan Deleted');
    }
}
