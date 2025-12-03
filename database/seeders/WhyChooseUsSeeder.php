<?php

namespace Database\Seeders;

use App\Models\WhyChooseUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            [
                'title' => 'Tim Profesional',
                'description' => 'Tim berpengalaman dengan track record cemerlang dalam menangani berbagai jenis acara',
                'icon' => 'fas fa-users',
                'sort_order' => 1,
            ],
            [
                'title' => 'Kreativitas Tinggi',
                'description' => 'Konsep unik dan inovatif untuk membuat acara Anda berbeda dan berkesan',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 2,
            ],
            [
                'title' => 'Manajemen Budget',
                'description' => 'Transparansi penuh dalam pengelolaan budget dengan harga yang kompetitif',
                'icon' => 'fas fa-coins',
                'sort_order' => 3,
            ],
            [
                'title' => 'Dukungan 24/7',
                'description' => 'Tim siap membantu Anda kapan saja sebelum, saat, dan sesudah acara',
                'icon' => 'fas fa-headset',
                'sort_order' => 4,
            ],
            [
                'title' => 'Vendor Terpercaya',
                'description' => 'Jaringan luas vendor terpercaya untuk memenuhi semua kebutuhan acara Anda',
                'icon' => 'fas fa-handshake',
                'sort_order' => 5,
            ],
            [
                'title' => 'Pengalaman Puluhan Tahun',
                'description' => 'Pengalaman mengurus acara dari skala kecil hingga besar dengan tingkat kepuasan tinggi',
                'icon' => 'fas fa-star',
                'sort_order' => 6,
            ],
        ];

        foreach ($reasons as $reason) {
            WhyChooseUs::create($reason);
        }
    }
}
