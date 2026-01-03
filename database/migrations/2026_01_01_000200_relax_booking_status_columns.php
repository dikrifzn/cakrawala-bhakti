<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use VARCHAR to avoid enum truncation issues across environments.
        DB::statement("ALTER TABLE bookings MODIFY admin_status VARCHAR(50) NOT NULL DEFAULT 'review'");
        DB::statement("ALTER TABLE bookings MODIFY customer_status VARCHAR(50) NOT NULL DEFAULT 'submitted'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY admin_status ENUM('review','detail_sent','final_approved','on_progress','finished','rejected') NOT NULL DEFAULT 'review'");
        DB::statement("ALTER TABLE bookings MODIFY customer_status ENUM('submitted','detail_approved','final_signed','rejected') NOT NULL DEFAULT 'submitted'");
    }
};
