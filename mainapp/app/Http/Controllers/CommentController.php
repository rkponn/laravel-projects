<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
        // Validate the request
        $request->validate([
            'body' => 'required|max:255'
        ]);

        // Create the comment
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'body' => $request->body
        ]);

        // Redirect back to the post
        return back()->with('success', 'Comment successfully created!!');
    }
}
