<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use Illuminate\Http\Request;

class AdminAuthenticate
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
        $sess = Session::get('auth');
        if($sess){
            return $next($request);
        }else{
            return Redirect::to('/login');
        }
    }
}