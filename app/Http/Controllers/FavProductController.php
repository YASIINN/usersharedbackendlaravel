<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FavProductController extends Controller
{
        public function getfavproduct(){

        }
        public function addfavproduct(Request $request){
            DB::beginTransaction();
            $have=DB::table('favproduct')
            ->where("productid",$request->productid)
            ->where("tid",$request->touserid)
            ->get();
            if(count($have)<1){
                $result=DB::table('favproduct')->insertGetId(
                    [
                        "tid"=>$request->touserid,
                        "productid"=>$request->productid,
                        "fid"=>$request->fromuserid
                    ]
            );
            if($result){
                DB::commit();
                    return response()->json(array(['status'=>"Success",'id'=>$result]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }else{
                DB::rollback();
                    return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
            }else{
                return response()->json(array(['status'=>"Have"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
           
        }

        public function delfavproduct(Request $request){

        }

        public function favprcount($prid){
                $favcount=DB::table('favproduct')->where("productid",$prid)->get();
                    return count($favcount);
        }
}
