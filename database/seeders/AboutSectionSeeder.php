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
                "about/01KDZXDFNY3QVSW9V9S4G38DEQ.jpg",
                "about/01KDZXDFP4PVRYZDPD3B1N7FQ3.jpg",
                "about/01KDZXDFP8GMSAKQ6MH646ZREA.jpg",
                "about/01KDZXDFPKJ034Y75C09SHPAXP.jpg",
                "about/01KDZXDFPVYM8GAK2XFHN6BD0K.jpg"
            ],
        ]);
    }
}
