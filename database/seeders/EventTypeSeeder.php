<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed a comprehensive list aligned with BookingSeeder usage
        $eventTypes = [
            'Event Organizer',
            'Pengadaan Barang',
            'Lainnya',
        ];

        foreach ($eventTypes as $type) {
            EventType::create(['name' => $type]);
        }
    }
}
