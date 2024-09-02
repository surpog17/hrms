<?php

namespace App\Http\Controllers;

use App\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    //
    public function index()
    {
        $holiday = Holiday::orderBy('date', 'ASC')->paginate(5);

        return view('holiday')->with('holiday', $holiday);
    }

    public function store(Request $request)
    {
        Holiday::updateOrCreate(['date' => $request->holiday_date], ['name' => $request->holiday]);
        return redirect()->route('holiday.index')->with('success', 'Holiday Saved');
    }

    public function delete($id)
    {
        $holiday = Holiday::find($id);

        $holiday->delete();

        return redirect()->route('holiday.index')->with('danger', 'Holiday Deleted');
    }
    public function update(Request $request)
    {
        // ($request->holiday_date);
        $holiday = Holiday::find($request->holiday_id);
        // ($request->holiday_id);
        $holiday->update(['date' => $request->holiday_date], ['name' => $request->holiday]);

        return redirect()->route('holiday.index')->with('success', 'Holiday Saved');
    }
}
