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
        WhyChooseUs::firstOrCreate([], [
            'title' => 'Mengapa Cakrawala?',
            'description' => '<p>Kami memahami bahwa setiap klien memiliki kebutuhan yang berbeda. Karena itu, kami menawarkan layanan yang fleksibel, detail, dan kreatif untuk memastikan setiap acara berjalan sempurna dari awal hingga akhir.</p><ul><li><p>✔ Perencanaan yang Tepat &amp; Terukur</p></li><li><p>✔ Tim Kreatif &amp; Berpengalaman</p></li><li><p>✔ Konsep Unik Sesuai Kebutuhan Klien</p></li><li><p>✔ Manajemen Acara yang Profesional</p></li></ul>',
            'image' => 'why-choose-us/default-thumbnail.png',
        ]);
    }
}
