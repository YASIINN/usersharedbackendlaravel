<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ContactController extends Controller
{
    public function createusercontact($email,$user,$phone){
            $result=DB::table("contact")->insert(
                [
                    "email"=> $email,
                    "phone"=> $phone,
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
