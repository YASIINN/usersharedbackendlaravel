<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function addnotification(Request $request){

        DB::beginTransaction();

        $result=DB::table("notification")->insert([
            "nttype"=>$request->type,
            "touser"=>$request->touser,
            "fromuser"=>$request->fromuser,
            "productid"=>$request->prid,
            "reading"=>"n"
        ]) ;
        if($result){
                DB::commit();
                return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);

        }else{
            return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                DB::rollback();
        }
    }
    public function setnotification(Request $request){
        DB::beginTransaction();
        $data= $request->updatedata;
        $updated=  app('App\Http\Controllers\UpdateDataParseController')->updateparse($data);
        $queryparse=$request->urlparse;
        $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
        $setntf= DB::table('notification')
        ->where($parser)
        ->update($updated);
        if($setntf){
            DB::commit();
            return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }else{
            DB::rollback();
            return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }
    }


    public function getnotification(Request $request){
        $queryparse=$request->urlparse;
        $parser= app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
            DB::beginTransaction();
            $result=DB::table("notification")
            ->join('product', 'notification.productid', '=', 'product.productid')
            ->join('user', 'notification.touser', '=', 'user.userid')
            ->select('notification.*','product.*','user.*')
            ->where($parser)
            ->get();
            if(count($result)>0){
                    DB::commit();
                    return response()->json(["data"=>$result], 200,['Content-type'=> 'application/json; charset=utf-8']);
            }else{
                DB::rollback();
                return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
    }
}
