<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSeenProductController extends Controller
{
    public function seencount($prid){
        $seencount=DB::table('productseenuser')->where("productid",$prid)->get();
            return count($seencount);
}
  public function add(Request $request){
    $seencount=DB::table('productseenuser')
    ->where("productid",$request->productid)
    ->where("touserid",$request->touserid)
    ->get();
        if(count($seencount)!=0){
            return response()->json(array(['status'=>"Have"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }else{
            DB::beginTransaction();
            $result=DB::table("productseenuser")->insert([
                "touserid"=>$request->touserid,
                "productid"=>$request->productid,
                "fromuserid"=>$request->fromuserid,
            ]);
        }
    if($result){
        DB::commit();
            return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);

    }else{
        DB::rollback();
        return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
  }

}
