<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Check if columns do not already exist before adding them
            if (!Schema::hasColumn('posts', 'title')) {
                $table->string('title'); // New field for post title
            }
            if (!Schema::hasColumn('posts', 'images')) {
                $table->text('images')->nullable(); // Field for storing multiple images (as JSON)
            }
            if (!Schema::hasColumn('posts', 'likes')) {
                $table->json('likes')->default(json_encode([])); // Store likes as JSON array
            }
            if (!Schema::hasColumn('posts', 'comments')) {
                $table->json('comments')->nullable(); // Store comments as JSON array
            }
            if (!Schema::hasColumn('posts', 'tags')) {
                $table->string('tags')->nullable(); // Field for tags or categories (as a comma-separated string or JSON array)
            }
            if (!Schema::hasColumn('posts', 'status')) {
                $table->string('status')->default('pending'); // New field for status with a default value of 'pending'
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop columns if rolling back
            $table->dropColumn(['title', 'images', 'likes', 'comments', 'tags', 'status']);
        });
    }
};
