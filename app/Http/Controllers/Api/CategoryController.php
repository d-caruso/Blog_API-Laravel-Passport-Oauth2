<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Retrieve all categories
    public function index()
    {
        return Category::all();
    }

    // Create a new category
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validatedData);
        return $category;
    }

    // Show a specific category
    public function show(Category $category)
    {
        return $category; // Return the category
    }

    // Update a specific category
    public function update(Request $request, Category $category)
    {
        $user = $request->user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $category->update($validatedData);
        return $category;
    }

    // Delete a specific category
    public function destroy(Request $request, Category $category)
    {
        $user = $request->user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $category->delete();
        return response()->noContent();
    }
}