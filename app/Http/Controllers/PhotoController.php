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
public function update(Request $request){
       DB::beginTransaction();
         $result=DB::table("photo") ->where('id', $request->oldheader)
         ->update(['seqnumber' => 1]);
         if($result){
          $newresult=DB::table("photo") ->where('id', $request->newheader)
          ->update(['seqnumber' => 0]);
          if($newresult){
            DB::commit();
            return response()->json(array(['status'=>"Success"]), 200);
          }else{
            return response()->json(array(['status'=>"Error"]), 200);
            DB::rollback();
          }
         }else{
          return response()->json(array(['status'=>"Error"]), 200);
          DB::rollback();
         }
}
}
