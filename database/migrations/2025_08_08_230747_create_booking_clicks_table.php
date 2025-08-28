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
        Schema::create('booking_clicks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address', 45);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('program')->nullable();
            $table->string('referer')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->unsignedInteger('click_count')->default(0);
            $table->timestamp('last_clicked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_clicks');
    }
};
