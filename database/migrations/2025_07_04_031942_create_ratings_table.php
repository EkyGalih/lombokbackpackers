<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tour_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('rating')->unsigned(); // 1 - 5
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['tour_id', 'user_id']); // 1 user hanya bisa rate 1x per tour
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
