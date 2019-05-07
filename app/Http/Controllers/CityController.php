<?php

namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
        public function getallcity(){
            $value =  Cache::rememberForever('city', function() {
                $results = DB::select('select * from city');
                return $results;
            });
         return response()->json($value, 200);
        }
}
