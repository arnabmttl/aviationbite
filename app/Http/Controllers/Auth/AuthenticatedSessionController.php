<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;

// Services
use App\Services\AuthService;

// Events
use App\Events\UserAuthenticated;
use App\Events\UserLoggedOut;

// Support Facades
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        /**
         * Call UserAuthenticated Event.
         */
        event(new UserAuthenticated((new AuthService)->getCurrentlyLoggedInUser()));

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = (new AuthService)->getCurrentlyLoggedInUser();

        Auth::guard('web')->logout();

        /**
         * Call UserLoggedOut Event.
         */
        event(new UserLoggedOut($user));

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($user->name == 'Administrator') {
            return redirect('/beta/superadmin/login');
        } else {
            return redirect('/beta');
        }
    }
}
