<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();

        // Create 5 categories
        $categories = Category::factory(5)->create();

        // Create 5 tags
        $tags = Tag::factory(5)->create();

        // Create 20 posts and associate each with a random user,
        // multiple categories and tags
        Post::factory(20)->create()->each(function ($post) use ($users, $categories, $tags) {
            // Associate random categories
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Associate random tags
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Create random comments for each post
        Post::all()->each(function ($post) use ($users) {
            // Create 3 comments per post
            Comment::factory(3)->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id, // Random user for each comment
            ]);
        });
    }
}
