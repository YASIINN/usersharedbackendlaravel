<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function addphoto(Request $request){
      $data =$request->imglist;
        $arr=array();
        for ($i=0; $i <count($data) ; $i++) {
            $result=DB::table('photo')->insertGetId(
                [
                     "photo"=>base64_decode($data[$i]['base64']),
                    "date"=>$data[$i]['date'],
                    "seqnumber"=>$data[$i]['seqnumber'],
                    "photosize"=> $data[$i]['size'],
                    "time"=> $data[$i]['time'],
                    "phototype"=>$data[$i]['type']
                  ]);

                  if($result){
                         array_push($arr,['imgid'=>$result]);
                      }else{
                        return response()->json(array(['status'=>"NotInserted"]), 200);
                      }
        }
        return response()->json($arr, 200);
}
}
