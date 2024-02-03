<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // sanitize html
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'Blog post successfully created!!');
    }

    public function showCreateForm() {
        return view('create-post');
    }

    public function viewSinglePost(Post $post) {
        // allow markdown - since sanitize is in place
        $post['body'] = Str::markdown($post->body);
        return view('single-post', ['post' => $post]);
    }

    
}
