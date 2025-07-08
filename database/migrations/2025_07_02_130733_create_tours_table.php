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
        Schema::create('tours', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->json('description');
            $table->json('notes')->nullable();
            $table->json('include')->nullable();
            $table->json('exclude')->nullable();
            $table->string('slug')->unique();
            $table->json('duration');
            $table->json('packet');
            $table->json('itinerary')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->enum('status', ['available', 'not available'])->default('available');
            $table->date('discount_start')->nullable();
            $table->date('discount_end')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
