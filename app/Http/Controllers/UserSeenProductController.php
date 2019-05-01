<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSeenProductController extends Controller
{
    public function seencount($prid){
        $seencount=DB::table('productseenuser')->where("productid",$prid)->get();
            return count($seencount);
}
}
