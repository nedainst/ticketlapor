<?php

namespace Database\Seeders;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('masyarakat')->get();
        $admins = User::role(['admin', 'super_admin'])->get();

        $ticketsData = [
            // Infrastruktur
            ['category_id' => 1, 'title' => 'Jalan rusak parah di Jl. Raya Bogor KM 30', 'description' => '<p>Jalan di sepanjang Jl. Raya Bogor KM 30 mengalami kerusakan parah berupa lubang-lubang besar yang membahayakan pengendara. Sudah ada beberapa kecelakaan motor akibat lubang ini. Mohon segera diperbaiki.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.4714, 'longitude' => 106.8484, 'address' => 'Jl. Raya Bogor KM 30, Cisalak, Depok'],
            ['category_id' => 1, 'title' => 'Jembatan penyeberangan rusak di depan Pasar Senen', 'description' => '<p>Jembatan penyeberangan di depan Pasar Senen kondisinya sudah sangat memprihatinkan. Lantai jembatan banyak yang berlubang dan pagar pengaman sudah lepas. Sangat berbahaya terutama bagi lansia dan anak-anak.</p>', 'priority' => TicketPriority::DARURAT, 'status' => TicketStatus::PENDING, 'latitude' => -6.1746, 'longitude' => 106.8451, 'address' => 'Pasar Senen, Jakarta Pusat'],
            ['category_id' => 1, 'title' => 'Lampu jalan mati di sepanjang Jl. Diponegoro Surabaya', 'description' => '<p>Sudah 2 minggu lampu jalan di sepanjang Jl. Diponegoro Surabaya mati total. Jalan menjadi sangat gelap di malam hari dan sudah terjadi beberapa kasus penjambretan.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::SELESAI, 'latitude' => -7.2653, 'longitude' => 112.7503, 'address' => 'Jl. Diponegoro, Surabaya'],

            // Pelayanan Publik
            ['category_id' => 2, 'title' => 'Pelayanan lambat di Disdukcapil Bandung', 'description' => '<p>Proses pembuatan KTP elektronik di Disdukcapil Kota Bandung sangat lambat. Sudah 3 bulan mengajukan tapi belum jadi. Setiap kali datang selalu diminta menunggu tanpa kejelasan.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::MENUNGGU_BALASAN, 'latitude' => -6.9175, 'longitude' => 107.6191, 'address' => 'Disdukcapil Kota Bandung, Jl. Ambon No.1'],
            ['category_id' => 2, 'title' => 'Petugas kelurahan tidak ramah dan mempersulit urusan', 'description' => '<p>Saat mengurus surat pengantar di Kelurahan Menteng, petugas yang bertugas sangat tidak ramah dan mempersulit proses pembuatan surat. Bahkan diminta biaya tambahan yang tidak jelas peruntukannya.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.1944, 'longitude' => 106.8529, 'address' => 'Kelurahan Menteng, Jakarta Pusat'],

            // Pendidikan
            ['category_id' => 3, 'title' => 'Atap sekolah SDN 05 bocor saat hujan', 'description' => '<p>Atap ruang kelas 3 dan 4 SDN 05 Kebayoran bocor saat hujan. Air masuk ke dalam kelas dan mengganggu kegiatan belajar mengajar. Sudah dilaporkan ke dinas tapi belum ada tindakan.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::PENDING, 'latitude' => -6.2421, 'longitude' => 106.7810, 'address' => 'SDN 05 Kebayoran, Jakarta Selatan'],
            ['category_id' => 3, 'title' => 'Pungutan liar di SMPN 2 Yogyakarta', 'description' => '<p>Ada pungutan liar untuk "uang gedung" sebesar Rp 5 juta kepada siswa baru di SMPN 2 Yogyakarta. Padahal sekolah negeri seharusnya gratis. Mohon ditindaklanjuti.</p>', 'priority' => TicketPriority::DARURAT, 'status' => TicketStatus::DIPROSES, 'latitude' => -7.7956, 'longitude' => 110.3695, 'address' => 'SMPN 2 Yogyakarta, Jl. P. Senopati No.28'],

            // Kesehatan
            ['category_id' => 4, 'title' => 'Puskesmas Kecamatan kekurangan obat dasar', 'description' => '<p>Puskesmas Kecamatan Tanah Abang sudah 1 bulan kehabisan stok obat-obatan dasar seperti parasetamol, amoksisilin, dan obat batuk. Pasien terpaksa membeli sendiri di apotek.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::SELESAI, 'latitude' => -6.1862, 'longitude' => 106.8117, 'address' => 'Puskesmas Tanah Abang, Jakarta Pusat'],
            ['category_id' => 4, 'title' => 'BPJS ditolak di RS Swasta tanpa alasan jelas', 'description' => '<p>Ibu saya yang menderita sakit jantung ditolak berobat menggunakan BPJS di RS Harapan Kita. Alasan yang diberikan tidak jelas, padahal BPJS kami aktif dan sesuai faskes.</p>', 'priority' => TicketPriority::DARURAT, 'status' => TicketStatus::MENUNGGU_BALASAN, 'latitude' => -6.1974, 'longitude' => 106.7957, 'address' => 'RS Harapan Kita, Jakarta Barat'],

            // Keamanan
            ['category_id' => 5, 'title' => 'Sering terjadi pencurian motor di RT 05 RW 03', 'description' => '<p>Dalam 1 bulan terakhir sudah 4 kali terjadi pencurian motor di lingkungan RT 05 RW 03 Kelurahan Menteng Atas. Pos ronda kosong dan CCTV tidak berfungsi.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.2146, 'longitude' => 106.8478, 'address' => 'RT 05 RW 03, Menteng Atas, Jakarta Selatan'],

            // Lingkungan
            ['category_id' => 6, 'title' => 'Tumpukan sampah di TPS Cipinang tidak diangkut 1 minggu', 'description' => '<p>Sampah di TPS Cipinang sudah menggunung dan tidak diangkut selama 1 minggu lebih. Bau sangat menyengat dan tikus berkeliaran. Warga sekitar mulai mengeluh masalah kesehatan.</p>', 'priority' => TicketPriority::TINGGI, 'status' => TicketStatus::PENDING, 'latitude' => -6.2200, 'longitude' => 106.8800, 'address' => 'TPS Cipinang, Jakarta Timur'],
            ['category_id' => 6, 'title' => 'Sungai Ciliwung bau dan berwarna hitam', 'description' => '<p>Air Sungai Ciliwung di daerah Kampung Melayu sangat tercemar, berwarna hitam pekat dan berbau sangat menyengat. Diduga ada limbah pabrik yang dibuang langsung ke sungai.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.2240, 'longitude' => 106.8598, 'address' => 'Kampung Melayu, Jakarta Timur'],

            // Transportasi
            ['category_id' => 7, 'title' => 'Bus TransJakarta koridor 6 sering telat dan penuh', 'description' => '<p>Bus TransJakarta koridor 6 (Ragunan-Dukuh Atas) selalu telat dan penuh sesak, terutama jam 07.00-09.00. Penumpang harus menunggu hingga 30-45 menit untuk mendapat bus.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::SELESAI, 'latitude' => -6.3021, 'longitude' => 106.8204, 'address' => 'Halte TransJakarta Ragunan, Jakarta Selatan'],
            ['category_id' => 7, 'title' => 'Parkir liar di trotoar Jl. Thamrin', 'description' => '<p>Trotoar di sepanjang Jl. MH Thamrin sering digunakan untuk parkir liar oleh motor dan mobil, sehingga pejalan kaki terpaksa berjalan di badan jalan. Sangat berbahaya.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::PENDING, 'latitude' => -6.1951, 'longitude' => 106.8228, 'address' => 'Jl. MH Thamrin, Jakarta Pusat'],

            // Lainnya
            ['category_id' => 8, 'title' => 'WiFi gratis di taman kota tidak berfungsi', 'description' => '<p>Fasilitas WiFi gratis yang dijanjikan di Taman Suropati sudah tidak berfungsi selama 2 bulan. Padahal banyak warga yang memanfaatkannya untuk belajar dan bekerja.</p>', 'priority' => TicketPriority::RENDAH, 'status' => TicketStatus::SELESAI, 'latitude' => -6.1987, 'longitude' => 106.8410, 'address' => 'Taman Suropati, Menteng, Jakarta Pusat'],

            // Additional tickets for variety
            ['category_id' => 1, 'title' => 'Gorong-gorong tersumbat di Jl. Gatot Subroto', 'description' => '<p>Gorong-gorong di Jl. Gatot Subroto Km 5 tersumbat oleh sampah sehingga menyebabkan genangan air setiap hujan. Ketinggian genangan bisa mencapai 30 cm.</p>', 'priority' => TicketPriority::SEDANG, 'status' => TicketStatus::PENDING, 'latitude' => -6.2328, 'longitude' => 106.8189, 'address' => 'Jl. Gatot Subroto Km 5, Jakarta Selatan'],
            ['category_id' => 2, 'title' => 'Antrian panjang di kantor SAMSAT Bekasi', 'description' => '<p>Antrian di SAMSAT Bekasi sangat panjang dan sistem antriannya tidak teratur. Warga harus menunggu hingga 4-5 jam hanya untuk bayar pajak kendaraan. Mohon ditambah loket.</p>', 'priority' => TicketPriority::RENDAH, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.2383, 'longitude' => 106.9756, 'address' => 'SAMSAT Kota Bekasi, Jl. Ir. H. Juanda'],
            ['category_id' => 5, 'title' => 'Geng motor meresahkan warga Depok', 'description' => '<p>Sekelompok geng motor sering melakukan aksi kebut-kebutan dan kekerasan di Jl. Margonda Raya setiap malam Minggu. Warga sudah melapor ke polisi tapi belum ada tindakan tegas.</p>', 'priority' => TicketPriority::DARURAT, 'status' => TicketStatus::DIPROSES, 'latitude' => -6.3882, 'longitude' => 106.8328, 'address' => 'Jl. Margonda Raya, Depok'],
            ['category_id' => 6, 'title' => 'Pohon tumbang menutupi jalan di Bogor', 'description' => '<p>Pohon besar tumbang di Jl. Pajajaran Bogor akibat hujan deras tadi malam. Jalan tertutup total dan belum ada petugas yang membersihkan. Lalu lintas macet parah.</p>', 'priority' => TicketPriority::DARURAT, 'status' => TicketStatus::SELESAI, 'latitude' => -6.5971, 'longitude' => 106.7960, 'address' => 'Jl. Pajajaran, Bogor'],
        ];

        foreach ($ticketsData as $index => $data) {
            $user = $users[$index % $users->count()];
            $admin = $admins->random();

            $ticket = Ticket::create([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'assigned_to' => in_array($data['status'], [TicketStatus::DIPROSES, TicketStatus::MENUNGGU_BALASAN, TicketStatus::SELESAI]) ? $admin->id : null,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'address' => $data['address'],
                'created_at' => now()->subDays(rand(1, 60))->subHours(rand(0, 23)),
                'resolved_at' => $data['status'] === TicketStatus::SELESAI ? now()->subDays(rand(0, 5)) : null,
                'first_responded_at' => in_array($data['status'], [TicketStatus::DIPROSES, TicketStatus::MENUNGGU_BALASAN, TicketStatus::SELESAI]) ? now()->subDays(rand(1, 10)) : null,
                'response_time_minutes' => in_array($data['status'], [TicketStatus::DIPROSES, TicketStatus::MENUNGGU_BALASAN, TicketStatus::SELESAI]) ? rand(30, 2880) : null,
            ]);

            // Add messages to processed/completed tickets
            if (in_array($data['status'], [TicketStatus::DIPROSES, TicketStatus::MENUNGGU_BALASAN, TicketStatus::SELESAI])) {
                // Admin response
                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $admin->id,
                    'body' => '<p>Terima kasih atas laporan Anda. Kami sudah menerima dan sedang menindaklanjuti laporan ini. Tim kami akan segera turun ke lokasi untuk verifikasi.</p>',
                    'created_at' => $ticket->created_at->addHours(rand(1, 24)),
                ]);

                // User reply
                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'body' => '<p>Baik, terima kasih atas responnya. Saya tunggu tindak lanjutnya. Mohon segera ditangani karena situasinya sudah cukup mengkhawatirkan.</p>',
                    'created_at' => $ticket->created_at->addHours(rand(25, 48)),
                ]);

                if ($data['status'] === TicketStatus::SELESAI) {
                    TicketMessage::create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $admin->id,
                        'body' => '<p>Laporan Anda sudah kami tindaklanjuti dan masalah telah diselesaikan. Terima kasih atas partisipasi Anda dalam menjaga lingkungan kita bersama. Silakan hubungi kami kembali jika ada masalah lain.</p>',
                        'created_at' => $ticket->created_at->addDays(rand(3, 7)),
                    ]);
                }
            }
        }
    }
}
