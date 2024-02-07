<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    /**
     * Recommend moving these functions returning a view to a service class, to make the data gathering more reusable.
     * See below for an example of how to do this.
     */
    // public function __construct(protected ProfileViewService $profileViewService)
    // {
    // }

    // public function profile(User $user): \Illuminate\View\View
    // {
    //     return $this->profileViewService->profile($user);
    // }

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

    /**
     * Use return types in all your functions.
     * This will help you and other developers understand what the function is returning.
     * We also use PHPStan to check for errors and it will help with that.
     */
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

    /**
     * Not sure why these routes are displaying the html as json, but I recommend looking into API Resources for API/JSON routes
     * @see https://laravel.com/docs/10.x/eloquent-resources
     */
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
