<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

class UserController extends Controller
{
    public function addnewuser(Request $request){
        $result= DB::table('user')->insertGetId(
            [
               "username"=> $request->username,
               "usname"=> $request->usname,
               "uslname"=> $request->uslname,
               "roleid"=> $request->roleid,
               "avatarid"=>$request->avatarid,
               "token"=> $request->token,
               "gender"=> $request->gender,
               "city"=> $request->city,
               "isstudent"=> $request->isstudent,
               "universityid"=> $request->universityid,
               "createddate"=> $request->createddate
           ]
        );
        if($result){
            $contactresult= app('App\Http\Controllers\ContactController')->createusercontact($request->username,$result,$request->phone);
            if($contactresult=="success"){
                $pswresult= app('App\Http\Controllers\PasswordController')->createuserpass($request->password,$result);
                if($pswresult=="success"){
                    $record=DB::table('user')->get()->where("userid",$result);
                    return response()->json($record, 200);
                }else{
                    return response()->json(array(['status'=>"NotPswInsert"]), 200);
                }

            }else{
                return response()->json(array(['status'=>"NotContactInsert"]), 200);
            }

        }else{
            return response()->json(array(['status'=>"NotInsert"]), 200);
        }
    }
    public function getuser(Request $request){
        $result = DB::table('user')
        ->join('city', 'user.city', '=', 'city.cityid')
        ->join('userrole', 'user.roleid', '=', 'userrole.roleid')
        ->join('university', 'user.universityid', '=', 'university.universityid')
        ->join('gender', 'user.gender', '=', 'gender.genderid')
        ->join('useravatar', 'user.avatarid', '=', 'useravatar.avatarid')
        ->select('user.*','city.*','userrole.*','university.*','gender.*','useravatar.*')
        ->where("user.userid",$request->userid)
        ->get();
        if(count($result)>0){
        for($i=0;$i<count($result);$i++){
            $user[] = array( 
            "userfirstname" => $result[$i]->username,
            "userlastname" => $result[$i]->uslname,
            "username" => $result[$i]->usname,
            "userid" => $result[$i]->userid,
            "roleid" => $result[$i]->roleid,
            "role" => $result[$i]->rolename,
            "token" => $result[$i]->token,
            "genderid" => $result[$i]->genderid,
            "gender"=>$result[$i]->gender,
            "cityid" => $result[$i]->city,
            "city" => $result[$i]->cityname,
            "isstudent" => $result[$i]->isstudent,
            "universityid" => $result[$i]->universityid,
            "university" => $result[$i]->universityname,
            "createddate" => $result[$i]->createddate,
            "avatarid" => $result[$i]->avatarid,
            "avatar" =>"data:image/jpeg:image/png;base64,".base64_encode($result[$i]->avatar),
            "username" => $result[$i]->usname,
        );
        }
        return response()->json($user, 200);
    }else{
        return response()->json(array(['status'=>"Not"]), 200);
    }

    }
}
