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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('text'); // Field for post text
            $table->string('image')->nullable(); // Field for image URL (nullable in case there is no image)
            $table->unsignedInteger('likes')->default(0); // Field for likes count
            $table->text('comments')->nullable(); // Field for comments (you may want to store JSON or serialized data)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
