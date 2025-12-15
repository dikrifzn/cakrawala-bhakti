<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroBanner::firstOrCreate([], [
            'title' => '<p>Kami Mewujudkan</p><p>Acara Anda Jadi Momen</p><p>Tak Terlupakan</p>',
            'highlight_text' => 'Acara Anda',
            'subtitle' => 'Event Organizer Profesional untuk Corporate, Wedding, dan Community Event.',
            'button_text' => "Let's Collaborate",
            'button_link' => '/booking',
            'background_image' => 'hero-banners/default-thumbnail.png',
        ]);
    }
}
