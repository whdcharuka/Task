<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Cashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $user=Auth::user();

        //check whether the user is cashier
        if($user->role==3){
            return $next($request);
        }

        //check whether the user is manager
        if($user->role==2){
            return redirect('/manager');
        }

        //check whether the user is cashier
        if($user->role==1){
            return redirect('/owner');
        }
    }
}