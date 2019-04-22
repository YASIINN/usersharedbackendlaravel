<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
session_start();
class SessionController extends Controller
{
        public function close() {}
        public function read($sessionId) {
            $value = Session::get($sessionId);
            return $value;
        }
        public function write($sessionId, $data) {
            Session::put($sessionId, $data);
        }
        public function destroy($sessionId) {}
        public function gc($lifetime) {}
}
