<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('about_sections', 'image_5')) {
                $table->string('image_5')->nullable()->after('image_4');
            }
        });

        Schema::table('why_choose_us', function (Blueprint $table) {
            if (Schema::hasColumn('why_choose_us', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('why_choose_us', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            if (Schema::hasColumn('about_sections', 'image_5')) {
                $table->dropColumn('image_5');
            }
        });

        Schema::table('why_choose_us', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('description');
            $table->integer('sort_order')->default(0)->after('icon');
        });
    }
};
