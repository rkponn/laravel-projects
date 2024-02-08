<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    public function create(User $user): RedirectResponse
    {
        // you cannot follow yourself
        if ($user->id === auth()->user()->id) {
            return back()->with('failure', 'You cannot follow yourself.');
        }
        // Check if the logged-in user is already following the specified user
        // Counts the number of records where user_id equals logged-in user and
        // followed_user equals the user being followed
        $existCheck = Follow::where('user_id', '=', auth()->user()->id)
            ->where('followeduser', '=', $user->id)
            ->count();

        if ($existCheck) {
            return back()->with('failure', 'You are already following '.$user->username);
        }
        $newFollow = new Follow;
        // user.id - user logged in will create the follow
        $newFollow->user_id = auth()->user()->id;
        // person that is being followed - comes from url
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'You are now following '.$user->username);

    }

    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        Follow::where('user_id', '=', auth()->user()->id)
            ->where('followeduser', '=', $user->id)
            ->delete();

        return back()->with('success', 'You have unfollowed '.$user->username);
    }
}
