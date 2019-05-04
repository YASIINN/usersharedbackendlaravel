<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require 'JWT/jwt.php';
use \Firebase\JWT\JWT;
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
               "token"=> "",
               "gender"=> $request->gender,
               "city"=> $request->city,
               "isstudent"=> $request->isstudent,
               "universityid"=> $request->universityid,
               "createddate"=> $request->createddate
           ]
        );
        $token_payload = [
            'usid'=>$result,
           'email' => $request->usname,
            'username'=>$request->username,
            "userlastname"=>$request->uslname
         ];
         $key = $request->usname;
         $jwt = JWT::encode($token_payload, base64_decode(strtr($key, '-_', '+/')), 'HS256');
        if($result){
            $contactresult= app('App\Http\Controllers\ContactController')->createusercontact($request->username,$result,$request->phone);
            if($contactresult=="success"){
                $pswresult= app('App\Http\Controllers\PasswordController')->createuserpass($request->password,$result);
                if($pswresult=="success"){
                    $settoken= DB::table('user')
                    ->where('userid', $result)
                    ->update(['token' => $jwt
                    ]);
                        if($settoken){
                               $defaultavatar= DB::table("usersavatar")->insert([
                                        'avatarid'=>1,
                                        'userid'=>$result
                                ]);
                            if($defaultavatar){
                                $record=DB::table('user')->get()->where("userid",$result);
                                return response()->json($record, 200,['Content-type'=> 'application/json; charset=utf-8']);
                            }else{
                                return response()->json(array(['status'=>"AvatarError"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                            }

                        }else{
                            return response()->json(array(['status'=>"TokenError"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                        }
                }else{
                    return response()->json(array(['status'=>"NotPswInsert"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }

            }else{
                return response()->json(array(['status'=>"NotContactInsert"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }

        }else{
            return response()->json(array(['status'=>"NotInsert"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }
    }
    public function getuser(Request $request){
        $queryparse=$request->urlparse;
        $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
        $clientIP = \Request::getClientIp(true);
        $result = DB::table('user')
        ->join('city', 'user.city', '=', 'city.cityid')
        ->join('userrole', 'user.roleid', '=', 'userrole.roleid')
        ->join('university', 'user.universityid', '=', 'university.universityid')
        ->join('gender', 'user.gender', '=', 'gender.genderid')
        ->join('contact', 'user.userid', '=', 'contact.userid')
        ->join('avatar', 'user.avatarid', '=', 'avatar.avatarid')
        ->select('user.*','city.*','userrole.*','university.*','gender.*','contact.*' ,'avatar.*')
        ->where($parser)
        ->get();
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
                            "IP"=>$clientIP,
                            "phone"=>$result[$i]->phone
        );
        }
        return response()->json($user, 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
        return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
}
