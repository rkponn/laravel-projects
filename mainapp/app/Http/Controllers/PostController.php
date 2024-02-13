<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\View\View;
use App\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\TagController;
use Illuminate\Database\Eloquent\Collection;

class PostController extends Controller
{
    // Search for posts
    public function index($term): Collection
    {
        // Performs a search for posts based on term and returns a collection of posts with user information
        $postIds = Post::search($term)->keys();

        return Post::whereIn('id', $postIds)
            ->with('user:id,username,avatar')
            ->get();
    }

    // Create post
    public function create(): View
    {
        $tags = Tag::all();
        return view('create-post', compact('tags'));
    }

    // Store Post
    public function store(PostRequest $request): RedirectResponse
    {
        // sanitize html
        $newPost = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);
        // Sync tags
        $tags = explode(',', $request->tags);
        $newPost->syncTags($tags);
        return redirect("/post/{$newPost->id}")->with('success', 'Blog post successfully created!!');
    }

    // Show Post
    public function show(Post $post): View
    {
        $tags = Tag::all();
        // Pass 'isEditMode' => false to the view because this is not the edit mode
        return view('single-post', ['post' => $post, 'bodyMarkdown' => $post->body_markdown, 'tags' => $tags, 'isEditMode' => false]);
    }

    // Edit Post
    public function edit(Post $post): View
    {
        $tags = Tag::all();
        // Pass 'isEditMode' => true to the view because this is the edit mode
        return view('edit-post', compact('post', 'tags') + ['isEditMode' => true]);
    }

    // Update Post
    public function update(Post $post, PostRequest $request): RedirectResponse
    {
        // update post with the incoming fields
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Sync tags
        $tags = explode(',', $request->tags);
        $post->syncTags($tags);
        // send the user back with a success message
        return back()->with('success', 'Post successfully updated.');
    }

    // Delete Post
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        // send user back to their profile upon deletion
        return redirect('/profile/'.auth()->user()->username)->with('success', 'Suceessfully deleted.');
    }
}
