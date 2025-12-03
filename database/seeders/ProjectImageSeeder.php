<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectImageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            // Create 3-4 images for each project
            for ($i = 1; $i <= 4; $i++) {
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image' => 'project-' . $project->id . '-image-' . $i . '.jpg',
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
