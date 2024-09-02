<?php

namespace App\Http\Controllers;

use App\Absent;
use App\Employee;
use App\Http\Resources\Absent as AbsentResources;
use App\Raw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsentController extends Controller
{
    //
    public function index()
    {

        $full = Absent::where([['active', 1], ['for' , 1]])->get();
        $morning = Absent::where([['active',1], ['for' , 2]])->get();
        $afternoon = Absent::where([['active',1], ['for' , 3]])->get();

        return view('absent')->with('full', $full)->with('morning', $morning)->with('afternoon', $afternoon);
    }

    public function full(Request $request)
    {
        $array = explode('-', $request->daterange);
        $valstart = trim($array[0]);
        $time = strtotime($valstart);

        $start = date('Y-m-d', $time);
        $valend = trim($array[1]);
        $endtime = strtotime($valend);
        $end = date('Y-m-d', $endtime);
        Absent::where('active', 1)->delete();
        $Acc_id = Raw::select('acc_id')->distinct()->get();

        set_time_limit(0);

        foreach ($Acc_id as $id) {
            $absent = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['morning', 1]])->get();
            $emp = Employee::where([['acc_id', $id->acc_id], ['is_active', 1]])->first();
            if ($emp) {
                $lunchLate = 0;
                if ($absent->count()) {
                    foreach ($absent as $abs) {
                        $datevalue = Raw::where([['date', $abs->date], ['acc_id', $id->acc_id]])->orderBy('morning', 'DESC')->get();
                        if ($datevalue[0]->check_out == "00:00:00" && $datevalue[1]->check_in == "00:00:00" && $datevalue[1]->check_out == "00:00:00" && $datevalue[0]->check_in == "00:00:00") {

                            Absent::updateOrCreate(['active' => 1, 'acc_id' => $datevalue[0]->acc_id, 'date' => $datevalue[0]->date], ['to' => $end, 'from' => $start, 'name' => $datevalue[0]->name, 'for' => 1]);
                        } else if ($datevalue[1]->check_out == "00:00:00") {
                            Absent::updateOrCreate(['active' => 1, 'acc_id' => $datevalue[0]->acc_id, 'date' => $datevalue[0]->date], ['to' => $end, 'from' => $start, 'name' => $datevalue[0]->name, 'for' => 3]);
                        } else if ($datevalue[0]->check_in == "00:00:00" && $datevalue[1]->check_out != "00:00:00") {
                            Absent::updateOrCreate(['active' => 1, 'acc_id' => $datevalue[0]->acc_id, 'date' => $datevalue[0]->date], ['to' => $end, 'from' => $start, 'name' => $datevalue[0]->name, 'for' => 2]);
                        }
                    }



                }
            }


        }
        return redirect()->route('absent.index')->with('success', 'All good!');
    }

    public function show()
    {
        $calculate = Absent::orderBy('acc_id', 'asc')->get();
        return AbsentResources::collection($calculate);
    }
    public function planned(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 'planned']);
        return response()->json(['message' => 'Updated']);
    }
    public function un_planned(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 'un-planned']);
        return response()->json(['message' => 'Updated']);
    }
    public function on_project(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 'on-project']);
        return response()->json(['message' => 'Updated']);
    }
    public function sick(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 'sick']);
        return response()->json(['message' => 'Updated']);
    }
    public function non_sick(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 'Non-Validated Sick']);
        return response()->json(['message' => 'Updated']);
    }
    public function absent(Request $request)
    {
        $planned = Absent::find($request->id);
        $planned->update(['remark' => 0]);
        return response()->json(['message' => 'Updated']);
    }
}
