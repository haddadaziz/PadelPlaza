<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('result')->nullable()->after('status'); // 'win', 'loss', ou null
        });
    }
    public function down(): void {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('result');
        });
    }
};
