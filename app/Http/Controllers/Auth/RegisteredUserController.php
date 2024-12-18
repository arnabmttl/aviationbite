<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

// Events
use Illuminate\Auth\Events\Registered;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

// Services
use App\Services\UserService;
use App\Services\AuthService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request)
    {
        $input = $request->validated();
        $input['type'] = 'student';

        $user = (new UserService)->createUser($input);

        if($user) {
            (new AuthService)->loginUserByObject($user);

            event(new Registered($user));

            return redirect(RouteServiceProvider::HOME);
        } else {
            abort(500);   
        }
    }
}
