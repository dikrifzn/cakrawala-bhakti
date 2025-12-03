<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSection::create([
            'title' => 'Tentang Cakrawala Bhakti',
            'subtitle' => 'Event Organizer Terpercaya',
            'description' => 'Cakrawala Bhakti adalah perusahaan event organizer yang berdedikasi untuk menciptakan pengalaman acara yang tak terlupakan. Dengan tim profesional dan pengalaman lebih dari 15 tahun, kami siap mewujudkan visi acara Anda dengan sempurna. Dari konsep, desain, hingga eksekusi, kami menangani setiap detail dengan cermat untuk memastikan kesuksesan acara Anda.',
            'image_1' => 'about-1.jpg',
            'image_2' => 'about-2.jpg',
            'image_3' => 'about-3.jpg',
            'image_4' => 'about-4.jpg',
        ]);
    }
}
