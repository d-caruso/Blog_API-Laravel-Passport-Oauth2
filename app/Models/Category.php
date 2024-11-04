<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory; // Include the HasFactory trait
    
    protected $fillable = ['name'];

    // Many-to-Many relationship with posts
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
