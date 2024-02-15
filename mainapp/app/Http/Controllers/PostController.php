<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    // Create post
    public function create(): View
    {
        // Create a new post instance
        $post = new Post;

        // grab all tags
        $tags = Tag::all();

        // grab all categories
        $categories = Category::all();

        return view('/posts/create-post', compact('post', 'tags', 'categories') + ['isEditMode' => true]);
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
        // Sync tags - split the tags string into an array and sync the tags
        $tags = explode(',', $request->tags);
        $newPost->syncTags($tags);

        $newPost->categories()->sync($request->category_id); // Sync the categories

        return redirect("/post/{$newPost->id}")->with('success', 'Blog post successfully created!!');
    }

    // Show Post
    public function show(Post $post): View
    {
        // grab all tags
        $tags = Tag::all();

        // Fetch the post's categories
        $categories = $post->categories;

        return view('/posts/single-post', compact('categories', 'post', 'tags') + ['bodyMarkdown' => $post->body_markdown, 'isEditMode' => false]);
    }

    // Edit Post
    public function edit(Post $post): View
    {
        $tags = Tag::all();
        $categories = Category::all();

        return view('/posts/edit-post', compact('post', 'tags', 'categories') + ['isEditMode' => true]);
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

        $post->categories()->sync($request->category_id); // Sync the categories

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
