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
        Schema::create('category_post', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Foreign key to posts
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key to categories
            $table->primary(['post_id', 'category_id']); // Composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
