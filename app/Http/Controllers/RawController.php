<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Exports\AttendanceExport;
use App\Exports\WebHrExport;
use App\Exports\ExportWebHr;
use App\Exports\ReprimandExport;
use App\Http\Resources\Raw as RawResource;
use App\Imports\RawsImport;
use App\Imports\BioTimeImport;
use App\Imports\MachineImport;
use App\Imports\WebhrAbsentImport;
use App\Imports\IncentiveImport;
use App\Imports\WebhrImport;
use App\Imports\WebhrLateImport;
use App\Imports\WebhrBreakImport;
use App\NewResign;
use App\Raw;
use App\Time;
use App\Webhr;
use App\WebhrAbsent;
use Illuminate\Support\Facades\Artisan;
use App\WebhrLate;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function GuzzleHttp\Promise\all;

class RawController extends Controller
{
    //
    public function import(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'raw' => 'required',
        ]);
        // (request()->file('raw'));
        Excel::import(new BioTimeImport, $request->file('raw'));

        return redirect()->route('raw.import')->with('success', 'Import Complete');
    }

    public function webhrImport(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'webhr' => 'required|mimes:xlsx',
        ]);
        
        Excel::import(new WebhrImport, $request->file('webhr'));
        
        $webhr = Webhr::where('status', 'Active')->select('acc_id', 'full_name')->distinct()->get();
        foreach ($webhr as $r) {
            $name = explode(" ",$r->full_name);
            $name = $this->split_name($r->full_name);
         
            
            if($r->acc_id != null){
                $emp = Employee::where('acc_id', $r->acc_id)->first();
                if(!$emp){
                   Employee::create(['acc_id' => $r->acc_id, 'joining_date' => $r->joining_date, 
                 'full_name' => $r->full_name , 'first_name' => $name[0] , 'last_name' => $name[1], 'is_active' =>1]);
      
                }
                else{
                    $emp->update(['joining_date' => $r->joining_date, 'full_name' => $r->full_name , 'first_name' => $name[0] , 'last_name' => $name[1]]);
                }
                 
            }
           
        }
        return redirect()->route('webhr.index')->with('success', 'Import is Complete');
    }

    public function webhrAbsentImport(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'webhr' => 'required|mimes:xlsx',
        ]);
        // (request()->file('raw'));
        Excel::import(new WebhrAbsentImport, $request->file('webhr'));

        return redirect()->route('webhr.sick')->with('success', 'Import Complete');
    }

    public function webhrLateImport(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'webhr' => 'required|mimes:xlsx',
        ]);
        // (request()->file('raw'));
        Excel::import(new WebhrLateImport, $request->file('webhr'));

        return redirect()->route('webhr.late')->with('success', 'Import Complete');
    }
    
     public function webhrLunchImport(Request $request){
        set_time_limit(300);
        $request->validate([
            'webhr' => 'required|mimes:xlsx',
        ]);
        
        $import = new WebhrBreakImport();
        Excel::import($import, $request->file('webhr'));
       
        return redirect()->route('webhr.late')->with('success', 'Import Complete');
    }

    function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }

    public function index(Request $request)
    {
        $raw = Raw::where('morning', 1)->orderBy('date', 'desc')->paginate();

        return view('import')->with("raws", $raw);
    }

    public function webhrIndex(Request $request)
    {
        $webhr = Webhr::paginate(10);

        return view('webhrImport')->with("webhr", $webhr);
    }

    public function webhrLeave(Request $request)
    {
        $webhr = Webhr::paginate(10);

        return view('webhrImportleave')->with("webhr", $webhr);
    }

    public function webhrSick(Request $request)
    {
        $webhr = Webhr::paginate(10);

        return view('webhrImportsick')->with("webhr", $webhr);
    }

    public function webhrAbsent(Request $request)
    {
        $webhr = WebhrAbsent::paginate(10);

        return view('webhrImportabsent')->with("webhr", $webhr);
    }

    public function webhrLate(Request $request)
    {
        $webhr = WebhrLate::whereNotNull('late')
            ->orderBy('created_at', 'desc') // Order by the "created_at" column in descending order
            ->paginate(10);
        return view('webhrImportlate')->with("webhr", $webhr);
    }
    
    public function breakLate(Request $request)
    {
        $webhr = WebhrLate::whereNotNull('lunch_late')->paginate(10);
        
        return view('break')->with("webhr", $webhr);
    }
    
    public function newBreak(Request $request)
    {
        return "test";
    }
    
    public function clearCache()
    {
        Artisan::call('optimize');
        return "Cache is cleared";
    }

    public function webhrTravel(Request $request)
    {
        $webhr = Webhr::paginate(10);

        return view('webhrImporttravel')->with("webhr", $webhr);
    }

    public function webhrNew(Request $request)
    {
        $news = NewResign::all();
        $employees = Employee::all();
        $noemploye = [];
        
        foreach($news as $n){
            $employee = Employee::find($n->employee_id);
            if(!$employee){
                array_push($noemploye,$n);
            }
        }
// dd($noemploye);
        return view('webhrImportnew',compact('employees','news'));
    }

    public function show()
    {
        $raw = Raw::where('morning', 1)->orderBy('date', 'asc')->get();

        return RawResource::collection($raw);
    }

    public function export()
    {
        return Excel::download(new AttendanceExport, 'AttendanceReport.xlsx');
    }

    public function webhrExport(Request $req)
    {
        Time::truncate();
        $array = explode('-', $req->daterange);
        $start = trim($array[0]);
        $time = strtotime($start);

        $newstart = date('Y-m-d', $time);
        $end = trim($array[1]);
        $endtime = strtotime($end);
        $newend = date('Y-m-d', $endtime);
        Time::updateOrCreate(['from'=>$newstart,'to'=>$newend]);

        //return Excel::download(new WebHrExport, 'webhrimport.xlsx');
         return Excel::download(new ExportWebHr, 'webhrimport '.date("Y.m.d").'.xlsx');
        
    }

    public function webhrUpdateIndex($id)
    {
        $webhr = Webhr::find($id);

        return view('edit_webhr')->with("webhr", $webhr);
    }

    public function webhrUpdate(Request $req, $id)
    {
        $webhr = Webhr::find($id);
        $webhr->update([
            'email' => $req->email,
            'full_name' => $req->name,
            'acc_id' => $req->acc_id
        ]);

        try{
            $emp = Employee::where('acc_id',$req->acc_id)->first();
           
            if($webhr->type == "Intern" || $webhr->type == "Probation"){
                $emp->update(['probation'=>1]);
            }

        }catch(Exception $e){

        }
        return redirect()->route('webhr.index');
    }
    public function updateFromWebHr(){
         $client = new \GuzzleHttp\Client();

        // Define array of request body.
        $request_body = array();

        $headers = [

            'Accept'        => 'application/json',

        ];
        try {
            $response = $client->request('GET','https://ienetwork.webhr.co/api/json/?key=1A3RGvaCtMXr9DLaNM87W0zQMr5u2YwJ&request=EMPLOYEES_EMPLOYEESLIST', array(
                'headers' => $headers,
                
                'json' => $request_body,
               )
            );
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $jArr = json_decode($body,true);
          $result = [];
           $uresult = [];
          
            foreach($jArr as $j){
                 if(is_array($j)){
                     $count = 0;
                      $ucount = 0;
                    foreach($j as $employee){
                        $c = Webhr::where('user_name',$employee['UserName'])->first();
                       
                    if($c){
                      
                        $c->full_name = $employee['FullName'];
                        $c->email = $employee['EmailAddress'] ;
                       
                        $c->designation = $employee['Designation'] ;
                        $c->joining_date = $employee['JoiningDate'] ;
                       
                        
                       $c->department = $employee['DepartmentName'];
                          $c->status =  $employee['Status'];
                       
                       $c->save();
                      $emp = Employee::where('acc_id', $c->acc_id)->first();
                      if($employee['Status'] == "Active"){
                          $emp->is_active = 1;
                      }
                      else if($employee['Status'] == "Inactive"){
                          $emp->is_active = 0;
                      }
                      $emp->save();
                          
                    
                        }
                    //existing employee with updates
                    
              
                    }
                    
            }
            
             }
           
             return "updated";
          

         }
         catch (\GuzzleHttp\Exception\BadResponseException $e) {
            // handle exception or api errors.
           return "Error!";
         }
    }

    public function webhrShow()
    {
        return view('webhrcalculate');
    }

    public function changeAbsent(Request $request)
    {
        $user = WebhrAbsent::find($request->user_id);
        $user->validated = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

    public function changeLate(Request $request)
    {
        $user = WebhrLate::find($request->user_id);
        $user->validated = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
    public function savestaff(Request $req){
        NewResign::updateOrCreate(['employee_id'=>$req->employee_id],['date'=>$req->date,'remark'=>$req->staff]);

        return redirect()->route('webhr.new');
    }

    public function deletestaff($id){
        $new = NewResign::find($id);
        $new->delete();

        return redirect()->route('webhr.new');
    }
    
    public function reprimandShow()
    {
        return view('reptemplateexport');
    }

    public function reprimandExport(Request $req)
    {
        Time::truncate();
        $array = explode('-', $req->daterange);
        $start = trim($array[0]);
        $time = strtotime($start);

        $newstart = date('Y-m-d', $time);
        $end = trim($array[1]);
        $endtime = strtotime($end);
        $newend = date('Y-m-d', $endtime);
        Time::updateOrCreate(['from'=>$newstart,'to'=>$newend]);

        return Excel::download(new ReprimandExport, 'reprimandExport.xlsx');
    }
    
    public function incentive()
    {
        return view('incentive');
    }
    
    public function incentiveImport(Request $request){
        set_time_limit(300);
        $request->validate([
            'incentive' => 'required|mimes:xlsx',
        ]);
        
        // (request()->file('incentive'));
        Excel::import(new IncentiveImport, $request->file('incentive'));

        return redirect()->route('merit.index')->with('success', 'Import Complete');
    }

}
