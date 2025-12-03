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
        HeroBanner::create([
            'title' => 'Wujudkan Acara Impian Anda',
            'highlight_text' => 'Bersama Cakrawala Bhakti',
            'subtitle' => 'Event organizer terpercaya untuk segala kebutuhan acara Anda dengan profesionalisme dan kreativitas tinggi.',
            'button_text' => 'Hubungi Kami',
            'button_link' => '#contact',
            'background_image' => 'hero-banner.jpg',
        ]);

        HeroBanner::create([
            'title' => 'Profesional Event Management',
            'highlight_text' => 'Pengalaman Bertahun-tahun',
            'subtitle' => 'Kami telah menangani ratusan acara dengan kepuasan klien mencapai 100%.',
            'button_text' => 'Lihat Portfolio',
            'button_link' => '#portfolio',
            'background_image' => 'hero-banner-2.jpg',
        ]);
    }
}
