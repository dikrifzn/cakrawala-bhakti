<?php

namespace Database\Seeders;

use App\Models\LandingSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSectionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingSection::create([
            'section_key' => 'hero',
            'title' => 'Wujudkan Acara Impian Anda',
            'subtitle' => 'Event organizer terpercaya untuk segala kebutuhan acara Anda',
            'content' => 'Dengan pengalaman lebih dari 15 tahun di industri event, Cakrawala Bhakti siap mewujudkan visi acara Anda menjadi kenyataan yang sempurna.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        LandingSection::create([
            'section_key' => 'statistics',
            'title' => 'Pencapaian Kami',
            'subtitle' => 'Kepercayaan klien adalah aset terbesar kami',
            'content' => 'Ratusan acara telah kami tangani dengan tingkat kepuasan klien mencapai 100%',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        LandingSection::create([
            'section_key' => 'cta',
            'title' => 'Siap Wujudkan Acara Impian Anda?',
            'subtitle' => 'Hubungi tim profesional kami sekarang',
            'content' => 'Dapatkan konsultasi gratis dan penawaran spesial untuk acara Anda.',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        LandingSection::create([
            'section_key' => 'testimonial',
            'title' => 'Apa Kata Klien Kami',
            'subtitle' => 'Kepuasan klien adalah prioritas utama kami',
            'content' => 'Dengarkan cerita sukses dari berbagai klien yang telah kami layani.',
            'is_active' => true,
            'sort_order' => 4,
        ]);
    }
}
