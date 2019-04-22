<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserLocationController extends Controller
{
    public function adduserlocation($usid,$locationname,$locationcoord,$ip)
    {
        $result= DB::table('userlocation')->insertGetId(
            [
               "usid"=> $usid,
               "locationname"=> $locationname,
               "locationcoord"=> $locationcoord,
               "ip"=> $ip,
           ]
        );
        if($result){
            $record=DB::table('userlocation')->get()->where("id",$result);
            if(count($record)>0){
            return response()->json($record);

            }else{
                return response()->json(['status'=>"Not"]);
            }
        }
    }
}
