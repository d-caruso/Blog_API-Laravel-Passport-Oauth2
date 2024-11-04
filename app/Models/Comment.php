<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory; // Include the HasFactory trait
    
    protected $fillable = ['content', 'status'];

    // Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to a post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
