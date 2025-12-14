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
            'description' => '<p><strong>Kami memahami bahwa setiap klien memiliki kebutuhan yang berbeda. Karena itu, kami menawarkan layanan yang fleksibel, detail, dan kreatif untuk memastikan setiap acara berjalan sempurna dari awal hingga akhir.</strong></p><ul><li><p><strong>✔ Perencanaan yang Tepat &amp; Terukur</strong></p></li><li><p><strong>✔ Tim Kreatif &amp; Berpengalaman</strong></p></li><li><p><strong>✔ Konsep Unik Sesuai Kebutuhan Klien</strong></p></li><li><p><strong>✔ Manajemen Acara yang Profesional</strong></p></li></ul>',
            'image' => null,
        ]);
    }
}
