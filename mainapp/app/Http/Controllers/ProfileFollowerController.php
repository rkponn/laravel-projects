<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Services\ProfileViewService;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class ProfileFollowerController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    // Return raw html data for profile followers, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): JsonResponse
    {
        // return only profile followers json data
        return response()->json(
            [
                'html' => view('profile-followers-only', ['followers' => $user->followers()->latest()->get()])->render(),
                'docTitle' => $user->username."'s Followers",
            ]);
    }

    public function show(User $user): ViewView
    {
        $sharedData = $this->profileViewService->getSharedData($user);
        $followers = $this->profileViewService->getProfileFollowers($user);
        View::share('sharedData', $sharedData); // Sharing data with the view

        return view('profile-followers', ['followers' => $followers]);
    }
}
