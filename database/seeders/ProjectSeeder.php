<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'project_title' => 'Audisi Umum PB Djarum Nasional',
                'client_name' => 'PB Djarum',
                'location' => 'Kudus, Jawa Tengah',
                'date' => '2024-08-20',
                'description' => 'Audisi Umum PB Djarum merupakan ajang pencarian bakat bulutangkis berskala nasional. Acara ini diikuti oleh ribuan peserta dari berbagai daerah di Indonesia dengan sistem seleksi profesional. Event berlangsung selama beberapa hari dengan dukungan fasilitas standar kompetisi nasional.',
                'images' => array_fill(0, 10, 'projects/default-thumbnail.png'),
            ],
            [
                'project_title' => 'Djarum Superliga Badminton',
                'client_name' => 'Djarum Foundation',
                'location' => 'Jakarta',
                'date' => '2024-09-15',
                'description' => 'Djarum Superliga Badminton menghadirkan klub-klub terbaik dengan atlet nasional dan internasional. Event ini dikemas dengan konsep sportainment modern, tata panggung profesional, serta manajemen pertandingan berstandar tinggi.',
                'images' => array_fill(0, 10, 'projects/default-thumbnail.png'),
            ],
            [
                'project_title' => 'Event Musik dan Hiburan Djarum',
                'client_name' => 'PT Djarum',
                'location' => 'Surabaya, Jawa Timur',
                'date' => '2024-10-05',
                'description' => 'Event musik yang didukung Djarum dengan konsep hiburan modern dan tata panggung megah. Menampilkan artis nasional, lighting profesional, serta pengalaman pengunjung yang immersive.',
                'images' => array_fill(0, 10, 'projects/default-thumbnail.png'),
            ],
            [
                'project_title' => 'Corporate Gathering Djarum Group',
                'client_name' => 'Djarum Group',
                'location' => 'Bali',
                'date' => '2024-07-22',
                'description' => 'Corporate gathering internal Djarum Group yang dikemas secara eksklusif. Acara ini bertujuan memperkuat sinergi internal dengan konsep profesional, agenda terstruktur, dan suasana yang nyaman.',
                'images' => array_fill(0, 10, 'projects/default-thumbnail.png'),
            ],
            [
                'project_title' => 'Event Budaya Nusantara Djarum Foundation',
                'client_name' => 'Djarum Foundation',
                'location' => 'Yogyakarta',
                'date' => '2024-06-18',
                'description' => 'Event budaya yang menampilkan seni tradisional Nusantara dengan pendekatan modern. Acara ini bertujuan melestarikan budaya sekaligus memberikan ruang bagi seniman lokal untuk berkolaborasi.',
                'images' => array_fill(0, 10, 'projects/default-thumbnail.png'),
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
