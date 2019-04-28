<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    public function add(Request $request){
        $data =$request->data;
        for ($i=0; $i <count($data) ; $i++) {
            $result=DB::table('productphotos')->insertGetId(
                [
                    "productid"=>$data[$i]['productid'],
                    "photoid"=>$data[$i]['photoid'],
                  ]);

                  if($result){
                    return response()->json(array(['status'=>"Inserted"]), 200);
                      }else{
                        return response()->json(array(['status'=>"NotInserted"]), 200);
                      }
        }

    }
}
