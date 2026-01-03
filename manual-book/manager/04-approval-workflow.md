# Alur Persetujuan

## Gambaran Umum

Alur persetujuan adalah bagian penting dari sistem manajemen pemesanan acara. Ini memastikan bahwa semua pemesanan ditinjau dan disetujui oleh personel yang sesuai sebelum diselesaikan. Dokumen ini menguraikan langkah-langkah yang terlibat dalam alur persetujuan dari perspektif manajer.

## Langkah-langkah dalam Alur Persetujuan

1. **Mengakses Dashboard Persetujuan**

   - Masuk ke dashboard manajer.
   - Navigasi ke bagian "Pemesanan" untuk melihat persetujuan yang tertunda.

2. **Meninjau Detail Pemesanan**

   - Klik pada pemesanan untuk melihat detailnya, termasuk informasi pelanggan, layanan yang diminta, dan catatan khusus apa pun.
   - Pastikan semua dokumentasi yang diperlukan dilampirkan, seperti kontrak atau perjanjian.

3. **Membuat Keputusan**

   - Setelah meninjau pemesanan, putuskan apakah akan menyetujui atau menolak permintaan.
   - Jika informasi tambahan diperlukan, Anda dapat meminta klarifikasi dari pelanggan langsung melalui platform.

4. **Proses Persetujuan**

   - Untuk menyetujui pemesanan, klik tombol "Setujui". Tindakan ini akan memicu notifikasi email ke pelanggan yang mengkonfirmasi pemesanan mereka.
   - Jika menolak, pilih opsi "Tolak" dan berikan alasan penolakan. Pelanggan akan menerima notifikasi dengan detail penolakan.

5. **Membuat PDF Persetujuan**

   - Setelah pemesanan disetujui, Anda dapat membuat PDF persetujuan untuk pencatatan.
   - Gunakan metode `ApprovalService::generateApprovalPdf($booking)` untuk membuat dokumen PDF.

6. **Memantau Status Persetujuan**

   - Lacak semua pemesanan dalam antrian persetujuan.
   - Periksa secara teratur pemesanan baru yang memerlukan perhatian Anda.

7. **Menyelesaikan Pemesanan**
   - Setelah persetujuan, pastikan bahwa semua tindakan tindak lanjut yang diperlukan diambil, seperti mengkonfirmasi pembayaran dan menjadwalkan acara.

## Praktik Terbaik

- Tinjau pemesanan tertunda secara teratur untuk menghindari penundaan dalam proses persetujuan.
- Pertahankan komunikasi yang jelas dengan pelanggan mengenai status pemesanan mereka.
- Pastikan semua anggota tim yang terlibat dalam proses persetujuan dilatih tentang alur kerja untuk menjaga konsistensi.

## Kesimpulan

Alur persetujuan dirancang untuk merampingkan proses pemesanan sambil memastikan bahwa semua pemeriksaan yang diperlukan dilakukan. Dengan mengikuti langkah-langkah yang diuraikan, manajer dapat secara efektif mengelola pemesanan dan memberikan pengalaman yang lancar bagi pelanggan.
