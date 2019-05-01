<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FavProductController extends Controller
{
        public function getfavproduct(){

        }
        public function favprcount($prid){
                $favcount=DB::table('favproduct')->where("productid",$prid)->get();
                    return count($favcount);
        }
}
