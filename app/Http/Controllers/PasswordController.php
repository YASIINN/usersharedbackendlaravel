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
}
