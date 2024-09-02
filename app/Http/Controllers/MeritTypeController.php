<?php

namespace App\Http\Controllers;

use App\MeritType;
use Illuminate\Http\Request;

class MeritTypeController extends Controller
{
    //
    public function index()
    {
        $types = MeritType::all();
        return view('merit_type')->with('types', $types);
    }
    public function store(Request $request){
        MeritType::updateOrCreate(['name'=>$request->type]);
        return redirect()->route('merit.type')->with('success','Merit Type Created');
    }

    public function delete($id){
        $type = MeritType::find($id);
        $type->delete();

        return redirect()->route('merit.type')->with('danger','Merit Type Deleted');
    }

    public function update(Request $request){
        // ($request->type_id);
        $type = MeritType::find($request->type_id);
        $type->update(['name'=>$request->type]);

        return redirect()->route('merit.type')->with('success','Merit Type Updated');
    }
}
