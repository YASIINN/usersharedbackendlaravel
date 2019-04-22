<?php

namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CityController extends Controller
{
        public function getallcity(){
            $results = DB::select('select * from city');

          return response()->json($results, 200);
        }
}
