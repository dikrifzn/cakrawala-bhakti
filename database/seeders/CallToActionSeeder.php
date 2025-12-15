<?php

namespace Database\Seeders;

use App\Models\CallToAction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallToActionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallToAction::truncate();
        
        CallToAction::create([
            'title' => "<p>Let&#039;s Collaborate and Make</p><p>Your Event Super Special</p>",
            'highlight_text' => 'Your Event Super Special',
            'subtitle' => 'Kami siap menjadi mitra terbaik Anda dalam setiap momen penting. Hubungi kami dan wujudkan acara impian Anda bersama Cakrawala.',
            'background_image' => 'cta/default-thumbnail.png',
        ]);
    }
}
