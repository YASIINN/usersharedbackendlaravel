<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
require 'JWT/jwt.php';
use \Firebase\JWT\JWT;
class SessionController extends Controller
{
        public function read($token) {

     $decoded = JWT::decode($jwt, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
     return $decoded;
                        //     print_r($decoded);
        }
}
