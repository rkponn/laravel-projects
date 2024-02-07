<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    // Home Page Method
    public function index(): \Illuminate\View\View {
        // globally available auth - if logged in or not
        if(auth()->check()) {
            return view('homepage-feed', [
                'posts' => auth()->user()->feedPost()->latest()->paginate(10),
                'username' => auth()->user()->username,
            ]);
        } else {
            // cached data - prevent multiple calls
            $postCount = Cache::remember('postCount', 20, function() {
                return Post::count();
            });
            return view('homepage', ['postCount' => $postCount]);
        }
    }
}
