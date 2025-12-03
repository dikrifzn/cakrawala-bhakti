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
                'project_title' => 'Pernikahan Adat Sunda Meriah',
                'client_name' => 'Keluarga Sudaryanto',
                'location' => 'Bandung, Jawa Barat',
                'date' => '2024-11-15',
                'description' => 'Pernikahan adat Sunda dengan konsep tradisional modern. Menampilkan upacara sunda yang lengkap dengan dekorasi elegan dan catering premium. Dihadiri oleh 500+ tamu undangan dengan berbagai hiburan tradisional dan modern.',
                'cover_image' => 'project-wedding-adat.jpg',
            ],
            [
                'project_title' => 'Product Launch PT. Teknologi Indonesia',
                'client_name' => 'PT. Teknologi Indonesia',
                'location' => 'Jakarta, Indonesia',
                'date' => '2024-10-20',
                'description' => 'Launching produk teknologi terbaru dengan konsep futuristik. Event diadakan di convention center premium dengan 1000+ peserta, termasuk media, influencer, dan business partners. Menampilkan live demo, presentation dari CEO, dan entertainment performance.',
                'cover_image' => 'project-tech-launch.jpg',
            ],
            [
                'project_title' => 'Konser Musik Bersama Artis Internasional',
                'client_name' => 'Promotor Musik Jaya',
                'location' => 'Surabaya, Jawa Timur',
                'date' => '2024-09-05',
                'description' => 'Konser musik skala besar dengan menghadirkan artis internasional. Dihadiri oleh 5000+ penggemar dengan stage production berkualitas tinggi, sound system premium, dan berbagai merchandise official.',
                'cover_image' => 'project-concert.jpg',
            ],
            [
                'project_title' => 'Seminar Bisnis & Networking Tahunan',
                'client_name' => 'Asosiasi Pengusaha Muda Indonesia',
                'location' => 'Bandung, Jawa Barat',
                'date' => '2024-08-12',
                'description' => 'Seminar bisnis 2 hari dengan pembicara dari berbagai industri. Peserta mencapai 600+ dari berbagai kota. Mencakup keynote speeches, workshop interaktif, exhibition area, dan acara malam networking.',
                'cover_image' => 'project-seminar.jpg',
            ],
            [
                'project_title' => 'Festival Budaya Nasional',
                'client_name' => 'Dinas Pariwisata Kota',
                'location' => 'Yogyakarta, DIY',
                'date' => '2024-07-21',
                'description' => 'Festival budaya 3 hari yang menampilkan kesenian tradisional dari berbagai daerah. Dihadiri oleh 10000+ pengunjung dengan berbagai panggung pertunjukan, pameran budaya, dan aktivitas interaktif untuk keluarga.',
                'cover_image' => 'project-festival.jpg',
            ],
            [
                'project_title' => 'Grand Opening Shopping Mall Modern',
                'client_name' => 'PT. Developer Properti',
                'location' => 'Medan, Sumatera Utara',
                'date' => '2024-06-08',
                'description' => 'Grand opening mall dengan berbagai entertainment dan aktivitas menarik. Menampilkan live performance dari artis terkenal, flash mob, product demo dari berbagai brand tenant, dan undian hadiah menarik.',
                'cover_image' => 'project-mall-opening.jpg',
            ],
            [
                'project_title' => 'Perayaan Ulang Tahun Korporat 25 Tahun',
                'client_name' => 'PT. Industri Manufaktur',
                'location' => 'Tangerang, Banten',
                'date' => '2024-05-30',
                'description' => 'Perayaan milestone 25 tahun perusahaan dengan konsep yang meriah. Menampilkan performance karyawan, penghargaan untuk karyawan berprestasi, games interaktif, dan dinner gathering untuk semua stake holders.',
                'cover_image' => 'project-anniversary.jpg',
            ],
            [
                'project_title' => 'Workshop Entrepreneurship untuk UMKM',
                'client_name' => 'Kementerian Koperasi',
                'location' => 'Malang, Jawa Timur',
                'date' => '2024-04-15',
                'description' => 'Workshop 1 hari untuk 300+ UMKM dengan pembicara dari praktisi sukses. Mencakup sesi motivasi, business training, marketplace introduction, dan networking session dengan potential investor.',
                'cover_image' => 'project-workshop.jpg',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
