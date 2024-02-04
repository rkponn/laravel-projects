<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(User $user) {
        // instance of user model.
        return view(
            'profile-post', 
            [
            'username' => $user->username, 
            'posts' => $user->posts()->get(),
            'postCount' => $user->posts()->count()
            ]
        );
    }
}
