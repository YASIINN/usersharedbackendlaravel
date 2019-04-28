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
}
