<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //
    public function index(){
        $types = Type::all();

        return view('type')->with('types',$types);
    }

    public function store(Request $request){
        Type::updateOrCreate(['name'=>$request->type]);
        return redirect()->route('type.index')->with('success','Type Created');
    }

    public function delete($id){
        $type = Type::find($id);
        $type->delete();

        return redirect()->route('type.index')->with('danger','Type Deleted');
    }

    public function update(Request $request){
        // ($request->type_id);
        $type = Type::find($request->type_id);
        $type->update(['name'=>$request->type]);

        return redirect()->route('type.index')->with('success','Type Updated');
    }
}
