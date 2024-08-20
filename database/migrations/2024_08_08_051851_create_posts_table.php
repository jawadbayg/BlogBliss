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
            // Add new columns
            $table->string('title'); // New field for post title
            $table->text('text'); // Field for the post content
            $table->string('images')->nullable();// Field for storing multiple images (as JSON)
            $table->json('likes')->default(json_encode([])); // Store likes as JSON array
            $table->json('comments')->nullable(); // Store comments as JSON array
            $table->string('tags')->nullable(); // Field for tags or categories (as a comma-separated string or JSON array)
            $table->string('status')->default('pending'); // New field for status with a default value of 'pending'
            $table->timestamps();

            // Ensure 'user_id' foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropColumn('title');
            $table->dropColumn('text');
            $table->dropColumn('images');
            $table->dropColumn('likes');
            $table->dropColumn('comments');
            $table->dropColumn('tags');
            $table->dropColumn('status');
        });
    }
};
