<?php

namespace App\Http\Controllers;



use App\Models\User;
use App\Models\Follow;
use App\Services\ProfileViewService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProfilePostController extends Controller
{
    protected $profileViewService;

    public function __construct(ProfileViewService $profileViewService)
    {
        $this->profileViewService = $profileViewService;
    }

    public function show(User $user): \Illuminate\View\View {
        $sharedData = $this->profileViewService->getSharedData($user);
        View::share('sharedData', $sharedData);
        return view('profile-post', ['posts' => $user->posts()->latest()->get()]);
    }


    // Return raw html data for profile posts, and the document title. Loads data so that the profile page can be updated without a full page refresh.
    public function index(User $user): \Illuminate\Http\JsonResponse {
        // return only profile post json data
        return response()->json(
            [
                'html' => view('profile-posts-only', ['posts' => $user->posts()->latest()->get()])->render(),
                'docTitle' => $user->username . "'s Profile"
            ]);
    }
}
