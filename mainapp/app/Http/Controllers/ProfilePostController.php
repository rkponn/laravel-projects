<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ProfileViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class ProfilePostController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    // Return raw html data for profile posts, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): JsonResponse
    {
        // return only profile post json data
        return response()->json(
            [
                'html' => view('profile-posts-only', ['posts' => $user->posts()->latest()->get()])->render(),
                'docTitle' => $user->username."'s Profile",
            ]);
    }

    public function show(User $user): ViewView
    {
        $sharedData = $this->profileViewService->getSharedData($user);
        View::share('sharedData', $sharedData);

        return view('profile-post', ['posts' => $user->posts()->latest()->get()]);
    }
}
