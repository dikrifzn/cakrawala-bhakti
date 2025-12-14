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
            'subtitle' => 'Event Planner & Organizer In Indonesia',
            'description' => 'Cakrawala adalah Event Organizer profesional yang berfokus pada menciptakan acara yang inspiratif dan berkesan. Kami percaya setiap acara memiliki cerita, dan tugas kami adalah memastikan cerita itu tersampaikan dengan sempurna. Dengan tim kreatif yang berpengalaman, kami menangani berbagai jenis event mulai dari corporate gathering, wedding, hingga festival komunitas dengan perencanaan yang matang dan hasil yang memuaskan.',
            'images' => [
                'about/default-thumbnail.png',
                'about/default-thumbnail.png',
                'about/default-thumbnail.png',
                'about/default-thumbnail.png',
                'about/default-thumbnail.png',
            ],
        ]);
    }
}
