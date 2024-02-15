<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'body' => 'required|max:255',
        ]);

        // Get the post
        $post = \App\Models\Post::findOrFail($postId);

        // Create the comment
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        // Redirect back to the post
        return back()->with('success', 'Comment successfully created!!');
    }

    // edit a comment if the user is the owner
    public function update(Comment $comment): JsonResponse
    {
        // Check if the user is the owner of the comment
        if (auth()->id() !== $comment->user_id) {
            return response()->json(['error' => 'You are not the owner of this comment'], 403);
        }

        // Validate the request
        request()->validate([
            'body' => 'required|max:255',
        ]);

        $comment->update([
            'body' => request('body'),
        ]);

        return response()->json(['success' => 'Comment successfully updated!!'], 200);
    }

    // Delete a comment if the user is the owner
    public function destroy(Comment $comment): JsonResponse
    {
        // Check if the user is the owner of the comment
        if (auth()->id() !== $comment->user_id) {
            return response()->json(['error' => 'You are not the owner of this comment'], 403);
        }

        $comment->delete();

        return response()->json(['success' => 'Comment successfully deleted!!'], 200);
    }
}
