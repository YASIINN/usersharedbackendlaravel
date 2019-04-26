<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserTimeController extends Controller
{
     public function addusertime($usid,$logintime,$logouttime,$ip,$logindate,$logoutdate)
    {
        $result= DB::table('usertime')->insertGetId(
            [
               "usid"=> $usid,
               "logintime"=> $logintime,
               "logouttime"=> $logouttime,
               "ip"=> $ip,
               "logindate"=>$logindate,
               "logoutdate"=>$logoutdate
           ]
        );
        if($result){
            $record=DB::table('usertime')->get()->where("id",$result);
            return response()->json($record);
        }else{
            return response()->json(['status'=>"Not"]);
        }
    }

}
