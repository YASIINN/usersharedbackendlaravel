<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
class UsersAvatarController extends Controller
{


    public function addnewavatar(Request $request){
            $user=$request->userid;
           $avatar=DB::table('avatar')->insertGetId([
            'avatar'=>base64_decode($request->base64),
            'type'=>$request->type,
            'size'=>$request->size,
            'date'=>$request->date,
            'time'=>$request->time
           ]);
           if($avatar){
                $usersavatar=DB::table('user')
                ->where('userid', $user)
                ->update(['avatarid' => $avatar]);
                if($usersavatar){
                    return response()->json(array(['status'=>"Updated"]), 200);
                }else{
                    return response()->json(array(['status'=>"UpdateError"]), 200);
                }
           }else{
            return response()->json(array(['status'=>"InsertError"]), 200);
           }
    }
}
