<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all seeders
        $this->call([
            UserSeeder::class,
            HeroBannerSeeder::class,
            AboutSectionSeeder::class,
            WhyChooseUsSeeder::class,
            ServiceSeeder::class,
            ArticleCategorySeeder::class,
            ArticleSeeder::class,
            ProjectSeeder::class,
            ProjectImageSeeder::class,
            EventTypeSeeder::class,
            BookingSeeder::class,
            SiteSettingSeeder::class,
        ]);

        $now = now();
        $tables = [
            'hero_banners',
            'about_sections',
            'why_choose_us',
            'services',
            'article_categories',
            'articles',
            'projects',
            'project_images',
            'event_types',
            'bookings',
            'landing_sections',
            'site_settings',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)
                    ->whereNull('created_at')
                    ->orWhere('created_at', '<', '2000-01-01')
                    ->update(['created_at' => $now, 'updated_at' => $now]);
            }
        }
    }
}

