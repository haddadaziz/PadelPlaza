<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */    public function up()    {
        Schema::table('courts', function (Blueprint $table) {
            $table->string('image')->nullable(); // nullable car le terrain n'aura pas forcément d'image au début
        });    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courts', function (Blueprint $table) {
        //
        });
    }
};
