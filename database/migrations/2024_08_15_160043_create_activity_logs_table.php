<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('time_spent'); // Time in seconds
            $table->timestamp('visited_at');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
