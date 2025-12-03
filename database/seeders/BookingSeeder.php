<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\EventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = EventType::all();

        $bookings = [
            [
                'customer_name' => 'Budi Santoso',
                'customer_email' => 'budi.santoso@email.com',
                'customer_phone' => '08123456789',
                'event_type_id' => $eventTypes->firstWhere('name', 'Pernikahan')?->id ?? 1,
                'start_date' => '2025-06-15',
                'end_date' => '2025-06-15',
                'start_time' => '10:00',
                'end_time' => '17:00',
                'total_days' => 1,
                'location' => 'Gedung Patra Jasa, Jakarta',
                'notes' => 'Pernikahan dengan tema modern minimalis, dihadiri 300 orang',
                'total_price' => 55000000,
                'status' => 'approved',
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'customer_email' => 'siti.nurhaliza@company.com',
                'customer_phone' => '08198765432',
                'event_type_id' => $eventTypes->firstWhere('name', 'Seminar')?->id ?? 6,
                'start_date' => '2025-03-10',
                'end_date' => '2025-03-11',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'total_days' => 2,
                'location' => 'Convention Center, Bandung',
                'notes' => 'Seminar bisnis 2 hari dengan 500 peserta, perlu live streaming',
                'total_price' => 45000000,
                'status' => 'approved',
            ],
            [
                'customer_name' => 'Ahmad Wijaya',
                'customer_email' => 'ahmad.wijaya@startup.com',
                'customer_phone' => '08112345678',
                'event_type_id' => $eventTypes->firstWhere('name', 'Product Launch')?->id ?? 8,
                'start_date' => '2025-04-20',
                'end_date' => '2025-04-20',
                'start_time' => '14:00',
                'end_time' => '22:00',
                'total_days' => 1,
                'location' => 'Hotel Hilton, Jakarta',
                'notes' => 'Product launch dengan konsep futuristik, mengundang media dan influencer',
                'total_price' => 60000000,
                'status' => 'pending',
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_email' => 'dewi.lestari@email.com',
                'customer_phone' => '08167890123',
                'event_type_id' => $eventTypes->firstWhere('name', 'Ulang Tahun')?->id ?? 3,
                'start_date' => '2025-02-14',
                'end_date' => '2025-02-14',
                'start_time' => '18:00',
                'end_time' => '23:00',
                'total_days' => 1,
                'location' => 'Rumah pribadi, Bandung',
                'notes' => 'Perayaan ulang tahun 40 untuk 100 orang dengan dekorasi elegan',
                'total_price' => 20000000,
                'status' => 'approved',
            ],
            [
                'customer_name' => 'Rendra Gunawan',
                'customer_email' => 'rendra.gunawan@corporate.com',
                'customer_phone' => '08154321098',
                'event_type_id' => $eventTypes->firstWhere('name', 'Team Building')?->id ?? 10,
                'start_date' => '2025-05-05',
                'end_date' => '2025-05-06',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'total_days' => 2,
                'location' => 'Resort Outbound, Puncak',
                'notes' => 'Team building 200 karyawan dengan games, outing, dan team bonding',
                'total_price' => 35000000,
                'status' => 'pending',
            ],
            [
                'customer_name' => 'Linda Suryanto',
                'customer_email' => 'linda.suryanto@email.com',
                'customer_phone' => '08198765432',
                'event_type_id' => $eventTypes->firstWhere('name', 'Engagement')?->id ?? 2,
                'start_date' => '2025-07-12',
                'end_date' => '2025-07-12',
                'start_time' => '17:00',
                'end_time' => '20:00',
                'total_days' => 1,
                'location' => 'Gedung Pertunjukan, Surabaya',
                'notes' => 'Acara lamaran dengan konsep klasik elegan untuk 150 tamu',
                'total_price' => 30000000,
                'status' => 'rejected',
            ],
            [
                'customer_name' => 'Yusuf Rahman',
                'customer_email' => 'yusuf.rahman@company.com',
                'customer_phone' => '08176543210',
                'event_type_id' => $eventTypes->firstWhere('name', 'Acara Sosial/Charity')?->id ?? 19,
                'start_date' => '2025-08-17',
                'end_date' => '2025-08-17',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'total_days' => 1,
                'location' => 'Lapangan Terbuka, Yogyakarta',
                'notes' => 'Acara amal dengan donor darah, pasar jasa sosial, 500 peserta',
                'total_price' => 25000000,
                'status' => 'approved',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}
