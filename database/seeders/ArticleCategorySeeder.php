<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pernikahan', 'slug' => 'pernikahan'],
            ['name' => 'Event Korporat', 'slug' => 'event-korporat'],
            ['name' => 'Tips & Trik', 'slug' => 'tips-trik'],
            ['name' => 'Acara Sosial', 'slug' => 'acara-sosial'],
            ['name' => 'Teknologi Event', 'slug' => 'teknologi-event'],
            ['name' => 'Trending Topics', 'slug' => 'trending-topics'],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create($category);
        }
    }
}
