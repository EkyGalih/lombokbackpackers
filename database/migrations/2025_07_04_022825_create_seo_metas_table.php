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
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('seoable_type');
            $table->uuid('seoable_id');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();
            $table->string('robots')->nullable();
            $table->json('structured_data')->nullable();

            $table->timestamps();

            $table->index(['seoable_type', 'seoable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
