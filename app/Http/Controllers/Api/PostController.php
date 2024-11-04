<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Retrieve all posts for the authenticated user
    public function index()
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return Post::where('user_id', $user->id)->with(['categories', 'tags'])->get();
    }

    // Create a new post
    public function store(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'in:draft,published,removed',
        ]);

        $validatedData['user_id'] = $user->id;
        $post = Post::create($validatedData);
        return $post;
    }

    // Show a specific post
    public function show(Post $post)
    {
        $user = request()->user();
        
        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $post->load(['categories', 'tags']);
    }

    // Update a specific post
    public function update(Request $request, Post $post)
    {
        $user = request()->user();
        
        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'status' => 'in:draft,published,removed',
        ]);

        $post->update($validatedData);
        return $post;
    }

    // Delete a specific post
    public function destroy(Post $post)
    {
        $user = request()->user();
        
        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->noContent();
    }
}