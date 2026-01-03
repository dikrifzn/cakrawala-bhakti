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
                'service_name' => 'Perencanaan Konsep Acara',
                'short_description' => 'Perencanaan Konsep Acara',
                'price' => 0,
                'banner_image' => 'services/01KDZYFWGZK61QZYNPS9JR21BZ.webp',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Manajemen Produksi Teknis',
                'short_description' => 'Manajemen Produksi Teknis',
                'price' => 0,
                'banner_image' => 'services/01KDZYMWPVR5GS9XHK3WZ8BYW4.jpg',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Pengelolaan SDM Acara',
                'short_description' => 'Pengelolaan SDM Acara',
                'price' => 0,
                'banner_image' => 'services/01KDZYR73X64Y5RM0HCK7C13B5.jpg',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Koordinasi Pelaksanaan Acara',
                'short_description' => 'Koordinasi Pelaksanaan Acara',
                'price' => 0,
                'banner_image' => 'services/01KDZYTNVGGVWE7HSPGCVRW30D.jpg',
                'sort_order' => 1,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
