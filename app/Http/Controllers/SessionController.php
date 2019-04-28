<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require 'JWT/jwt.php';
use \Firebase\JWT\JWT;
class SessionController extends Controller
{
        public function read($token,$key,$id) {
     $decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
     if($decoded){
        $result=DB::table('user')
        ->where("userid",$id)
        ->get();
        if($decoded->usid==$result[0]->userid && $decoded->email==$result[0]->usname && $token==$result[0]->token){
               return true;
        }else{
               return false;
        }
     }else{
         return false;
     }

        }
}
