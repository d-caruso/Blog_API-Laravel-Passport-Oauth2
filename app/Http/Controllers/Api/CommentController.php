<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Retrieve all comments for the authenticated user's posts
    public function index()
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return Comment::whereHas('post', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['user', 'post'])->get();
    }

    // Create a new comment
    public function store(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'status' => 'in:unapproved,approved,spam',
        ]);

        $post = Post::findOrFail($validatedData['post_id']);
        
        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment = Comment::create($validatedData + ['user_id' => $user->id]);
        return $comment;
    }

    // Show a specific comment
    public function show(Comment $comment)
    {
        $user = request()->user();
        
        if ($comment->post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $comment->load(['user', 'post']);
    }

    // Update a specific comment
    public function update(Request $request, Comment $comment)
    {
        $user = request()->user();
        
        if ($comment->post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'content' => 'sometimes|string',
            'status' => 'in:unapproved,approved,spam',
        ]);

        $comment->update($validatedData);
        return $comment;
    }

    // Delete a specific comment
    public function destroy(Comment $comment)
    {
        $user = request()->user();
        
        if ($comment->post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->noContent();
    }
}