<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::truncate();

        SiteSetting::create([
            'site_name' => 'Cakrawala Bhakti',
            'tagline' => 'Event Organizer & Planner Profesional',
            'footer_description' => 'Kami membantu Anda menciptakan acara berkesanmulai dari konsep, perencanaan, hingga pelaksanaan.
Bersama Cakrawala, setiap momen menjadi istimewa.',
            'address' => 'Perumahan Pesona Ancaran Blok C No.61, Desa Ancaran, Kec. Kuningan, Kab. Kuningan, Prov. Jawa Barat, 45514. Indonesia.',
            'phone' => '+62 821-1816-2013',
            'email' => 'info@cakrawalabhakti.com',
            'admin_email' => null,
            'manager_email' => null,
            'instagram' => 'https://instagram.com/cakrawalabhakti',
            'facebook' => null,
            'tiktok' => null,
            'logo_header' => 'logo-white.png',
            'logo_footer' => 'logo-white.png',
        ]);
    }
}
