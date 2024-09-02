<?php

namespace App\Http\Controllers;

use App\Award;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AwardController extends Controller
{
    //
    public function index()
    {
        $awards = Award::all();

        return view('award')->with('awards', $awards);
    }
    public function create()
    {
        $employee = Employee::all();

        return view('create_award')->with('employees', $employee);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        if (Award::where('employee_id', '=', Input::get('employee_id'))->exists()) {
            return Redirect::back()->withInput(Input::all());
        } else {
            $profile = new Award;
            $profile->employee_id = $request->input('employee_id');
            $profile->ieb = $request->input('ieb');
            $profile->eodb = $request->input('eodb');
            $profile->cdb = $request->input('cdb');
            $profile->mpeqb = $request->input('mpeqb');
            $profile->speqb = $request->input('speqb');
            $profile->tvcqb = $request->input('tvcqb');
            $profile->tpcqb = $request->input('tpcqb');
            $profile->bepeqb = $request->input('bepeqb');
            $profile->fhaqb = $request->input('fhaqb');
            $profile->bonus = $request->input('bonus');
            $profile->exam_bonus = $request->input('exam_bonus');
            $profile->allowance = $request->input('allowance');
            $profile->save();

            return redirect()->route('award');
        }
    }
    public function edit($id)
    {
        $award = Award::find($id);
        $employee = Employee::all();
        return view('edit_award')->with('award', $award)->with('employees', $employee);
    }
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        $profile = Award::find($id);
        $profile->employee_id = $request->input('employee_id');
        $profile->ieb = $request->input('ieb');
        $profile->eodb = $request->input('eodb');
        $profile->cdb = $request->input('cdb');
        $profile->mpeqb = $request->input('mpeqb');
        $profile->speqb = $request->input('speqb');
        $profile->tvcqb = $request->input('tvcqb');
        $profile->tpcqb = $request->input('tpcqb');
        $profile->bepeqb = $request->input('bepeqb');
        $profile->fhaqb = $request->input('fhaqb');
        $profile->bonus = $request->input('bonus');
        $profile->exam_bonus = $request->input('exam_bonus');
        $profile->allowance = $request->input('allowance');
        $profile->save();


        return redirect()->route('award');
    }

    public function destroy($id)
    {
        $profile = Award::find($id);
        $profile->delete();
        // Session::flash('flash_message', 'Award successfully Deleted!');
        return redirect()->route('award');
    }
}
