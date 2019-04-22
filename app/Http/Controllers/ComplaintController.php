<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ComplaintController extends Controller
{
    public function getcomplaint(){
        $results = DB::table("complaint")->get();
        return response()->json($results, 200);
    }
}
