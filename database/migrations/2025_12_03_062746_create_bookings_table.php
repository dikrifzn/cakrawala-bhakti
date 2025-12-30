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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            $table->string('proposal_file');
            $table->text('proposal_description')->nullable();

            $table->string('event_name');
            $table->date('start_date');
            $table->date('end_date');

            $table->string('location');

            $table->text('notes')->nullable();

            $table->enum('admin_status', ['review','approved','rejected','pricing_sent','on_process','finished','details_sent','gantt_uploaded'])->default('review')->notnull();
            $table->enum('customer_status', ['submitted', 'review', 'approved', 'rejected', 'details_approved', 'final_approved'])->default('review')->notnull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
