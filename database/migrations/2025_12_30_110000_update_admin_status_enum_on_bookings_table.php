<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `bookings` MODIFY `admin_status` ENUM('review','approved','rejected','pricing_sent','on_process','finished','details_sent','gantt_uploaded') NOT NULL DEFAULT 'review'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `bookings` MODIFY `admin_status` ENUM('review','approved','rejected','pricing_sent','on_process','finished') NOT NULL DEFAULT 'review'");
    }
};
