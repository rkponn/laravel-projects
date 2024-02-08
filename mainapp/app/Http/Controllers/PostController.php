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
    public function update(Post $post, PostRequest $request): RedirectResponse
    {
        // update post with the incomingfields
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

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
