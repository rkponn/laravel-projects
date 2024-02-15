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
        // check if authorized
        if (auth()->check()) {
            return view('/homepage/homepage-feed', [
                'posts' => auth()->user()->feedPost()->latest()->paginate(10),
                'username' => auth()->user()->username,
            ]);
        } else {
            // cached data - prevent multiple calls
            $postCount = Cache::remember('postCount', 20, function () {
                return Post::count();
            });

            return view('/homepage/homepage', ['postCount' => $postCount]);
        }
    }
}
