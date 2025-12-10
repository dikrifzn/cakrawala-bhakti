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
        Schema::table('project_images', function (Blueprint $table) {
            // Delete all existing data first
            \DB::table('project_images')->truncate();
            
            // Change 'image' column to JSON to store multiple images
            $table->json('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            // Revert back to string
            $table->string('image')->nullable()->change();
        });
    }
};
