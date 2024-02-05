<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    // only access within this class.
    private function getSharedData($user) {
        // set default to false.
        $currentlyFollowing = false;

        if(auth()->check()) {
            $currentlyFollowing = Follow::where('user_id', '=', auth()->user()->id)
            ->where('followeduser', '=', $user->id)
            ->count();
        }
        // Shared variables.
        View::share('sharedData', [
            'currentlyFollowing' => $currentlyFollowing,
            'avatar' => $user->avatar,
            'username' => $user->username, 
            'postCount' => $user->posts()->count(),
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count()
        ]);
    }

    public function profile(User $user) {
        $this->getSharedData($user);
        return view('profile-post', ['posts' => $user->posts()->latest()->get()]);
    }

    public function profileFollowers(User $user) {
        $this->getSharedData($user);
        return view('profile-followers', ['followers' => $user->followers()->latest()->get()]);
    }

    public function profileFollowing(User $user) {
        $this->getSharedData($user);
        return view('profile-following', ['following' => $user->following()->latest()->get()]);
    }

    public function profileJson(User $user) {
        // return only profile post json data
        return response()->json(
            [
                'html' => view('profile-posts-only', ['posts' => $user->posts()->latest()->get()])->render(), 
                'docTitle' => $user->username . "'s Profile"
            ]);
    }

    public function profileFollowersJson(User $user) {
        // return only profile followers json data
        return response()->json(
            [
                'html' => view('profile-followers-only', ['followers' => $user->followers()->latest()->get()])->render(), 
                'docTitle' => $user->username . "'s Followers"
            ]);
    }

    public function profileFollowingJson(User $user) {
        // return only profile following json data
        return response()->json(
            [
                'html' => view('profile-following-only', ['following' => $user->following()->latest()->get()])->render(), 
                'docTitle' => $user->username . "is Following"
            ]);
    }
}