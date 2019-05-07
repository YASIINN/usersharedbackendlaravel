<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
class RegisterController extends Controller
{
    public function emailcontrol($email,$table,$field){
        $emaillist = DB::table($table)
        ->where($field,$email)
        ->get();
        if(count($emaillist)>0){
            return "Have";
        }else{
            return "NotHave";
        }
    }
    public function delregister(Request $request){
        $deleteduser=DB::table('register')->where("activationcode","=",$request->code)->get();
        $delete= DB::table('register')->where('activationcode', '=', $request->code)->delete();
        if($delete){
                return response()->json($deleteduser, 200);
        }
    }
    public function getregister($code){
        $registeruser=DB::table('register')->where("activationcode","=",$code)->get();
        if(count($registeruser)>0){
            return response()->json($registeruser, 200);
        }else{
            return response()->json(array(["status"=>"NotDefine"]),200);
        }
    }
    public function addregister(Request $request){
                  if($this->emailcontrol($request->remail,"contact","email")=="Have"){
                    return response()->json(array(['status'=>"Using"]), 200);
                  }else{
                        if($this->emailcontrol($request->remail,"register","rusername")=="Have")
                        {
                            return response()->json(array(['status'=>"Using"]), 200);
                        }else{
                    $activatecode=$request->code."-".date("d_m_Y");
                    $mail=$request->remail;
                    $result= DB::table('register')->insertGetId(
                         [
                            "cityid"=> $request->rcity,
                            "rname"=> $request->rufirstname,
                            "rlname"=> $request->rlastname,
                            "rusername"=> $mail,
                            "roleid"=> 2,
                            "password"=>$request->rpass,
                            "gender"=> $request->rgender,
                            "isstudent"=> $request->risstudent,
                            "activationcode"=> $activatecode,
                            "runiversity"=> $request->rschool,
                            "rphone"=> $request->rphone
                        ]
                     );
                     if($result){
                        $mailresult= app('App\Http\Controllers\MailController')->index("Kayıt Aktivasyonu",$activatecode,$mail);
                        if($mailresult=="success"){
                            $record=DB::table('register')->get()->where("registerid",$result);
                             return response()->json($record, 200);
                        }else{
                            return response()->json(array(['status'=>"MailErr"]), 200);
                         }
                     }else{
                        return response()->json(array(['status'=>"InsertErr"]), 200);
                     }

                  }
            }
    }
}
