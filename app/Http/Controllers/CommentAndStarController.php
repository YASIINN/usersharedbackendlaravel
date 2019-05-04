<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentAndStarController extends Controller
{
    public function add(Request $request){
        $comment=DB::table('comment')->insert(
            [
                "touser"=>$request->touser,
                "fromuser"=>$request->fromuser,
                "comment"=>$request->comment,
                "commentdate"=>$request->commentdate,
                "commenttime"=>$request->commenttime,
                "star"=>$request->star,

            ]
    );
    if($comment){
            return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
            return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
}
