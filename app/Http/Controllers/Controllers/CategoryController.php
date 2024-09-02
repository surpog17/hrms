<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function index(){
        $categories = Category::all();

        return view('category')->with('categories',$categories);
    }

    public function store(Request $request){
        Category::updateOrCreate(['name'=>$request->type,'duration'=>$request->duration]);
        return redirect()->route('category.index')->with('success','Category Created');
    }

    public function delete($id){
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('category.index')->with('danger','Category Deleted');
    }

    public function update(Request $request){
        // ($request->type_id);
        $category = Category::find($request->type_id);
        $category->update(['name'=>$request->type,'duration'=>$request->duration]);

        return redirect()->route('category.index')->with('success','Category Updated');
    }
}

