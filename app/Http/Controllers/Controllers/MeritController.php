<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Merit;
use App\MeritType;
use Illuminate\Http\Request;
use App\Imports\MeritImport;
use Maatwebsite\Excel\Facades\Excel;
class MeritController extends Controller
{
    //
    public function index(){
        $merit = Merit::all();
        $employees = Employee::all();
        $meritTypes = MeritType::all();

        return view('merit')->with('merit',$merit)->with('employees',$employees)->with('types',$meritTypes);
    }
    public function store(Request $request){
        Merit::create(['employee_id'=>$request->employee,'date'=>$request->date,'merit_type_id'=>$request->type,'remark'=>$request->remark]);

        return redirect()->route('merit.index')->with("success","Merit Created");
    }
    public function update(Request $request){
        $merit = Merit::find($request->type_id);
        $merit->update(['employee_id'=>$request->employee,'date'=>$request->date,'merit_type_id'=>$request->type,'remark'=>$request->remark]);
        return redirect()->route('merit.index')->with("success","Merit Updated");
    }
    public function delete($id){
        $merit = Merit::find($id);
        $merit->delete();

        return redirect()->route('merit.index')->with("success","Merit Updated");
    }
    public function importMerit(Request $request){
         $request->validate([
            'merit' => 'required',
        ]);
        // Merit::where('merit_type_id', 12)->delete();
        Excel::import(new MeritImport, $request->file('merit'));
        
         $merit = Merit::all();
        $employees = Employee::all();
        $meritTypes = MeritType::all();

        return redirect()->route('merit.index')->with('success', 'Import Complete');
         
    }
}
