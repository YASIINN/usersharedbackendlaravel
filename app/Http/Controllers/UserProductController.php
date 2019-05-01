<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserProductController extends Controller
{
    public function add(Request $request){
        $userproduct=DB::table('userproduct')->insert(
            [
                "userid"=>$request->userid,
                "productid"=>$request->productid,
            ]
    );
        if($userproduct){
                return response()->json(array(['status'=>"Inserted"]), 200);
        }else{
                    return response()->json(array(['status'=>"NotInserted"]), 200);
        }
   }
   public function get(Request $request){
    $queryparse=$request->urlparse;
    $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
    $userproduct=DB::table('userproduct')->where($parser)->get();
    if(count($userproduct)>0){
            return response()->json(array(['status'=>true]), 200);
    }else{
                return response()->json(array(['status'=>false]), 200);
    }
   }
}
