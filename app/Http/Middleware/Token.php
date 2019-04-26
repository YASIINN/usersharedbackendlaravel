<?php

namespace App\Http\Middleware;

use Closure;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($request->token) && isset($request->email) && isset($request->userid)){
        $token= app('App\Http\Controllers\SessionController')->read($request->token,$request->email,$request->userid);
        if($token===true){
            return $next($request);
        }else{
            return response()->json(array(['status'=>"NotToken"]), 200);
        }
    }
        else{
                return response()->json(array(['status'=>"BadRequest"]), 200);
            }
    }
}
