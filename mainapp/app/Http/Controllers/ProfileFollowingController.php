<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ProfileViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class ProfileFollowingController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    // Return raw html data for profile following, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): JsonResponse
    {
        // return only profile following json data
        return response()->json(
            [
                'html' => view('/profile/profile-following-only', ['following' => $user->following()->latest()->get()])->render(),
                'docTitle' => $user->username.'is Following',
            ]);
    }

    public function show(User $user): ViewView
    {
        $sharedData = $this->profileViewService->getSharedData($user);
        $following = $this->profileViewService->getProfileFollowing($user);
        View::share('sharedData', $sharedData); // Sharing data with the view

        return view('/profile/profile-following', ['following' => $following]);
    }
}
