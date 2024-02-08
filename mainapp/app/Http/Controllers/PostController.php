<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index($term): Collection
    {
        // search becomes available through Laravel Scout
        $posts = Post::search($term)->get();
        // include some additional objects in the payload
        $posts->load('user:id,username,avatar');

        return $posts;
    }

    // Create post
    public function create(): View
    {
        return view('create-post');
    }

    // Store post
    public function store(Request $request): RedirectResponse
    {
        // validate the fields
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        // sanitize html
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'Blog post successfully created!!');
    }

    // Show Post
    public function show(Post $post): View
    {
        // allow markdown - since sanitize is in place
        $post['body'] = Str::markdown($post->body);

        return view('single-post', ['post' => $post]);
    }

    // Edit Post
    public function edit(Post $post): View
    {
        // view the edit-post.blade file send $post to gather id
        return view('edit-post', ['post' => $post]);
    }

    // Update Post
    public function update(Post $post, Request $request): RedirectResponse
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        // sanitize html
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // update post with the incomingfields
        $post->update($incomingFields);

        // send the user back with a success message
        return back()->with('success', 'Post successfully updated.');
    }

    // Delete post
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        // send user back to their profile upon deletion
        return redirect('/profile/'.auth()->user()->username)->with('success', 'Suceessfully deleted.');
    }
}
