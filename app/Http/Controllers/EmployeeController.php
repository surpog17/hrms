<?php

namespace App\Http\Controllers;

use App\Employee;
use App\RegisteredAbsent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Exports\EmpExport;
use App\Exports\PrintExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Yajra\Datatables\Facades\Datatables;


class EmployeeController extends Controller
{
    //

    public function index(Request $request)
    {
        $allemployees = Employee::orderBy('full_name', 'ASC')->get();
        if(is_numeric($request->employee_selected)){
            $employee = Employee::where('id',$request->employee_selected)->orderBy('is_active', 'desc')->orderBy('full_name', 'ASC')->paginate(15);
        }else{
            $employee = Employee::orderBy('is_active', 'desc')->orderBy('full_name', 'ASC')->paginate(15);
        }    

        return view('shift')->with('employee', $employee)->with('allemployees',$allemployees);
    }
    public function active(Request $request)
    {
        $employee = Employee::find($request->id);
        // ($employee);
        $employee->update(['is_active' => $request->active]);
        // return redirect()->route('employee')->with('success', 'active updated');
        return response()->json(['message' => 'Updated']);
    }
    public function management(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->update(['is_manager' => $request->active]);

        return response()->json(['message' => 'Updated']);
    }
    public function driver(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->update(['is_driver' => $request->active]);

        return response()->json(['message' => 'Updated']);
    }
    public function leave()
    {
        $employee = Employee::where('is_active', 1)->get();
        $registered = RegisteredAbsent::where([['google_id', auth()->user()->google_id], ['for', 1]])->get();

        return view('employee.leave')->with('employees', $employee)->with('registered', $registered);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'attachment' => 'mimes:jpeg,png,bmp,tiff |max:4096',
        ]);

        $uploadedFile = $request->file('attachment');
        $filename = time() . $uploadedFile->getClientOriginalName();
        //   ($filename);
        Storage::disk('local')->putFileAs(
            'public/' . $filename,
            $uploadedFile,
            $filename
        );

        $register = RegisteredAbsent::create([
            'employee_id' => $request->employee,
            'for' => 1,
            'from' => $request->from_date,
            'to' => $request->to_date,
            'attachment' => $filename,
            'google_id' => auth()->user()->google_id,
        ]);
        return redirect()->route('leave.request')->with('success', 'Succfully Submited');
    }
    public function download($id)
    {
        $registered = RegisteredAbsent::find($id);
        $filepath = public_path().'/storage/' . $registered->attachment.'/'.$registered->attachment;
        $headers = array(
            'Content-Disposition' => 'attachment',
        );

        return Response::download($filepath, $registered->attachment, $headers);
    }
    public function onProject()
    {
        $employee = Employee::where('is_active', 1)->get();
        $registered = RegisteredAbsent::where([['google_id', auth()->user()->google_id], ['for', 2]])->get();

        return view('employee.onproject')->with('employees', $employee)->with('registered', $registered);
    }
    public function storeOnProject(Request $request)
    {

        $register = RegisteredAbsent::create([
            'employee_id' => $request->employee,
            'for' => 2,
            'from' => $request->from_date,
            'to' => $request->to_date,
            'remark' => $request->remark,
            'google_id' => auth()->user()->google_id,
        ]);
        return redirect()->route('onproject.request')->with('success', 'Succfully Submited');
    }
    public function check_in()
    {
        $employee = Employee::where('is_active', 1)->get();
        $registered = RegisteredAbsent::where([['google_id', auth()->user()->google_id], ['for', 3]])->get();

        return view('employee.check_in')->with('employees', $employee)->with('registered', $registered);
    }
    public function storeCheck_in(Request $request)
    {

        $register = RegisteredAbsent::create([
            'employee_id' => $request->employee,
            'for' => 3,
            'date' => $request->checkin_date,
            'remark' => $request->remark,
            'google_id' => auth()->user()->google_id,
        ]);
        return redirect()->route('check_in.request')->with('success', 'Succfully Submited');
    }

    public function approveLeave()
    {
        $registered = RegisteredAbsent::where('for', 1)->orderBy('created_at', 'ASC')->paginate(5);
        return view('approveLeave')->with('registered', $registered);
    }
    public function updateLeave(Request $request)
    {
        $registered = RegisteredAbsent::findOrFail($request->user_id);
        $registered->validated = $request->status;
        $registered->save();

        return response()->json(['message' => 'Updated']);
    }
    public function approveOnProject()
    {
        $registered = RegisteredAbsent::where('for', 2)->orderBy('created_at', 'ASC')->paginate(5);
        return view('approveOnProject')->with('registered', $registered);
    }
    public function approveForgetCheckin()
    {
        $registered = RegisteredAbsent::where('for', 3)->orderBy('created_at', 'ASC')->paginate(5);
        return view('approveForgetCheckin')->with('registered', $registered);
    }

    public function destroy($id){
        $registered = RegisteredAbsent::findOrFail($id);
        $registered->delete();

        return back()->with("danger","Successfully deleted");
    }

    public function employeeindex($alpha = null){
        
        
        if($alpha == "A"){
            $users = null;
            $queryStr = ["A","B","C","D","E"];
            $users = DB::Table('employees')->where('is_active',1)->where(function ($query) use ($queryStr) {foreach($queryStr as $q){$query->orwhere('full_name', 'like',  $q . '%');}})->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
        }elseif($alpha == "F"){
            $users = null;
            $queryStr = ["F","G","H","I","J"];
            $users = DB::Table('employees')->where('is_active',1)->where(function ($query) use ($queryStr) {foreach($queryStr as $q){$query->orwhere('full_name', 'like',  $q . '%');}})->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
            
        }elseif($alpha == "K"){
            $users = null;
            $queryStr = ["K","L","M","N","O"];
            $users = DB::Table('employees')->where('is_active',1)->where(function ($query) use ($queryStr) {foreach($queryStr as $q){$query->orwhere('full_name', 'like',  $q . '%');}})->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
            
        }elseif($alpha == "P"){
            $users = null;
            $queryStr = ["P","Q","R","S","T"];
            $users = DB::Table('employees')->where('is_active',1)->where(function ($query) use ($queryStr) {foreach($queryStr as $q){$query->orwhere('full_name', 'like',  $q . '%');}})->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
            
        }elseif($alpha == "U"){
            $users = null;
            $queryStr = ["U","V","W","X","Y","Z"];
            $users = DB::Table('employees')->where('is_active',1)->where(function ($query) use ($queryStr) {foreach($queryStr as $q){$query->orwhere('full_name', 'like',  $q . '%');}})->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
            
        }else{
            $users = null;
            $users = Employee::where('is_active',1)->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
        }
//  $users = Employee::where('is_active',1)->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->paginate(15);
        return view('employee_index')->with('users',$users);
        
        
    }
