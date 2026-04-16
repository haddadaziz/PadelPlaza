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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: Raquette Wilson
            $table->string('type'); // ex: raquette, balle, accessoire
            $table->integer('price_coins'); // Tarif en Plaza Coins
            $table->integer('stock')->default(0); // Quantité en stock
            $table->string('image')->nullable(); // Photo
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
