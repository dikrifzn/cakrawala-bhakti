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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pic_contact')->nullable()->after('customer_phone');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('customer_status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->string('approval_ip', 45)->nullable()->after('approved_at');
            $table->string('gantt_chart')->nullable()->after('approval_file');
            
            // Add indexes for frequently queried columns
            $table->index('admin_status');
            $table->index('customer_status');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['admin_status']);
            $table->dropIndex(['customer_status']);
            $table->dropIndex(['user_id']);
            
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['pic_contact', 'approved_by', 'approved_at', 'approval_ip', 'gantt_chart']);
        });
    }
};
