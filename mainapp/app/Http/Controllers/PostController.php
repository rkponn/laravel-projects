<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function storeNewPost(Request $request) {
        // validate the fields
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

    public function delete(Post $post) {
        $post->delete();
        // send user back to their profile upon deletion
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Suceessfully deleted.');
    }

    public function showEditForm(Post $post) {
        // view the edit-post.blade file send $post to gather id
        return view('edit-post', ['post' => $post]);
    }

    public function updateBlogPost(Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        // sanitize html
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // update post with the incomingfields
        $post->update($incomingFields);
        // send the user back with a success message
        return back()->with('success', 'Post successfully updated.');
    }

    public function search($term) {
        // search becomes available through Laravel Scout
        $posts = Post::search($term)->get();
        // include some additional objects in the payload
        $posts->load('user:id,username,avatar');
        return $posts;
    }

    // API related
    public function deleteApi(Post $post) {
        $post->delete();
        // send user back to their profile upon deletion
        return response()->json([
            'message' => 'Post successfully deleted.'
        ]);
    }

    public function storeNewPostApi(Request $request) {
        // validate the fields
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // sanitize html
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        $newPost = Post::create($incomingFields);
        return $newPost->id;
    }

    
}
