<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Warning;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $war = Warning::where('excuse',null)->groupBy('employee_id')->orderBy('created_at','DESC')->paginate(10);
        $loan = Loan::whereMonth('date', Carbon::now()->month)->orderBy('created_at','DESC')->paginate(10);
        return view('dashboard')->with('loan',$loan)->with('war',$war);
    }
}
