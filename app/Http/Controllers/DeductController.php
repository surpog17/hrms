<?php

namespace App\Http\Controllers;

use App\Deduct;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DeductController extends Controller
{
    //
    public function index(){
		$deducts = Deduct::all();
		return view('deduct')->with('deducts',$deducts);
	}
	public function create(){
        $employees = Employee::all();

		return view('create_deduct')->with('employees',$employees);
	}
	public function store(Request $request){
		$this->validate($request, [
	        'employee_id' => 'required'
	    ]);

	    if (Deduct::where([['employee_id', '=', Input::get('employee_id')],['active',1]])->exists()) {

	    	return Redirect::back()->withInput(Input::all());
	    }else{
	    	$deduct = new Deduct;
			$deduct->employee_id = $request->input('employee_id');
			$deduct->medical = $request->input('medical');
			$deduct->absent = $request->input('absent');
			$deduct->other = $request->input('other');
            $deduct->loan = $request->input('loan');
            $deduct->car = $request->input('car');
            $deduct->pma = $request->input('pma');
            $deduct->exam = $request->input('exam');
            $deduct->latecommer = $request->input('latecommer');
			$deduct->save();

			return redirect()->route('deduction');

	    }




	}
    public function edit($id){
        $deduct = Deduct::find($id);
        $employees = Employee::all();
		return view('edit_deduct')->with('deduct',$deduct)->with('employees',$employees);
	}
	public function update(Request $request, $id){

		$this->validate($request, [
            'employee_id' => 'required',

	    ]);

	    $deduct = Deduct::find($id);
		$deduct->employee_id = $request->input('employee_id');
		$deduct->medical = $request->input('medical');
		$deduct->absent = $request->input('absent');
		$deduct->other = $request->input('other');
        $deduct->loan = $request->input('loan');
        $deduct->car = $request->input('car');
        $deduct->pma = $request->input('pma');
        $deduct->exam = $request->input('exam');
        $deduct->latecommer = $request->input('latecommer');
		$deduct->save();

		return redirect()->route('deduction');
	}

	public function destroy($id){
		$deduct = Deduct::find($id);
		$deduct->delete();
		return redirect()->back();
	}
}
