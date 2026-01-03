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
                'title' => 'NGEGIGS! Kuningan Hadirkan Panggung Musik Lokal Penuh Energi',
                'slug' => 'ngegigs-kuningan-hadirkan-panggung-musik-lokal-penuh-energi',
                'content' => '
                    <h2>NGEGIGS! Kuningan Hadirkan Panggung Musik Lokal Penuh Energi</h2><p>Kuningan kembali menjadi titik temu bagi para penikmat musik melalui gelaran <strong>NGEGIGS! Road to United Day</strong>. Acara ini menjadi wadah ekspresi bagi musisi lokal lintas genre yang siap menghadirkan atmosfer panggung penuh semangat, interaksi, serta kebersamaan.</p><p>Diselenggarakan oleh <strong>Supermusic</strong>, NGEGIGS! tidak sekadar menjadi konser musik, melainkan ruang apresiasi bagi kreativitas komunitas musik daerah. Dengan konsep <strong>live music</strong> serta <strong>jamming session</strong>, penonton diajak merasakan pengalaman pertunjukan yang lebih dekat, hangat, serta autentik.</p><h3>Deretan Penampil Meramaikan Panggung</h3><p>Sejumlah musisi lokal turut meramaikan acara ini, di antaranya:</p><ul><li><p>Putra “Burgerkill”</p></li><li><p>Avedis Mutter “Strangers”</p></li><li><p>Machdis Arie “Kilms”</p></li><li><p>Mustika Kamal</p></li><li><p>Minus Etika</p></li><li><p>Brainbleed</p></li><li><p>Monarki</p></li><li><p>Breeze</p></li><li><p>River</p></li><li><p>Free Time</p></li></ul><p>Kolaborasi berbagai karakter musik ini menjanjikan warna pertunjukan yang beragam, mulai dari nuansa keras hingga santai, mencerminkan dinamika skena musik lokal.</p><h3>Waktu dan Lokasi Acara</h3><p>NGEGIGS! Kuningan akan berlangsung pada:</p><ul><li><p><strong>Tanggal:</strong> 16 November 2024</p></li><li><p><strong>Tempat:</strong> Blackbine Cafe, Kuningan</p></li></ul><p>Lokasi ini dipilih untuk menciptakan suasana intim yang memungkinkan penonton menikmati pertunjukan secara lebih personal.</p><h3>Lebih dari Sekadar Konser</h3><p>Mengusung semangat <strong>#IniRasanyaSuper</strong>, NGEGIGS! menjadi simbol dukungan terhadap musisi lokal serta ruang berkumpulnya komunitas kreatif. Acara ini diharapkan mampu memperkuat ekosistem musik daerah sekaligus menghadirkan hiburan berkualitas bagi masyarakat Kuningan.</p>',
                'thumbnail' => 'articles/01KDZY9ST18J1RSGR29509S3P7.jpg',
                'category_id' => $categories->firstWhere('slug', 'trending-topics')?->id,
            ],
            [
                'title' => 'Audisi Umum PB Djarum: Menemukan Bintang Bulutangkis Masa Depan',
                'slug' => 'audisi-umum-pb-djarum',
                'content' => '
                    <p>Audisi Umum PB Djarum dikenal sebagai program pencarian bakat bulutangkis terbesar di Indonesia. Ribuan peserta dari berbagai daerah mengikuti seleksi yang dilakukan secara profesional dan transparan.</p>

                    <p>Proses audisi melibatkan pelatih berpengalaman yang menilai kemampuan teknis, fisik, dan mental peserta. Sistem seleksi dirancang untuk menjaring atlet dengan potensi jangka panjang.</p>

                    <p>Program ini telah melahirkan banyak atlet berprestasi yang mengharumkan nama Indonesia di kancah internasional. Audisi menjadi bukti nyata peran Djarum dalam pembinaan olahraga.</p>

                    <p>Melalui audisi ini, regenerasi atlet nasional dapat terus berjalan secara berkelanjutan.</p>',
                'thumbnail' => 'articles/01KDZYXG61MQEY8PHZJNHF0EJ3.webp',
                'category_id' => $categories->firstWhere('slug', 'trending-topics')?->id,
            ],
            [
                'title' => 'Peran Djarum Foundation dalam Event Sosial dan Pendidikan',
                'slug' => 'djarum-foundation-event-sosial',
                'content' => '
                    <p>Djarum Foundation secara aktif menyelenggarakan dan mendukung berbagai event sosial dan pendidikan di Indonesia. Kegiatan ini bertujuan meningkatkan kualitas sumber daya manusia.</p>

                    <p>Program yang dijalankan meliputi beasiswa, pelatihan kepemimpinan, hingga pengembangan keterampilan generasi muda. Setiap event dirancang dengan konsep edukatif dan berkelanjutan.</p>

                    <p>Melalui event sosial ini, Djarum Foundation berupaya memberikan dampak nyata bagi masyarakat luas. Kolaborasi dengan institusi pendidikan dan komunitas lokal menjadi kunci keberhasilan.</p>

                    <p>Event-event tersebut menjadi bagian dari kontribusi sosial jangka panjang yang berfokus pada masa depan.</p>',
                'thumbnail' => 'articles/01KDZYZFAP37YGQ56ADHPKCHMR.jpg',
                'category_id' => $categories->firstWhere('slug', 'acara-sosial')?->id,
            ],
            [
                'title' => 'Event Musik dan Hiburan yang Didukung Djarum',
                'slug' => 'event-musik-djarum',
                'content' => '
                    <p>Djarum kerap terlibat dalam penyelenggaraan event musik berskala nasional dengan konsep yang kreatif. Event ini menggabungkan hiburan, teknologi, dan tata panggung modern.</p>

                    <p>Line-up artis ternama serta produksi panggung profesional menjadi daya tarik utama. Pengunjung tidak hanya menikmati musik, tetapi juga pengalaman event yang immersive.</p>

                    <p>Event musik ini memberikan ruang bagi industri kreatif untuk berkembang dan berkolaborasi. Banyak pelaku seni dan vendor lokal yang turut terlibat.</p>

                    <p>Konsep event yang matang menjadikan acara musik ini selalu dinantikan oleh masyarakat.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'trending-topics')?->id,
            ],
            [
                'title' => 'Konsep Event Corporate Djarum yang Profesional dan Terstruktur',
                'slug' => 'konsep-event-corporate-djarum',
                'content' => '
                    <p>Event corporate Djarum dikenal dengan perencanaan yang detail dan eksekusi yang profesional. Setiap acara dirancang sesuai dengan tujuan dan nilai perusahaan.</p>

                    <p>Mulai dari peluncuran produk hingga internal gathering, seluruh rangkaian acara dikelola dengan standar tinggi. Manajemen waktu dan koordinasi menjadi prioritas utama.</p>

                    <p>Konsep visual, tata panggung, dan pengalaman peserta selalu diperhatikan secara menyeluruh. Hal ini menciptakan kesan eksklusif dan berkelas.</p>

                    <p>Event corporate yang tersusun rapi mencerminkan identitas dan profesionalisme brand.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'event-korporat')?->id,
            ],
            [
                'title' => 'Event Budaya dan Seni yang Didukung Djarum Foundation',
                'slug' => 'event-budaya-djarum-foundation',
                'content' => '
                    <p>Djarum Foundation berperan aktif dalam mendukung pelestarian budaya melalui berbagai event seni dan budaya. Kegiatan ini melibatkan seniman lokal dan komunitas budaya.</p>

                    <p>Festival budaya, pameran seni, dan pertunjukan tradisional menjadi sarana edukasi sekaligus hiburan. Event dikemas dengan pendekatan modern tanpa meninggalkan nilai tradisional.</p>

                    <p>Melalui event budaya, generasi muda diajak untuk mengenal dan menghargai warisan bangsa. Kolaborasi lintas sektor menjadi kekuatan utama program ini.</p>

                    <p>Pelestarian budaya melalui event menjadi investasi jangka panjang bagi identitas nasional.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'acara-sosial')?->id,
            ],
            [
                'title' => 'Manajemen Event Skala Besar ala Djarum',
                'slug' => 'manajemen-event-skala-besar-djarum',
                'content' => '
                    <p>Event berskala besar membutuhkan manajemen yang matang dan terstruktur. Djarum menerapkan sistem kerja profesional pada setiap tahap penyelenggaraan.</p>

                    <p>Perencanaan dimulai dari konsep, anggaran, hingga teknis pelaksanaan. Setiap divisi memiliki peran dan tanggung jawab yang jelas.</p>

                    <p>Evaluasi pasca acara juga menjadi bagian penting untuk memastikan peningkatan kualitas event berikutnya. Pendekatan ini menjamin konsistensi mutu.</p>

                    <p>Manajemen event yang baik menghasilkan pengalaman acara yang aman dan berkesan.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'tips-trik')?->id,
            ],
            [
                'title' => 'Kolaborasi Event Djarum dengan Event Organizer Profesional',
                'slug' => 'kolaborasi-event-djarum-eo',
                'content' => '
                    <p>Kesuksesan event besar tidak terlepas dari peran Event Organizer profesional. Djarum menjalin kolaborasi dengan EO berpengalaman untuk memastikan kualitas acara.</p>

                    <p>EO bertanggung jawab terhadap teknis produksi, koordinasi vendor, dan pengelolaan rundown. Kolaborasi yang solid menciptakan alur kerja yang efisien.</p>

                    <p>Sinergi antara brand dan EO menghasilkan event yang selaras dengan visi dan target audiens. Setiap detail diperhatikan secara menyeluruh.</p>

                    <p>Kolaborasi ini menjadi contoh praktik terbaik dalam industri event.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'tips-trik')?->id,
            ],
            [
                'title' => 'Dampak Event Djarum terhadap Industri Kreatif Nasional',
                'slug' => 'dampak-event-djarum-industri-kreatif',
                'content' => '
                    <p>Event-event yang didukung Djarum memberikan dampak signifikan bagi industri kreatif nasional. Banyak pelaku kreatif terlibat dalam proses produksi acara.</p>

                    <p>Vendor lokal, UMKM, dan tenaga kreatif mendapatkan kesempatan untuk berkembang. Event menjadi sarana distribusi ekonomi kreatif.</p>

                    <p>Kolaborasi lintas sektor menciptakan ekosistem event yang sehat dan berkelanjutan. Dampaknya dirasakan secara luas.</p>

                    <p>Industri kreatif terus tumbuh seiring meningkatnya kualitas penyelenggaraan event.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'trending-topics')?->id,
            ],
            [
                'title' => 'Strategi Penyelenggaraan Event Berkelanjutan ala Djarum',
                'slug' => 'strategi-event-berkelanjutan-djarum',
                'content' => '
                    <p>Konsep keberlanjutan menjadi perhatian utama dalam penyelenggaraan event modern. Djarum menerapkan strategi ramah lingkungan dalam berbagai acara.</p>

                    <p>Pengurangan limbah, efisiensi energi, dan penggunaan material berkelanjutan menjadi fokus utama. Setiap event dirancang dengan tanggung jawab sosial.</p>

                    <p>Pendekatan ini tidak hanya meningkatkan citra acara, tetapi juga memberikan dampak positif bagi lingkungan.</p>

                    <p>Event berkelanjutan menjadi standar baru dalam industri event.</p>',
                'thumbnail' => 'articles/default-thumbnail.png',
                'category_id' => $categories->firstWhere('slug', 'teknologi-event')?->id,
            ],
        ];

        foreach ($posts as $post) {
            Article::updateOrCreate(
                ['slug' => $post['slug']],
                $post,
            );
        }
    }
}
