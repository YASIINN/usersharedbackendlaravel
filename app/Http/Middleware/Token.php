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
            return response()->json(array(['status'=>"UNAUTHORIZED"]), 401,['Content-type'=> 'application/json; charset=utf-8']);
        }
    }
        else{
                return response()->json(array(['status'=>"BadRequest"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
    }
}
