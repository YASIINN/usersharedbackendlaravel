<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function getcategory(){
        $value =  Cache::rememberForever('category', function() {
            $result=DB::table('category')->get();
            return $result;
        });
     return response()->json($value, 200);
    }
}
