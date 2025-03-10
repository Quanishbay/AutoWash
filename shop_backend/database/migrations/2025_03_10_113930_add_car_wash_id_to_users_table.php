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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('car_wash_id')->nullable()->after('role')->constrained('car_washes')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'car_wash_id')) {
                $table->dropForeign(['car_wash_id']); // Удаляем внешний ключ
                $table->dropColumn('car_wash_id');    // Удаляем колонку
            }
        });
    }
};
