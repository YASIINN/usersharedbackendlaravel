<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentAndStarController extends Controller
{
    public function add(Request $request){
        DB::beginTransaction();
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
        DB::commit();
            return response()->json(array(['status'=>"Success"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
        DB::rollback();
            return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
    public function getcomment(Request $request){
        $queryparse=$request->urlparse;
        $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
        $clientIP = \Request::getClientIp(true);
        $comments = DB::table('comment')
        ->join('user', 'comment.fromuser', '=', 'user.userid')
        ->join('avatar', 'user.avatarid', '=', 'avatar.avatarid')
        ->select('comment.*','user.*' ,'avatar.*')
        ->where($parser)
        ->orderBy('comment.id', 'desc')
        ->get();
        if(count($comments)>0){
        for($i=0;$i<count($comments);$i++){
            $commentlist[] = array(
                            "commentid"=>$comments[$i]->id,
                             "userfirstname" => $comments[$i]->username,
                            "userlastname" => $comments[$i]->uslname,
                            "username" => $comments[$i]->usname,
                            "userid" => $comments[$i]->userid,
                            "avatarid" => $comments[$i]->avatarid,
                            "avatar" =>"data:image/jpeg:image/png;base64,".base64_encode($comments[$i]->avatar),
                            "IP"=>$clientIP,
                             "comment"=>  $comments[$i]->comment,
                             "commentdate"=>  $comments[$i]->commentdate,
                             "commenttime"=>  $comments[$i]->commenttime,
                             "star"=>  $comments[$i]->star,
        );
        }
        return response()->json($commentlist, 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
        return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
}
