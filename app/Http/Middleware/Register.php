<?php

namespace App\Http\Middleware;

use Closure;

class Register
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
        $blocklist= app('App\Http\Controllers\BlockedUserListController')->isblocked($request->remail);
        if($blocklist==="Blocked"){
            return response()->json(array(['status'=>"Blocked"]), 200);
        }else{
            return $next($request);
        }
    }
}
