<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index($term): Collection
    {
        // search becomes available through Laravel Scout
        return Post::search($term)
            ->with(['user:id,username,avatar'])
            ->get();
    }

    // Create post
    public function create(): View

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
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

    // Create post
    public function create(): \Illuminate\View\View

    {
        return view('create-post');
    }


    // Store post
    public function store(PostRequest $request): RedirectResponse
    {
        // sanitize html
        $newPost = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect("/post/{$newPost->id}")->with('success', 'Blog post successfully created!!');
    }

    // Show Post
    public function show(Post $post): View
    {
        return view('single-post', ['post' => $post]);
    }

    // Edit Post
    public function edit(Post $post): View

    // Show Post
    public function show(Post $post): \Illuminate\View\View
    {
        // allow markdown - since sanitize is in place
        $post['body'] = Str::markdown($post->body);

        return view('single-post', ['post' => $post]);
    }

    // Delete post
    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->delete();

        // send user back to their profile upon deletion
        return redirect('/profile/'.auth()->user()->username)->with('success', 'Suceessfully deleted.');
    }

    // Edit Post
    public function edit(Post $post): \Illuminate\View\View

    {
        // view the edit-post.blade file send $post to gather id
        return view('edit-post', ['post' => $post]);
    }

    // Update Post

    public function update(Post $post, PostRequest $request): RedirectResponse
    {
        // update post with the incomingfields
        $post->update([
            'title' => $request->title,
            'body' => $request->body,

    public function update(Post $post, Request $request): \Illuminate\Http\RedirectResponse
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',

        ]);


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

    // search
    public function index($term): \Illuminate\Database\Eloquent\Collection
    {
        // search becomes available through Laravel Scout
        $posts = Post::search($term)->get();
        // include some additional objects in the payload
        $posts->load('user:id,username,avatar');

        return $posts;
    }
}
