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
            // Data Diri Pemesan
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            // Jenis Kebutuhan Acara
            $table->foreignId('event_type_id')->constrained('event_types')->cascadeOnDelete();

            // Waktu Acara
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->integer('total_days')->default(1);

            // Lokasi Acara
            $table->string('location')->nullable();

            // Catatan
            $table->text('notes')->nullable();

            // Total Harga
            $table->bigInteger('total_price')->default(0);

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'finished'])->default('pending');
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
