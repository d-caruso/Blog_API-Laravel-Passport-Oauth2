<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Retrieve all tags
    public function index()
    {
        return Tag::all();
    }

    // Create a new tag
    public function store(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create($validatedData);
        return $tag;
    }

    // Show a specific tag
    public function show(Tag $tag)
    {
        return $tag;
    }

    // Update a specific tag
    public function update(Request $request, Tag $tag)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $tag->update($validatedData);
        return $tag;
    }

    // Delete a specific tag
    public function destroy(Request $request, Tag $tag)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tag->delete();
        return response()->noContent();
    }
}