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
        Schema::table('car_wash_schedules', function (Blueprint $table) {
            $table->foreignId('user_id')->after('car_wash_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_wash_schedules', function (Blueprint $table) {
            $table->dropForeign('car_washes_schedules_table_user_id_foreign');
        });
    }
};
