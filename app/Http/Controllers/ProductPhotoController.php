<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    public function add(Request $request){
        $datalist =$request->data;
        $arr=array();
        for ($i=0; $i <count($datalist) ; $i++) {
            $result=DB::table('productphotos')->insertGetId(
                [
                    "productid"=>$datalist[$i]['productid'],
                    "photoid"=>$datalist[$i]['photoid'],
                  ]);
                  if($result){
                    array_push($arr,['status'=>"Inserted"],['Content-type'=> 'application/json; charset=utf-8']);
                      }else{
                        return response()->json(array(['status'=>"NotInserted"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                      }
        }
        return response()->json($arr, 200);
    }
    public function getproductphoto(Request $request){
        $queryparse=$request->urlparse;
        $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
        $result=DB::table('productphotos')
        ->join('photo', 'productphotos.photoid', '=', 'photo.id')
        ->select('productphotos.*','photo.*')
         ->where($parser)
         ->get();
         if(count($result)>0){

         for($i=0;$i<count($result);$i++){
            $photos[] = array(
                    "productid"=>$result[$i]->productid,
                    "photoid"=>$result[$i]->photoid,
                    "img" =>"data:image/jpeg:image/png;base64,".base64_encode($result[$i]->photo),
                    "isloading"=>"block",
            );
        }
        return response()->json($photos, 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
else{
    return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
}
    }
    public function delproductphotos(Request $request){
            if(isset($request->in)){
                        $inarr=array();
                        for ($i=0; $i <count($request->in) ; $i++) {
                                array_push($inarr,$request->in[$i]);
                        }
               $result= DB::table('productphotos')->whereIn('photoid', $inarr)
                ->delete();
                if($result){
                        return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }else{
                    return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }
            }else{
                $queryparse=$request->urlparse;
                $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
                $result= DB::table('productphotos')->where($parser)->delete();
                if($result){
                    return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }else{
                return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
            }

    }
}
