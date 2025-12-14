<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'images')) {
                $table->json('images')->nullable()->after('description');
            }
        });

        if (Schema::hasColumn('projects', 'cover_image')) {
            $projects = DB::table('projects')->select('id', 'cover_image')->get();
            foreach ($projects as $project) {
                if (!empty($project->cover_image)) {
                    DB::table('projects')->where('id', $project->id)->update([
                        'images' => json_encode([$project->cover_image]),
                    ]);
                }
            }

            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('cover_image');
            });
        }

        if (Schema::hasTable('project_images')) {
            Schema::drop('project_images');
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('description');
        });

        $projects = DB::table('projects')->select('id', 'images')->get();
        foreach ($projects as $project) {
            $images = json_decode($project->images ?? '[]', true) ?: [];
            $first = $images[0] ?? null;
            if ($first) {
                DB::table('projects')->where('id', $project->id)->update([
                    'cover_image' => $first,
                ]);
            }
        }

        if (Schema::hasColumn('projects', 'images')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }

        if (!Schema::hasTable('project_images')) {
            Schema::create('project_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->json('image')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }
};
