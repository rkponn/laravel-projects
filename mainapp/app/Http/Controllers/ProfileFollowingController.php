<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Services\ProfileViewService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProfileFollowingController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    public function show(User $user): \Illuminate\View\View {
        $sharedData = $this->profileViewService->getSharedData($user);
        $following = $this->profileViewService->getProfileFollowing($user);
        View::share('sharedData', $sharedData); // Sharing data with the view
        return view('profile-following', ['following' => $following]);
    }

    // Return raw html data for profile following, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): \Illuminate\Http\JsonResponse {
        // return only profile following json data
        return response()->json(
            [
                'html' => view('profile-following-only', ['following' => $user->following()->latest()->get()])->render(),
                'docTitle' => $user->username . "is Following"
            ]);
    }
}
