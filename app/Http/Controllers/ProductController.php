<?php
namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function add(Request $request){
        $newproduct=DB::table('product')->insertGetId(
                [
                    "title"=>$request->title,
                    "descraption"=>$request->descraption,
                    "price"=>$request->price,
                    "oldprice"=>$request->price,
                    "category"=>$request->category,
                    "productstatus"=>$request->status,
                    "cityid"=>$request->city,
                    "date"=>$request->date,
                    "time"=>$request->time,
                    "university"=>$request->university
                ]
        );
        if($newproduct){
                return response()->json(array(['status'=>"InsertedProduct",'id'=>$newproduct]), 200);
        }else{
                return response()->json(array(['status'=>"NotInserted"]), 200);
        }
    }
}
