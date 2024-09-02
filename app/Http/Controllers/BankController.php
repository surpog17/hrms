<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    //
    public function index()
    {
        $banks = Bank::join('employees','employees.id', '=', 'banks.employee_id')->where('employees.is_active', 1)->orderby('employees.first_name', 'asc')->select('banks.id', 'employee_id', 'first_name', 'last_name',
        'full_name','bank_account_number', 'bank_account_type', 'branch_name', 'bank_name')->get();
        return view('bank')->with('banks', $banks);
    }
    public function create()
    {
     
        $employees =  DB::table('employees')->where('is_active', 1)->whereNotIn('employees.id', Bank::pluck('employee_id'))->get();

        return view('create_bank')->with('employees', $employees);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        if (Bank::where('employee_id', '=', Input::get('employee_id'))->first()) {
            
        } else {
            $bank = new Bank;
            $bank->employee_id = $request->input('employee_id');
            $bank->bank_account_number = $request->input('account_number');
            $bank->bank_account_type = $request->input('account_type');
            $bank->branch_name = $request->input('branch_name');
            $bank->bank_name = $request->input('bank_name');
            $bank->save();

            
        }
        return back()->withInput(Input::all());
    }

    public function edit($id)
    {
        // $bank = Bank::join('employees','employees.id', '=', 'banks.employee_id')->where('employees.is_active', 1)->where('banks.id', $id)->select('banks.id', 'employee_id', 'first_name', 'last_name',
        // 'bank_account_number', 'bank_account_type', 'branch_name', 'bank_name')->first();
        $bank = Bank::find($id);
        $employees = Employee::all();
        return view('edit_bank')->with('bank', $bank)->with('employees', $employees);
    }
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        $bank = Bank::find($id);
        $bank->employee_id = $request->input('employee_id');
        $bank->employee_name = $request->input('name');
        $bank->bank_account_number = $request->input('account_number');
        $bank->bank_account_type = $request->input('account_type');
        $bank->branch_name = $request->input('branch_name');
        $bank->bank_name = $request->input('bank_name');
        $bank->save();


        return redirect()->route('bank');
    }

    public function destroy($id)
    {
        $profile = Bank::find($id);
        $profile->delete();

        return redirect()->back();
    }
}
