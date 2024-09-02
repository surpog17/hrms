<?php

namespace App\Http\Controllers;

use App\Calculated;
use App\Employee;
use App\Http\Resources\Calculated as CalculateResource;
use App\Morning;
use App\Raw;
use Illuminate\Http\Request;
use DB;
use \stdClass;

class CalculatedController extends Controller
{
    //
    public function CalculateMorningLate($start, $end)
    {


        $Acc_id = Raw::select('acc_id')->distinct()->get();

        // ($end);
        // $vals = Raw::whereBetween('date', [$start, $end])->get();
        // ($vals);

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $time = '8:00';
                if ($emp->is_manager) {
                    $time = '7:30';
                } else if ($emp->is_driver) {
                    $time = '7:30';
                } else {
                    $time = '8:00';
                }
                $morning = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['morning', 1], ['check_in', '>', $time]])->get();
                $morningLate = 0;

                $late = [];
                // ($morning);
                if ($morning->count()) {
                    foreach ($morning as $morning_late) {
                        $late[] = (strtotime($morning_late->check_in) - strtotime($time)) / 60 * 60;
                    }
                    foreach ($late as $value) {
                        $morningLate += $value;
                    }
                    // ($morning->first()->name);
                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $morning->first()->name, 'morning_late' => $morningLate]);
                }
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }

    public function CalculateAfternoonEarly($start, $end)
    {

        $Acc_id = Raw::select('acc_id')->distinct()->get();

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $afternoon = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['afternoon', 1], ['check_out', '<', '17:30'], ['check_out', '>', '00:00']])->get();
                $afternoonEarly = 0;
                $early = [];
                if ($afternoon->count()) {
                    foreach ($afternoon as $afternoon_Early) {
                        $early[] = (strtotime('17:30') - strtotime($afternoon_Early->check_out)) / 60 * 60;
                    }
                    foreach ($early as $value) {
                        $afternoonEarly += $value;
                    }
                    // ($morning->first()->name);
                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $afternoon->first()->name, 'afternoon_early' => $afternoonEarly]);
                }
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }

    public function CalculateAfternoonOvertime($start, $end)
    {

        $Acc_id = Raw::select('acc_id')->distinct()->get();

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $afternoon = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['afternoon', 1], ['check_out', '>', '17:30']])->get();
                $afternoonOvertime = 0;
                $overtime = [];
                if ($afternoon->count()) {
                    foreach ($afternoon as $afternoon_Overtime) {
                        $overtime[] = (strtotime($afternoon_Overtime->check_out) - strtotime('17:30')) / 60 * 60;
                    }
                    foreach ($overtime as $value) {
                        $afternoonOvertime += $value;
                    }
                    // ($morning->first()->name);
                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $afternoon->first()->name, 'afternoon_overtime' => $afternoonOvertime]);
                }
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }
    public function CalculateMorningOvertime($start, $end)
    {

        $Acc_id = Raw::select('acc_id')->distinct()->get();

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $time = '8:00';
                if ($emp->is_manager) {
                    $time = '7:30';
                } else if ($emp->is_driver) {
                    $time = '7:30';
                } else {
                    $time = '8:00';
                }
                $morning = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], ['morning', 1], ['check_in', '<', $time], ['check_in', '>', '00:00']])->get();
                $morningOvertime = 0;
                $overtime = [];
                // ($morning);
                if ($morning->count()) {
                    foreach ($morning as $morning_overtime) {
                        $overtime[] = (strtotime($time) - strtotime($morning_overtime->check_in)) / 60 * 60;
                    }
                    // ($overtime);
                    foreach ($overtime as $value) {
                        $morningOvertime += $value;
                    }
                    // ($morning->first()->name);
                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $morning->first()->name, 'morning_ovetime' => $morningOvertime]);
                }
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }

    public function CalculateWeekendOvertime($start, $end)
    {
        $Acc_id = Raw::select('acc_id')->distinct()->get();

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $weekend = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '>', 4], ['morning', 1]])->get();
                $overtime = [];
                $weekendOvertime = 0;
                if ($weekend->count()) {
                    foreach ($weekend as $weekend_overtime) {
                        $datevalue = Raw::where([['date', $weekend_overtime->date], ['acc_id', $id->acc_id]])->orderBy('morning', 'DESC')->get();
                        if ($datevalue[1]->check_out != "00:00:00" && $datevalue[0]->check_in != "00:00:00") {
                            $overtime[] = (strtotime($datevalue[1]->check_out) - strtotime($datevalue[0]->check_in)) / 60 * 60;
                        } else if ($datevalue[1]->check_out != "00:00:00" && $datevalue[0]->check_out != "00:00:00") {
                            $overtime[] = (strtotime($datevalue[1]->check_out) - strtotime($datevalue[0]->check_out)) / 60 * 60;
                        } else if ($datevalue[1]->check_out != "00:00:00" && $datevalue[1]->check_in != "00:00:00") {
                            $overtime[] = (strtotime($datevalue[1]->check_out) - strtotime($datevalue[1]->check_in)) / 60 * 60;
                        } else if ($datevalue[1]->check_out != "00:00:00") {
                            $overtime[] = (strtotime($datevalue[1]->check_out) - strtotime('8:00')) / 60 * 60;
                        } else if ($datevalue[1]->check_in != "00:00:00") {
                            if ($datevalue[0]->check_in != "00:00:00") {
                                $overtime[] = (strtotime($datevalue[1]->check_in) - strtotime($datevalue[0]->check_in)) / 60 * 60;
                            } else {
                                $overtime[] = (strtotime($datevalue[1]->check_in) - strtotime('8:00')) / 60 * 60;
                            }
                        } else if ($datevalue[0]->check_out != "00:00:00") {
                            if ($datevalue[0]->check_in != "00:00:00") {
                                $overtime[] = (strtotime($datevalue[0]->check_out) - strtotime($datevalue[0]->check_in)) / 60 * 60;
                            } else {
                                $overtime[] = (strtotime($datevalue[0]->check_out) - strtotime('8:00')) / 60 * 60;
                            }
                        }

                        // if($weekend_overtime)
                        // $overtime[] = (strtotime('8:00')-strtotime($morning_overtime->check_in))/60*60;
                    }


                    foreach ($overtime as $value) {
                        $weekendOvertime += $value;
                    }

                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $weekend->first()->name, 'weekend_overtime' => $weekendOvertime]);
                }

                // ($weekend);
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }
    public function Calculatelunchlate($start, $end)
    {
        $Acc_id = Raw::select('acc_id')->distinct()->get();

        foreach ($Acc_id as $id) {
            $emp = Employee::where([['acc_id', $id->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $lunch = Raw::whereBetween('date', [$start, $end])->where([['acc_id', $id->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['morning', 1]])->get();
                $late = [];
                $lunchLate = 0;
                if ($lunch->count()) {
                    foreach ($lunch as $lunch_late) {
                        $datevalue = Raw::where([['date', $lunch_late->date], ['acc_id', $id->acc_id]])->orderBy('morning', 'DESC')->get();
                        if ($datevalue[1]->check_in != "00:00:00" && $datevalue[0]->check_out != "00:00:00") {
                            if ((((strtotime($datevalue[1]->check_in) - strtotime($datevalue[0]->check_out)) / 60 * 60) - 3600) > 0) {
                                $late[] = (((strtotime($datevalue[1]->check_in) - strtotime($datevalue[0]->check_out)) / 60 * 60) - 3600);
                            }
                        } else if ($datevalue[1]->check_in != "00:00:00") {
                            if ((((strtotime($datevalue[1]->check_in) - strtotime("12:30")) / 60 * 60) - 3600) > 0) {
                                $late[] = (((strtotime($datevalue[1]->check_in) - strtotime("12:30")) / 60 * 60) - 3600);
                            }
                        } else if ($datevalue[0]->check_out != "00:00:00") {
                            if ((((strtotime("13:16") - strtotime($datevalue[0]->check_out)) / 60 * 60) - 3600) > 0) {
                                $late[] = (((strtotime("13:16") - strtotime($datevalue[0]->check_out)) / 60 * 60) - 3600);
                            }
                        }
                        // if($weekend_overtime)
                        // $overtime[] = (strtotime('8:00')-strtotime($morning_overtime->check_in))/60*60;
                    }

                    // ($late);
                    foreach ($late as $value) {
                        $lunchLate += $value;
                    }

                    // ($id->acc_id);
                    Calculated::updateOrCreate(['active' => 1, 'acc_id' => $id->acc_id], ['name' => $lunch->first()->name, 'lunch_late' => $lunchLate]);
                }

                // ($weekend);
            }
        }
        // return redirect('/home')->with('success', 'All good!');
    }

    public function index()
    {

        $calculate = Calculated::orderBy('acc_id', 'asc')->get();

        return CalculateResource::collection($calculate);
    }

    public function AllCalculation(Request $request)
    {
        set_time_limit(300);
        $array = explode('-', $request->daterange);
        $start = trim($array[0]);
        $time = strtotime($start);

        $newstart = date('Y-m-d', $time);
        $end = trim($array[1]);
        $endtime = strtotime($end);
        $newend = date('Y-m-d', $endtime);
        // ($start);
        Morning::where('active', 1)->delete();
        Calculated::where('active', 1)->delete();
        $this->CalculateMorningLate($newstart, $newend);
        $this->CalculateAfternoonEarly($newstart, $newend);
        $this->CalculateAfternoonOvertime($newstart, $newend);
        $this->CalculateMorningOvertime($newstart, $newend);
        $this->CalculateWeekendOvertime($newstart, $newend);
        $this->Calculatelunchlate($newstart, $newend);
        Calculated::where('active', 1)->update(['from' => $newstart, 'to' => $newend]);
        return redirect()->route('calculate.show')->with('success', 'All good!');
    }

    public function show()
    {
        $morning = Morning::all();
        $calculate = Calculated::orderBy('acc_id', 'asc')->paginate(5);

        return view('calculate')->with('morning', $morning)->with('calculate',$calculate);
    }

    public function morning_detail()
    {
        $calculated = Calculated::where(['active' => 1])->get();
        // ($calculated)
        foreach ($calculated as $cal) {
            $emp = Employee::where([['acc_id', $cal->acc_id],['is_active', 1]])->first();
            if ($emp) {
                $time = '8:00';
                if ($emp->is_manager) {
                    $time = '7:30';
                } else if ($emp->is_driver) {
                    $time = '7:30';
                } else {
                    $time = '8:00';
                }
                $morning = Raw::whereBetween('date', [$cal->from, $cal->to])->where([['acc_id', $cal->acc_id], [DB::raw('WEEKDAY(date)'), '<', 5], ['morning', 1], ['check_in', '>', $time]])->get();

                if ($morning->count()) {
                    foreach ($morning as $morning_late) {

                        $late = (strtotime($morning_late->check_in) - strtotime($time)) / 60 * 60;

                        Morning::updateorcreate(['calculated_id' => $cal->id, 'date' => $morning_late->date], ['late' => $late, 'active' => 1]);
                    }
                }
            }
        }
        // ($late);
        return redirect()->route('calculate.show')->with('success', 'All good!');
    }
}
