<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PasswordController extends Controller
{
    public function createuserpass($psw,$user){
        $result=DB::table("password")->insert(
            [
                "passwordtxt"=> $psw,
                "userid"=> $user,
            ]
            );
            if($result){
                    return "success";
            }else{
                    return "fail";
            }
    }

    public function updateuserpass(Request $request){
        $setpass= DB::table('password')
        ->where('userid', $request->userid)
        ->update(['passwordtxt' => $request->password
        ]);
            if($setpass){
                return response()->json(array(['status'=>"PasswordChange"]), 200);
            }else{
                return response()->json(array(['status'=>"PasswordNotChange"]), 200);
            }
    }
    public function getuserpass(Request $request){
        $userpass=DB::table('password')->where("passwordtxt",$request->password)
        ->where("userid",$request->userid)
        ->get();
        if(count($userpass)>0){
            return response()->json(array(['status'=>"Have"]), 200);
        }else{
            return response()->json(array(['status'=>"NotHave"]), 200);
        }
    }
}
