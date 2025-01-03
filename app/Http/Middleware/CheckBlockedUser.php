<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout(); // Log the user out
            \Session::flush();

            $currentRouteName =  \Route::currentRouteName();
            if($currentRouteName == 'dashboard'){
                return redirect()->route('home')->with('toastrInfo', 'Your account has been blocked. Please talk to system admin.');
            } else {
                return redirect()->route($currentRouteName)->with('toastrInfo', 'Your account has been blocked. Please talk to system admin.');
            }
            
        }

        return $next($request);
    }
}
