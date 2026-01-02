<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Align status enums and add supporting columns for approval workflow.
        DB::statement("ALTER TABLE bookings MODIFY admin_status ENUM('review','detail_sent','final_approved','on_progress','finished','rejected') NOT NULL DEFAULT 'review'");
        DB::statement("ALTER TABLE bookings MODIFY customer_status ENUM('submitted','detail_approved','final_signed','rejected') NOT NULL DEFAULT 'submitted'");

        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'approval_file')) {
                $table->string('approval_file')->nullable()->after('proposal_file');
            }

            if (!Schema::hasColumn('bookings', 'signature_file')) {
                $table->string('signature_file')->nullable()->after('approval_file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'signature_file')) {
                $table->dropColumn('signature_file');
            }
            if (Schema::hasColumn('bookings', 'approval_file')) {
                $table->dropColumn('approval_file');
            }
        });

        // Revert to a permissive VARCHAR to avoid locking to this enum set on rollback.
        DB::statement("ALTER TABLE bookings MODIFY admin_status VARCHAR(50) NOT NULL DEFAULT 'review'");
        DB::statement("ALTER TABLE bookings MODIFY customer_status VARCHAR(50) NOT NULL DEFAULT 'submitted'");
    }
};
