<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Pernikahan',
                'short_description' => 'Paket lengkap untuk acara pernikahan impian Anda',
                'icon' => 'fas fa-ring',
                'price' => 50000000,
                'banner_image' => 'service-wedding.jpg',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Acara Korporat',
                'short_description' => 'Paket event korporat profesional dan berkesan',
                'icon' => 'fas fa-briefcase',
                'price' => 30000000,
                'banner_image' => 'service-corporate.jpg',
                'sort_order' => 2,
            ],
            [
                'service_name' => 'Launching Produk',
                'short_description' => 'Strategi launching produk yang efektif dan menarik',
                'icon' => 'fas fa-rocket',
                'price' => 35000000,
                'banner_image' => 'service-launch.jpg',
                'sort_order' => 3,
            ],
            [
                'service_name' => 'Seminar & Workshop',
                'short_description' => 'Penyelenggaraan seminar dan workshop berkualitas',
                'icon' => 'fas fa-chalkboard-user',
                'price' => 20000000,
                'banner_image' => 'service-seminar.jpg',
                'sort_order' => 4,
            ],
            [
                'service_name' => 'Festival & Konser',
                'short_description' => 'Pengelolaan festival dan konser musik skala besar',
                'icon' => 'fas fa-music',
                'price' => 75000000,
                'banner_image' => 'service-festival.jpg',
                'sort_order' => 5,
            ],
            [
                'service_name' => 'Pesta Ulang Tahun',
                'short_description' => 'Paket perayaan ulang tahun yang meriah dan menyenangkan',
                'icon' => 'fas fa-birthday-cake',
                'price' => 15000000,
                'banner_image' => 'service-birthday.jpg',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
