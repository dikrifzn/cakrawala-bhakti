<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->json('images')->nullable()->after('description');
        });

        DB::table('about_sections')->select('id', 'image_1', 'image_2', 'image_3', 'image_4', 'image_5')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                $images = array_values(array_filter([
                    $row->image_1,
                    $row->image_2,
                    $row->image_3,
                    $row->image_4,
                    $row->image_5,
                ]));

                DB::table('about_sections')->where('id', $row->id)->update([
                    'images' => $images ? json_encode($images) : null,
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
