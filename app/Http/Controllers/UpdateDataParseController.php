<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateDataParseController extends Controller
{
        public function updateparse($data){

            $keys=array_keys($data);
            $updatearr;
            foreach ($keys as $item) {
                $updatearr[$item] =   $data[$item];
            }
                return $updatearr;
        }
}
