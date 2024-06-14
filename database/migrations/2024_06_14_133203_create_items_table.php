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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained();
            $table->string('wolt_id');
            $table->string('name');
            $table->unsignedMediumInteger('price');
            $table->unsignedMediumInteger('original_price')->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('image_url', 1500)->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