public function getAllEmployees(){
         if ($request->ajax()) {
            $data = Employee::where('is_active',1)->orderBy('probation', 'desc')->orderBy('full_name', 'asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
}
    public function employeecreate(){
        return view('employee_create');
    }

    public function employeestore(Request $req){

        // ($req->probation);
        $val = 0;
        if($req->probation=="on"){
            $val=1;
        };
        Employee::updateOrCreate([
            'acc_id'=>$req->acc_id
        ],[
            'full_name'=>$req->name,
            'is_active'=>1,
            'probation'=>$val,
            'basic_salary'=>$req->basic_salary
        ]);

        return redirect()->route('employee.index');

    }

    public function employeeedit($id){
        $employee = Employee::find($id);

        return view('employee_edit')->with('employee',$employee);
    }

    public function employeeupdate(Request $req,$id){
        $employee = Employee::find($id);

        $val = 0;
        if($req->probation=="on"){
            $val=1;
        };
        // ($val);
        $employee->update([
            'acc_id'=>$req->acc_id,
            'full_name'=>$req->name,
            'probation'=>$val,
            'basic_salary'=>$req->basic_salary
        ]);

        return redirect()->route('employee.index');
    }
    public function empexport()
    {
        return view('employeexport');
    }
     public function attexp()
    {
        try{
        return Excel::download(new EmpExport, 'Zkexport '.date("Y.m.d").'.xlsx');
        }
        catch(Exception $e){
           
        }
    }
     public function ptrexp()
    {
        return Excel::download(new PrintExport, 'printexport.xls');
    }

    public function employeedestroy($id){
        $employee = Employee::find($id);
        $employee->delete();

        return redirect()->route('employee.index');
    }
     public function exportEmployees()
    {
        // Run the SQL query and fetch the results
        $queryResult = DB::select("
            SELECT * 
            FROM employees 
            WHERE is_active = 1
        ");        
        // Convert the result to a CSV string
        $csvData = $this->generateCsvData($queryResult);

        // Set the headers for CSV download
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=employees.csv',
        );

        // Create a response with the CSV data and headers
        return Response::make($csvData, 200, $headers);
    }

    private function generateCsvData($data)
    {
        $output = fopen('php://temp', 'w');

        // Write the header row
        fputcsv($output, array_keys((array) $data[0]));

        // Write the data rows
        foreach ($data as $row) {
            fputcsv($output, (array) $row);
        }

        rewind($output);
        $csvData = stream_get_contents($output);
        fclose($output);

        return $csvData;
    }
}
