<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlParseController extends Controller
{
    public function queryparser($parser){
        $arr=array();
        for ($i=0; $i <count($parser) ; $i++) {
                if($parser[$i]['Operation']=="EQ"){
                        $arr []=[
                                $parser[$i]['PropertyName'] , "=",$parser[$i]['PropertyValue']
                        ];
                }
        }
        return $arr;
    }
}
