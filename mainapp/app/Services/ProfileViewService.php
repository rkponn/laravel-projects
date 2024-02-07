<?php

namespace App\Services;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\View;

class ProfileViewService
{
    public function getSharedData(User $user): array {
        // set default to false
        $currentlyFollowing = false;

        if(auth()->check()) {
            $currentlyFollowing = Follow::where('user_id', auth()->user()->id)
                ->where('followeduser', $user->id)
                ->exists(); // Using exists() is more efficient than count() when you only want to know if any rows match
        }

        // Shared variables
        return [
            'currentlyFollowing' => $currentlyFollowing,
            'avatar' => $user->avatar,
            'username' => $user->username,
            'postCount' => $user->posts()->count(),
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ];
    }

    public function getProfileFollowers(User $user): \Illuminate\Support\Collection {
        return $user->followers()->latest()->get();
    }

    public function getProfileFollowing(User $user): \Illuminate\Support\Collection {
        return $user->following()->latest()->get();
    }
}