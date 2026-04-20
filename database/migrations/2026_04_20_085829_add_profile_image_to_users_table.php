<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On stockera le chemin de l'image ("profiles/xxx.jpg")
            $table->string('profile_image')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        //
        });
    }
};
