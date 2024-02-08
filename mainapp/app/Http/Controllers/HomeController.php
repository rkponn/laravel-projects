<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Home Page Method
    public function index(): View
    {
        // globally available auth - if logged in or not
        if (auth()->check()) {
            return view('homepage-feed', [
                'posts' => auth()->user()->feedPost()->latest()->paginate(10),
                'username' => auth()->user()->username,
            ]);
        } else {
            // cached data - prevent multiple calls
            $postCount = Cache::remember('postCount', 20, function () {
                return Post::count();
            });

            return view('homepage', ['postCount' => $postCount]);
        }
    }
}
