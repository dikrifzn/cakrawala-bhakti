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
                'service_name' => 'MC Formal',
                'short_description' => 'MC',
                'price' => 500000,
                'banner_image' => 'services/default-thumbnail.png',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'MC Non Formal',
                'short_description' => 'MC',
                'price' => 700000,
                'banner_image' => 'services/default-thumbnail.png',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Stage',
                'short_description' => 'MC',
                'price' => 700000,
                'banner_image' => 'services/default-thumbnail.png',
                'sort_order' => 1,
            ],
            [
                'service_name' => 'Sound System',
                'short_description' => 'MC',
                'price' => 700000,
                'banner_image' => 'services/default-thumbnail.png',
                'sort_order' => 1,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
