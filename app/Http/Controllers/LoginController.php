<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
require 'JWT/jwt.php';
use \Firebase\JWT\JWT;

class LoginController extends Controller
{
    public function signin(Request $request){
       $location= $request->locationname;
       $coord=$request->coord;
        $clientIP = \Request::getClientIp(true);
        $result= DB::table('user')->where("usname",$request->username)->get();
        if(count($result)>0){
              $pswmatch=DB::table('password')->where('passwordtxt',$request->password)->get();
                if(count($pswmatch)>0){
                    $result = DB::table('user')
                    ->join('city', 'user.city', '=', 'city.cityid')
                    ->join('userrole', 'user.roleid', '=', 'userrole.roleid')
                    ->join('university', 'user.universityid', '=', 'university.universityid')
                    ->join('gender', 'user.gender', '=', 'gender.genderid')
                    ->join('useravatar', 'user.avatarid', '=', 'useravatar.avatarid')
                    ->select('user.*','city.*','userrole.*','university.*','gender.*','useravatar.*')
                    ->where("user.userid",$pswmatch[0]->userid)
                    ->get();
                    $logintime= app('App\Http\Controllers\UserTimeController')->addusertime($result[0]->userid,date("d_m_Y"),"",$clientIP);
                    $location= app('App\Http\Controllers\UserLocationController')->adduserlocation($result[0]->userid,$location,$coord,$clientIP);





                    if(count($result)>0){
                        $token_payload = [
                             'usid'=>$result[0]->userid,
                            'email' => $result[0]->usname,
                             'username'=>$result[0]->username,
                             "userlastname"=>$result[0]->uslname
                          ];
                          $key = $result[0]->usname;
                          $jwt = JWT::encode($token_payload, base64_decode(strtr($key, '-_', '+/')), 'HS256');
                        for($i=0;$i<count($result);$i++){
                            $user[] = array(
                            "userfirstname" => $result[$i]->username,
                            "userlastname" => $result[$i]->uslname,
                            "username" => $result[$i]->usname,
                            "userid" => $result[$i]->userid,
                            "roleid" => $result[$i]->roleid,
                            "role" => $result[$i]->rolename,
                            "token" => $jwt,
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
                            "IP"=>$clientIP,
                            "logintime"=>$logintime->original,
                            "location"=>$location->original
                        );
                        }


                  return response()->json($user, 200);

                    }else{
                        return response()->json(array(['status'=>"NotDefine"]), 200);
                    }
                }else{
                    return response()->json(array(['status'=>"NotDefine"]), 200);
                }
        }else{
            return response()->json(array(['status'=>"NotDefine"]), 200);
        }

    }
}
