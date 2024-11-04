<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory; // Include the HasFactory trait
    
    protected $fillable = ['title', 'content', 'status'];

    // Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Many-to-Many relationship with categories
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Many-to-Many relationship with tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
