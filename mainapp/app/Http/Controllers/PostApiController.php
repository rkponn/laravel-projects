<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    // Store post
    public function store(Request $request): int
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

        return $newPost->id;
    }

    // Delete post
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        // send user back to their profile upon deletion
        return response()->json([
            'message' => 'Post successfully deleted.',
        ]);
    }
}
