<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->string('title'); // Title of the post
            $table->text('content'); // Content of the post
            $table->enum('status', ['draft', 'published', 'removed'])->default('draft'); // Post status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
