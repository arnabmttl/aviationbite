<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Support Facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            if ($roles && $request->user()->username && $request->user()->hasRole($roles)) {
                return $next($request);
            }

            Session::flash('failure', 'You are not allowed to view this page.');
            return redirect(route('dashboard'));
        }
        
        Session::flash('failure', 'You are not allowed to view this page.');
        return redirect(route('dashboard'));
    }
}
