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
            'tagline' => 'Event organizer terpercaya untuk segala kebutuhan acara Anda',
            'footer_description' => 'Cakrawala Bhakti adalah perusahaan event organizer yang berdedikasi untuk menciptakan pengalaman acara yang tak terlupakan dengan tim profesional dan berpengalaman lebih dari 15 tahun di industri.',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'phone' => '(021) 1234-5678',
            'email' => 'info@cakrawalabhakti.com',
            'admin_email' => 'dikrifauz@gmail.com',
            'manager_email' => null,
            'instagram' => 'https://instagram.com/cakrawalabhakti',
            'facebook' => 'https://facebook.com/cakrawalabhakti',
            'tiktok' => 'https://tiktok.com/@cakrawalabhakti',
            'logo_header' => 'logo-header.png',
            'logo_footer' => 'logo-footer.png',
        ]);
    }
}
