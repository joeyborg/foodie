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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('wolt_id');
            $table->string('name', 300);
            $table->string('slug', 300)->unique();
            $table->string('short_description', 1500)->nullable();
            $table->string('address', 300)->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->unsignedTinyInteger('price_range')->nullable();
            $table->json('wolt_rating')->nullable();
            $table->boolean('delivers')->default(false);
            $table->string('image_url', 1500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
