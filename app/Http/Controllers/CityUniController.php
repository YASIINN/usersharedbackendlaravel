<?php

namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CityUniController extends Controller
{
    public function getcityuni($cityid){
        
        $university = DB::table('cityuni')
        ->join('city', 'cityuni.cityid', '=', 'city.cityid')
        ->join('university', 'cityuni.universityid', '=', 'university.universityid')
        ->select('cityuni.*', 'city.*', 'university.*')
        ->where("cityuni.cityid",$cityid)
        ->get();
        if(count($university)>0){
            return response()->json($university, 200);
        }else{
            return response()->json([],204);
        }
        //
    }
    public function test(Request $request){
                print_r($request[0]->ad);

    }
}
