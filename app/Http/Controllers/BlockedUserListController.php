<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BlockedUserListController extends Controller
{
    public function getblocklist($id){
        $result=DB::table('blockedusers')->where("id",$id)->get();
        return response()->json($result, 200);
    }
    public function getall(){
        $result=DB::table('blockedusers')->get();
        return response()->json($result, 200);
    }
    public function isblocked($username){
        $result=DB::table('blockedusers')->where("username",$username)->get();
        if(count($result)>0){
            return "Blocked";
        }else{
                return "NotBlocked";
        }
    }
}
