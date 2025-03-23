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
            $table->foreignId('service_id')->constrained('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_wash_schedules', function (Blueprint $table) {
            $table->dropForeign('car_washes_schedule_service_id_foreign');
            $table->dropColumn('service_id');
        });
    }
};
