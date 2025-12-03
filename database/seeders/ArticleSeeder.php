<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ArticleCategory::all();

        $posts = [
            [
                'title' => 'Tren Dekorasi Pernikahan 2025',
                'slug' => 'tren-dekorasi-pernikahan-2025',
                'content' => '<p>Dekorasi pernikahan terus berkembang mengikuti tren modern. Tahun 2025 menampilkan beberapa tren menarik yang patut diperhatikan:</p><p><strong>1. Minimalis Elegan</strong></p><p>Desain minimalis tetap menjadi pilihan utama dengan sentuhan modern dan elegan. Warna netral seperti beige, cream, dan abu-abu mendominasi.</p><p><strong>2. Botanical & Nature</strong></p><p>Penggunaan elemen alam seperti tanaman live, bunga organik, dan material kayu alami semakin populer.</p><p><strong>3. Tech Integration</strong></p><p>Teknologi seperti proyeksi mapping, drone show, dan lighting interaktif menambah pengalaman yang memorable.</p><p>Konsultasikan tema pernikahan Anda dengan tim profesional kami untuk hasil yang sempurna!</p>',
                'thumbnail' => 'article-wedding-decor.jpg',
                'category_id' => $categories->firstWhere('slug', 'pernikahan')?->id,
            ],
            [
                'title' => '10 Tips Sukses Acara Korporat',
                'slug' => '10-tips-sukses-acara-korporat',
                'content' => '<p>Acara korporat yang sukses memerlukan perencanaan matang. Berikut adalah 10 tips untuk memastikan acara korporat Anda berhasil:</p><p><strong>1. Tentukan Tujuan Acara</strong></p><p>Jelas tentang apa yang ingin dicapai dari acara ini.</p><p><strong>2. Pilih Venue yang Tepat</strong></p><p>Lokasi harus strategis dan sesuai dengan kapasitas peserta.</p><p><strong>3. Buat Timeline yang Detail</strong></p><p>Perencanaan waktu yang detail memastikan semuanya berjalan lancar.</p><p><strong>4. Perhatikan Catering</strong></p><p>Makanan berkualitas meningkatkan kepuasan peserta.</p><p><strong>5. Persiapkan Material Promosi</strong></p><p>Banners, merchandise, dan displays harus menarik dan profesional.</p><p>Biarkan tim kami menangani semua detail teknis acara Anda!</p>',
                'thumbnail' => 'article-corporate-event.jpg',
                'category_id' => $categories->firstWhere('slug', 'event-korporat')?->id,
            ],
            [
                'title' => 'Cara Memilih Vendor Event yang Tepat',
                'slug' => 'cara-memilih-vendor-event-yang-tepat',
                'content' => '<p>Memilih vendor yang tepat adalah kunci kesuksesan acara. Berikut panduan memilih vendor event yang berkualitas:</p><p><strong>Portfolio & Experience</strong></p><p>Lihat portfolio mereka dan berapa lama mereka di industri ini.</p><p><strong>Referensi & Review</strong></p><p>Minta referensi dari klien sebelumnya dan baca review mereka.</p><p><strong>Komunikasi yang Baik</strong></p><p>Pastikan vendor responsif dan mudah berkomunikasi.</p><p><strong>Harga Kompetitif</strong></p><p>Bandingkan harga dengan vendor lain tanpa mengorbankan kualitas.</p><p><strong>Kontrak yang Jelas</strong></p><p>Semua detail harus tertulis dalam kontrak yang jelas dan transparan.</p><p>Cakrawala Bhakti siap menjadi vendor pilihan Anda dengan pengalaman lebih dari 15 tahun!</p>',
                'thumbnail' => 'article-vendor-selection.jpg',
                'category_id' => $categories->firstWhere('slug', 'tips-trik')?->id,
            ],
            [
                'title' => 'Inovasi Terbaru dalam Teknologi Event',
                'slug' => 'inovasi-terbaru-dalam-teknologi-event',
                'content' => '<p>Teknologi terus mengubah cara kita menjalankan acara. Berikut inovasi terbaru yang perlu Anda ketahui:</p><p><strong>Virtual & Hybrid Events</strong></p><p>Kombinasi acara fisik dan virtual untuk jangkauan yang lebih luas.</p><p><strong>Augmented Reality (AR)</strong></p><p>Pengalaman interaktif yang menggabungkan dunia nyata dan digital.</p><p><strong>Artificial Intelligence</strong></p><p>AI membantu personalisasi pengalaman untuk setiap peserta.</p><p><strong>Real-time Analytics</strong></p><p>Data analytics real-time untuk mengukur kesuksesan acara.</p><p><strong>Sustainable Event Tech</strong></p><p>Teknologi ramah lingkungan untuk acara yang lebih berkelanjutan.</p><p>Manfaatkan teknologi terkini untuk acara Anda bersama kami!</p>',
                'thumbnail' => 'article-tech-innovation.jpg',
                'category_id' => $categories->firstWhere('slug', 'teknologi-event')?->id,
            ],
            [
                'title' => 'Pernikahan Adat: Menghormati Tradisi dengan Gaya Modern',
                'slug' => 'pernikahan-adat-menghormati-tradisi-dengan-gaya-modern',
                'content' => '<p>Pernikahan adat tetap relevan dengan sentuhan modern. Bagaimana cara mengabungkan tradisi dengan gaya kontemporer?</p><p><strong>Menghormati Elemen Tradisional</strong></p><p>Pertahankan upacara dan ritual penting dari budaya Anda.</p><p><strong>Modernisasi Presentasi</strong></p><p>Gunakan elemen modern dalam dekorasi dan entertainment.</p><p><strong>Hybrid Wardrobe</strong></p><p>Perpaduan pakaian tradisional dengan sentuhan desainer kontemporer.</p><p><strong>Digital Documentation</strong></p><p>Live streaming dan drone photography untuk dokumentasi modern.</p><p><strong>Fusion Cuisine</strong></p><p>Menu yang menggabungkan masakan tradisional dan internasional.</p><p>Tim kami berpengalaman dalam mengelola pernikahan adat yang modern dan berkelas!</p>',
                'thumbnail' => 'article-adat-wedding.jpg',
                'category_id' => $categories->firstWhere('slug', 'pernikahan')?->id,
            ],
            [
                'title' => 'Launching Produk yang Memorable: Strategi Kami',
                'slug' => 'launching-produk-yang-memorable-strategi-kami',
                'content' => '<p>Launching produk memerlukan strategi khusus untuk menciptakan buzz dan dampak maksimal.</p><p><strong>Pre-Launch Campaign</strong></p><p>Bangun antisipasi melalui teaser dan media sosial sebelum acara.</p><p><strong>Experiential Marketing</strong></p><p>Buat pengalaman interaktif yang membuat peserta merasa terlibat.</p><p><strong>Influencer Collaboration</strong></p><p>Melibatkan influencer untuk meningkatkan jangkauan dan kredibilitas.</p><p><strong>Multi-channel Coverage</strong></p><p>Liputan media online, offline, dan sosial media secara bersamaan.</p><p><strong>Follow-up Strategy</strong></p><p>Rencana komunikasi lanjutan setelah acara berakhir.</p><p>Percayakan launching produk Anda kepada tim profesional kami untuk hasil yang luar biasa!</p>',
                'thumbnail' => 'article-product-launch.jpg',
                'category_id' => $categories->firstWhere('slug', 'event-korporat')?->id,
            ],
            [
                'title' => 'Konsep Acara Sosial yang Berdampak',
                'slug' => 'konsep-acara-sosial-yang-berdampak',
                'content' => '<p>Acara sosial tidak hanya tentang kesenangan, tetapi juga tentang dampak dan memberikan nilai positif kepada masyarakat.</p><p><strong>Program Sosial yang Terintegrasi</strong></p><p>Sertakan aktivitas sosial atau charity dalam acara Anda.</p><p><strong>Community Engagement</strong></p><p>Libatkan komunitas lokal dan berikan manfaat langsung kepada mereka.</p><p><strong>Sustainability Focus</strong></p><p>Terapkan praktik ramah lingkungan dalam setiap aspek acara.</p><p><strong>Educational Component</strong></p><p>Tambahkan elemen edukasi untuk meningkatkan nilai acara.</p><p><strong>Storytelling yang Kuat</strong></p><p>Ceritakan kisah yang menyentuh hati peserta.</p><p>Mari bersama menciptakan acara sosial yang bermakna dan berdampak!</p>',
                'thumbnail' => 'article-social-event.jpg',
                'category_id' => $categories->firstWhere('slug', 'acara-sosial')?->id,
            ],
            [
                'title' => 'Trending: Virtual Events yang Sukses',
                'slug' => 'trending-virtual-events-yang-sukses',
                'content' => '<p>Virtual event telah menjadi bagian penting dari industri event modern. Berikut tren yang sedang berkembang:</p><p><strong>Hybrid Format</strong></p><p>Kombinasi peserta fisik dan virtual untuk jangkauan maksimal.</p><p><strong>Interactive Features</strong></p><p>Live polls, Q&A sessions, dan networking virtual untuk engagement.</p><p><strong>High Production Value</strong></p><p>Produksi berkualitas tinggi dengan multiple camera angles dan profesional.</p><p><strong>On-Demand Content</strong></p><p>Konten dapat diakses setelah acara berakhir untuk nilai jangka panjang.</p><p><strong>Personalized Experience</strong></p><p>Setiap peserta mendapat pengalaman yang disesuaikan dengan minat mereka.</p><p>Kami siap mengubah acara Anda menjadi virtual event yang engaging dan sukses!</p>',
                'thumbnail' => 'article-virtual-event.jpg',
                'category_id' => $categories->firstWhere('slug', 'trending-topics')?->id,
            ],
        ];

        foreach ($posts as $post) {
            Article::create($post);
        }
    }
}
