<?php

namespace App\Http\Middleware;

use Closure;
class Login
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
        $blocklist= app('App\Http\Controllers\BlockedUserListController')->isblocked($request->username);
        if($blocklist==="Blocked"){
            return response()->json(array(['status'=>"Blocked"]), 200);
        }else{
            return $next($request);
        }
    }

}
