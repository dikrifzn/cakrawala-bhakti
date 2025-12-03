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
        $eventTypes = [
            'Pernikahan',
            'Engagement',
            'Ulang Tahun',
            'Resepsi',
            'Seminar',
            'Workshop',
            'Conference',
            'Product Launch',
            'Gathering Keluarga',
            'Team Building',
            'Awards Ceremony',
            'Launching Bisnis',
            'Pernikahan Adat',
            'Kenduri/Arisan',
            'Festival/Bazaar',
            'Konser/Musik',
            'Outing Perusahaan',
            'Gathering Internal',
            'Acara Sosial/Charity',
            'Lainnya',
        ];

        foreach ($eventTypes as $type) {
            EventType::create(['name' => $type]);
        }
    }
}
