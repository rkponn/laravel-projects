<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ProfileViewService;
use Illuminate\Support\Facades\View;

class ProfileFollowerController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    public function show(User $user): \Illuminate\View\View
    {
        $sharedData = $this->profileViewService->getSharedData($user);
        $followers = $this->profileViewService->getProfileFollowers($user);
        View::share('sharedData', $sharedData); // Sharing data with the view

        return view('profile-followers', ['followers' => $followers]);
    }

    // Return raw html data for profile followers, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): \Illuminate\Http\JsonResponse
    {
        // return only profile followers json data
        return response()->json(
            [
                'html' => view('profile-followers-only', ['followers' => $user->followers()->latest()->get()])->render(),
                'docTitle' => $user->username."'s Followers",
            ]);
    }
}
