<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getcategory(){
        $result=DB::table('category')->get();
        return response()->json($result, 200);
    }
}
