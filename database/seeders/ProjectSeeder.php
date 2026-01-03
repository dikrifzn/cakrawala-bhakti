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
                'images' => [
                        "projects/01KDZZ3X4YJJTARGSMG39AXB1B.webp",
                        "projects/01KDZZ3X542ZKHMNQ6J171VTSF.jpg",
                        "projects/01KDZZ3X59AHAW63DYNBCCQDWX.jpg",
                        "projects/01KDZZ3X5GPKCC47VQ47N9CM30.jpg",
                        "projects/01KDZZ3X5N0M6PVPE88ER8DXE8.webp",
                        "projects/01KDZZ3X5V06ME3J46ZTZWGF4K.jpeg",
                        "projects/01KDZZ3X6405E9FHJZSTMY3X9D.jpg",
                        "projects/01KDZZ3X68H52XSM2VA7JJ9F0P.jpg",
                        "projects/01KDZZ3X6D81GQRACY2276WMB7.jpg",
                        "projects/01KDZZ3X6JSD4204PX5Z2055VP.jpg"
                    ],
            ],
            [
                'project_title' => 'Event Musik dan Hiburan Djarum',
                'client_name' => 'PT Djarum',
                'location' => 'Surabaya, Jawa Timur',
                'date' => '2024-10-05',
                'description' => 'Event musik yang didukung Djarum dengan konsep hiburan modern dan tata panggung megah. Menampilkan artis nasional, lighting profesional, serta pengalaman pengunjung yang immersive.',
                'images' => [
                        "projects/01KDZY61A05F91HN61DYWCSKGB.jpg",
                        "projects/01KDZY61A77YCRVHG1EQM75NS6.jpg",
                        "projects/01KDZY61ACZ7QKDQ056SET26ZG.jpg",
                        "projects/01KDZY61ANV3PNV6AHK7G9QZQR.jpg",
                        "projects/01KDZY61ATVQE1014PXPFWGNAJ.jpg",
                        "projects/01KDZY61AZCF3YGWRCJX6HKHFX.jpg",
                        "projects/01KDZY61B4CJVC6GHH6JE7HJJK.jpg",
                        "projects/01KDZY61B9528VJZ4988MPVJW9.jpg",
                        "projects/01KDZY61BDDERRSWGE335N03S3.jpg",
                        "projects/01KDZY61BJJC7FTMDSCW920Y2R.jpg"
                    ],
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
