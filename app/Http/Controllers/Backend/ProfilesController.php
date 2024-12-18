<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\User;
use App\Models\Activity;

// Requests
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $username)
    {
        return view('backend.student.profiles.show', [
            'profileUser' => $username,
            'threads' => $username->threads()->latest()->paginate(30),
            'activities' => Activity::feed($username),
        ]);
    }
}
