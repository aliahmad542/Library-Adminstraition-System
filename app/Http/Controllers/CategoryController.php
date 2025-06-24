<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add_category(Request $request){
     $addCategory=Category::create([
        'name'=>$request->name]
     );
     return response()->json('A new category has been added');
    }
}
