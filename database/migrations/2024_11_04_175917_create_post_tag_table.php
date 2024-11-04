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
        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Foreign key to posts
            $table->foreignId('tag_id')->constrained()->onDelete('cascade'); // Foreign key to tags
            $table->primary(['post_id', 'tag_id']); // Composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
