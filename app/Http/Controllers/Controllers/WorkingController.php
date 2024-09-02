<?php

namespace App\Http\Controllers;

use App\Working;
use Illuminate\Http\Request;
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
class WorkingController extends Controller
{
    //
    public function index(){
        $Working = Working::all();

        return view('working')->with('working',$Working);
    }

    public function work($id){
        $work = Working::find($id);
        $work->update(['working'=>1]);

        return redirect()->route('work.index')->with('success', 'Working Successfully Updated');
    }

    public function non_work($id){
        $work = Working::find($id);
        $work->update(['working'=>0]);

        return redirect()->route('work.index')->with('success', 'Working Successfully Updated');
    }
  
  
}
