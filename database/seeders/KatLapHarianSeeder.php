<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon; // Import DB facade
use Illuminate\Support\Facades\DB;
// Import Carbon for timestamps

class KatLapHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori laporan
        $kategori = [
            ['id_kat' => 2, 'nm_kategori' => 'Membuat Surat Menyurat yang berkaitan dengan UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:34:53'), 'updated_at' => Carbon::parse('2022-12-20 20:36:00')],
            ['id_kat' => 3, 'nm_kategori' => 'Membuat Surat Izin Usaha Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:35:13'), 'updated_at' => Carbon::parse('2022-12-20 20:35:45')],
            ['id_kat' => 4, 'nm_kategori' => 'Membuat Surat Perjanjian Kerja THL Parkir.', 'created_at' => Carbon::parse('2022-12-20 20:35:35'), 'updated_at' => Carbon::parse('2022-12-20 20:35:35')],
            ['id_kat' => 5, 'nm_kategori' => 'Membuat Struktur Organisasi UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:36:18'), 'updated_at' => Carbon::parse('2022-12-20 20:36:18')],
            ['id_kat' => 6, 'nm_kategori' => 'Memberikan Informasi berupa lisan dan data kepada Mahasiswa yang melakukan penelitian di UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:36:39'), 'updated_at' => Carbon::parse('2022-12-20 20:36:39')],
            ['id_kat' => 7, 'nm_kategori' => 'Konsultasi dan Koordinasi terkait Kunjungan Kerja dari Dalam atau Luar Daerah.', 'created_at' => Carbon::parse('2022-12-20 20:37:00'), 'updated_at' => Carbon::parse('2022-12-20 20:37:00')],
            ['id_kat' => 9, 'nm_kategori' => 'Melakukan Pemberkasan yang berkaitan dengan BLUD.', 'created_at' => Carbon::parse('2022-12-20 20:37:56'), 'updated_at' => Carbon::parse('2022-12-20 20:37:56')],
            ['id_kat' => 10, 'nm_kategori' => 'Melakukan Pengarsipan Surat Masuk dan Keluar yang berkaitan dengan BLUD.', 'created_at' => Carbon::parse('2022-12-20 20:38:19'), 'updated_at' => Carbon::parse('2022-12-20 20:38:19')],
            ['id_kat' => 11, 'nm_kategori' => 'Membuat Surat Menyurat yang bekaitan dengan BLUD.', 'created_at' => Carbon::parse('2022-12-20 20:38:48'), 'updated_at' => Carbon::parse('2022-12-20 20:38:48')],
            ['id_kat' => 12, 'nm_kategori' => 'Perencanaan Regulasi BLUD UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:39:12'), 'updated_at' => Carbon::parse('2022-12-20 20:39:12')],
            ['id_kat' => 13, 'nm_kategori' => 'Mengikuti Kegiatan Rapat dalam Daerah.', 'created_at' => Carbon::parse('2022-12-20 20:41:04'), 'updated_at' => Carbon::parse('2022-12-20 20:41:04')],
            ['id_kat' => 14, 'nm_kategori' => 'Melakukan Perjalanan Dinas Dalam atau Luar Daerah.', 'created_at' => Carbon::parse('2022-12-20 20:42:39'), 'updated_at' => Carbon::parse('2022-12-20 20:42:39')],
            ['id_kat' => 15, 'nm_kategori' => 'Membuat kelengkapan dokumen terkait hasil rapat yang telah dilaksanakan.', 'created_at' => Carbon::parse('2022-12-20 20:42:58'), 'updated_at' => Carbon::parse('2022-12-20 20:42:58')],
            ['id_kat' => 16, 'nm_kategori' => 'Membuat persiapan bahan untuk rapat yang akan dilaksanakan.', 'created_at' => Carbon::parse('2022-12-20 20:43:09'), 'updated_at' => Carbon::parse('2022-12-20 20:43:09')],
            ['id_kat' => 17, 'nm_kategori' => 'Membuat / perpanjangan Kontrak Kerjasama diluar zona lelang.', 'created_at' => Carbon::parse('2022-12-20 20:43:21'), 'updated_at' => Carbon::parse('2022-12-20 20:43:21')],
            ['id_kat' => 18, 'nm_kategori' => 'Membuat / perpanjangan Surat Perintah Tugas (SPT) per ruas Jalan.', 'created_at' => Carbon::parse('2022-12-20 20:43:34'), 'updated_at' => Carbon::parse('2022-12-20 20:43:34')],
            ['id_kat' => 19, 'nm_kategori' => 'Melakukan Pengarsipan Surat Masuk dan Keluar yang berkaitan dengan UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:43:48'), 'updated_at' => Carbon::parse('2022-12-20 20:43:48')],
            ['id_kat' => 20, 'nm_kategori' => 'Memberikan Penomoran Surat Keluar.', 'created_at' => Carbon::parse('2022-12-20 20:44:08'), 'updated_at' => Carbon::parse('2022-12-20 20:44:08')],
            ['id_kat' => 21, 'nm_kategori' => 'Menjalankan Disposisi Surat yang telah turun untuk diteruskan Ke Kepala UPT dan atau Kasubag Perparkiran;', 'created_at' => Carbon::parse('2022-12-20 20:44:27'), 'updated_at' => Carbon::parse('2022-12-20 20:44:27')],
            ['id_kat' => 22, 'nm_kategori' => 'Membuat Analisa Jabatan ASN UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:44:41'), 'updated_at' => Carbon::parse('2022-12-20 20:44:41')],
            ['id_kat' => 23, 'nm_kategori' => 'Membuat Surat Terkait Pengelolaan Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:44:54'), 'updated_at' => Carbon::parse('2022-12-20 20:44:54')],
            ['id_kat' => 24, 'nm_kategori' => 'Membuat Undangan Rapat terkait Permasalahan Pengelolaan Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:47:08'), 'updated_at' => Carbon::parse('2022-12-20 20:47:08')],
            ['id_kat' => 25, 'nm_kategori' => 'Melakukan Pencatatan dan pendistribusian Karcis Tarif Layanan Parkir diluar zona lelang.', 'created_at' => Carbon::parse('2022-12-20 20:47:19'), 'updated_at' => Carbon::parse('2022-12-20 20:47:19')],
            ['id_kat' => 26, 'nm_kategori' => 'Melakukan Pendataan Juru Parkir di Kota Pekanbaru.', 'created_at' => Carbon::parse('2022-12-20 20:47:36'), 'updated_at' => Carbon::parse('2022-12-20 20:47:36')],
            ['id_kat' => 27, 'nm_kategori' => 'Membuat KTA di luar zona lelang.', 'created_at' => Carbon::parse('2022-12-20 20:47:52'), 'updated_at' => Carbon::parse('2022-12-20 20:47:52')],
            ['id_kat' => 28, 'nm_kategori' => 'Menyiapkan berkas-berkas terkait Ranperwako BLUD.', 'created_at' => Carbon::parse('2022-12-20 20:48:06'), 'updated_at' => Carbon::parse('2022-12-20 20:48:06')],
            ['id_kat' => 32, 'nm_kategori' => 'Membantu pengurus barang dalam membuat laporan terkait asset dan persediaan barang.', 'created_at' => Carbon::parse('2022-12-20 20:48:51'), 'updated_at' => Carbon::parse('2022-12-20 20:48:51')],
            ['id_kat' => 33, 'nm_kategori' => 'Membantu tugas tim administrasi lainnya dalam menyiapkan bahan dan berkas untuk persiapan rapat.', 'created_at' => Carbon::parse('2022-12-20 20:49:02'), 'updated_at' => Carbon::parse('2022-12-20 20:49:02')],
            ['id_kat' => 34, 'nm_kategori' => 'Membantu mengantarkan surat.', 'created_at' => Carbon::parse('2022-12-20 20:49:22'), 'updated_at' => Carbon::parse('2022-12-20 20:49:22')],
            ['id_kat' => 35, 'nm_kategori' => 'Mengajukan pencairan Gaji Tenaga Harian Lepas (THL) UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:49:55'), 'updated_at' => Carbon::parse('2022-12-20 20:49:55')],
            ['id_kat' => 36, 'nm_kategori' => 'Membuat Rencana Bisnis Anggaran (RBA).', 'created_at' => Carbon::parse('2022-12-20 20:50:11'), 'updated_at' => Carbon::parse('2022-12-20 20:50:11')],
            ['id_kat' => 37, 'nm_kategori' => 'Melengkapi dokumen SPJ.', 'created_at' => Carbon::parse('2022-12-20 20:50:23'), 'updated_at' => Carbon::parse('2022-12-20 20:50:23')],
            ['id_kat' => 38, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Laporan Realisasi Anggaran (LRA).', 'created_at' => Carbon::parse('2022-12-20 20:51:13'), 'updated_at' => Carbon::parse('2022-12-20 20:51:13')],
            ['id_kat' => 39, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - SPJ Fungsional.', 'created_at' => Carbon::parse('2022-12-20 20:51:49'), 'updated_at' => Carbon::parse('2022-12-20 20:51:49')],
            ['id_kat' => 40, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Laporan Operasional (LO)', 'created_at' => Carbon::parse('2022-12-20 20:52:09'), 'updated_at' => Carbon::parse('2022-12-20 20:52:09')],
            ['id_kat' => 41, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Buku Kas Umum (BKU) Pengeluaran.', 'created_at' => Carbon::parse('2022-12-20 20:52:46'), 'updated_at' => Carbon::parse('2022-12-20 20:52:46')],
            ['id_kat' => 42, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Uraian Belanja.', 'created_at' => Carbon::parse('2022-12-20 20:53:01'), 'updated_at' => Carbon::parse('2022-12-20 20:53:01')],
            ['id_kat' => 43, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - SP3BP.', 'created_at' => Carbon::parse('2022-12-20 20:53:14'), 'updated_at' => Carbon::parse('2022-12-20 20:53:14')],
            ['id_kat' => 44, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Laporan Arus Kas (LAK)', 'created_at' => Carbon::parse('2022-12-20 20:53:38'), 'updated_at' => Carbon::parse('2022-12-20 20:53:38')],
            ['id_kat' => 45, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Laporan Perubahan Ekuitas (LPE)', 'created_at' => Carbon::parse('2022-12-20 20:54:06'), 'updated_at' => Carbon::parse('2022-12-20 20:54:06')],
            ['id_kat' => 46, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - Neraca', 'created_at' => Carbon::parse('2022-12-20 20:54:18'), 'updated_at' => Carbon::parse('2022-12-20 20:54:18')],
            ['id_kat' => 47, 'nm_kategori' => 'Membantu Bendahara Pengeluaran dalam membuat laporan keuangan (Akuntansi) - CALK.', 'created_at' => Carbon::parse('2022-12-20 20:54:31'), 'updated_at' => Carbon::parse('2022-12-20 20:54:31')],
            ['id_kat' => 48, 'nm_kategori' => 'Membantu Bendahara Penerimaan - Menerima Setoran Tarif Layanan Parkir.', 'created_at' => Carbon::parse('2022-12-20 20:55:06'), 'updated_at' => Carbon::parse('2022-12-20 20:55:06')],
            ['id_kat' => 49, 'nm_kategori' => 'Membantu Bendahara Penerimaan - Membuat Laporan Penerimaan harian, bulanan dan tahunan.', 'created_at' => Carbon::parse('2022-12-20 20:55:33'), 'updated_at' => Carbon::parse('2022-12-20 20:55:33')],
            ['id_kat' => 50, 'nm_kategori' => 'Membantu Bendahara Penerimaan -  Melakukan penyetoran Tarif Layanan Parkir ke Kas BLUD UPT Perparkiran.', 'created_at' => Carbon::parse('2022-12-20 20:55:57'), 'updated_at' => Carbon::parse('2022-12-20 20:55:57')],
            ['id_kat' => 51, 'nm_kategori' => 'Membantu Bendahara Penerimaan -  Melakukan Penyetoran Pembayaran BPJS.', 'created_at' => Carbon::parse('2022-12-20 20:56:37'), 'updated_at' => Carbon::parse('2022-12-20 20:56:37')],
            ['id_kat' => 52, 'nm_kategori' => 'Membantu Absensi PNS dan THL.', 'created_at' => Carbon::parse('2022-12-20 20:56:52'), 'updated_at' => Carbon::parse('2022-12-20 20:56:52')],
            ['id_kat' => 53, 'nm_kategori' => 'Melakukan patroli rutin pada pagi, siang dan malam hari.', 'created_at' => Carbon::parse('2022-12-20 20:57:05'), 'updated_at' => Carbon::parse('2022-12-20 20:57:05')],
            ['id_kat' => 54, 'nm_kategori' => 'Melakukan pengawasan dan penertiban perparkiran di Kota Pekanbaru.', 'created_at' => Carbon::parse('2022-12-20 20:57:22'), 'updated_at' => Carbon::parse('2022-12-20 20:57:22')],
            ['id_kat' => 55, 'nm_kategori' => 'Menindaklanjuti laporan masyarakat yang masuk terkait pelanggaran parkir.', 'created_at' => Carbon::parse('2022-12-20 20:57:38'), 'updated_at' => Carbon::parse('2022-12-20 20:57:38')],
            ['id_kat' => 56, 'nm_kategori' => 'Menertibkan serta memberi arahan kepada Juru Parkir apabila terjadi pelanggaran dilapangan.', 'created_at' => Carbon::parse('2022-12-20 20:57:53'), 'updated_at' => Carbon::parse('2022-12-20 20:57:53')],
            ['id_kat' => 57, 'nm_kategori' => 'Melakukan pengelolaan, pengawasan dan pengendalian kegiatan perparkiran', 'created_at' => Carbon::parse('2022-12-28 01:18:45'), 'updated_at' => Carbon::parse('2022-12-28 01:18:45')],
            ['id_kat' => 58, 'nm_kategori' => 'Melakukan pengumpulan, pengolahan dan penelaahan data / informasi sebagai bahan perumusan teknis operasional pengelolaan perparkiran', 'created_at' => Carbon::parse('2022-12-28 01:18:57'), 'updated_at' => Carbon::parse('2022-12-28 01:18:57')],
            ['id_kat' => 59, 'nm_kategori' => 'Menyusun rencana pola operasional dalam upaya penertiban dan pembinaan terhadap juru parkir', 'created_at' => Carbon::parse('2022-12-28 01:19:16'), 'updated_at' => Carbon::parse('2022-12-28 01:19:16')],
            ['id_kat' => 60, 'nm_kategori' => 'Melakukan pengaturan dan pengawasan kendaraan bermotor yang menggunakan jasa perparkiran', 'created_at' => Carbon::parse('2022-12-28 01:19:33'), 'updated_at' => Carbon::parse('2022-12-28 01:19:33')],
            ['id_kat' => 61, 'nm_kategori' => 'Melaksanakan Penertiban Parkir', 'created_at' => Carbon::parse('2022-12-28 01:22:51'), 'updated_at' => Carbon::parse('2022-12-28 01:22:51')],
            ['id_kat' => 62, 'nm_kategori' => 'Melaksanakan Penarikan Retribusi.', 'created_at' => Carbon::parse('2022-12-28 01:23:10'), 'updated_at' => Carbon::parse('2022-12-28 01:23:10')],
            ['id_kat' => 63, 'nm_kategori' => 'Melaksanakan Survey Wilayah Perparkiran', 'created_at' => Carbon::parse('2022-12-28 01:23:33'), 'updated_at' => Carbon::parse('2022-12-28 01:23:33')],
            ['id_kat' => 64, 'nm_kategori' => 'Menindaklanjuti Laporan / Pengaduan Masyarakat', 'created_at' => Carbon::parse('2023-02-01 13:48:07'), 'updated_at' => Carbon::parse('2023-02-01 13:47:46')],
            ['id_kat' => 65, 'nm_kategori' => 'Melaksanakan PAM Simpul Sekolah.', 'created_at' => Carbon::parse('2023-02-01 14:42:17'), 'updated_at' => Carbon::parse('2023-02-01 14:42:17')],
            ['id_kat' => 66, 'nm_kategori' => 'Melaksanakan Apel Pagi / Apel Serah Terima / Apel Malam', 'created_at' => Carbon::parse('2023-02-01 14:41:47'), 'updated_at' => Carbon::parse('2023-02-01 14:41:47')],
            ['id_kat' => 68, 'nm_kategori' => 'Melakukan Pendampingan Pihak PT / Koordinator Parkir', 'created_at' => Carbon::parse('2023-02-02 12:01:15'), 'updated_at' => Carbon::parse('2023-02-02 12:01:15')],
            ['id_kat' => 69, 'nm_kategori' => 'Menerima Surat Masuk', 'created_at' => Carbon::parse('2023-02-02 12:24:47'), 'updated_at' => Carbon::parse('2023-02-02 12:24:47')],
            ['id_kat' => 70, 'nm_kategori' => 'Melakukan Pendataan Tamu yang datang', 'created_at' => Carbon::parse('2023-02-02 12:25:06'), 'updated_at' => Carbon::parse('2023-02-02 12:25:06')],
            ['id_kat' => 71, 'nm_kategori' => 'Berkoordinasi dengan bagian umum terkait penomoram surat keluar', 'created_at' => Carbon::parse('2023-02-02 12:25:37'), 'updated_at' => Carbon::parse('2023-02-02 12:25:37')],
            ['id_kat' => 72, 'nm_kategori' => 'Patroli Pengecekan Atribut Juru Parkir', 'created_at' => Carbon::parse('2023-02-02 15:41:13'), 'updated_at' => Carbon::parse('2023-02-02 15:41:13')],
            ['id_kat' => 73, 'nm_kategori' => 'Kegiatan Minggu Hari Bebas Kendaraan (HBKB)', 'created_at' => Carbon::parse('2023-02-05 02:17:49'), 'updated_at' => Carbon::parse('2023-02-05 02:17:49')],
            ['id_kat' => 74, 'nm_kategori' => 'Kegiatan Pengamanan (PAM)', 'created_at' => Carbon::parse('2023-02-05 12:34:55'), 'updated_at' => Carbon::parse('2023-02-05 12:34:55')],
            ['id_kat' => 75, 'nm_kategori' => 'Kegiatan Olahraga UPT Perparkiran', 'created_at' => Carbon::parse('2023-02-20 15:25:09'), 'updated_at' => Carbon::parse('2023-02-20 15:25:09')],
            ['id_kat' => 76, 'nm_kategori' => 'PERPARKIRAN BERBAGI', 'created_at' => Carbon::parse('2023-02-19 06:10:18'), 'updated_at' => Carbon::parse('2023-02-19 06:10:18')],
            ['id_kat' => 77, 'nm_kategori' => 'UPT Perparkiran Peduli (berbagi sembako)', 'created_at' => Carbon::parse('2023-02-20 15:24:47'), 'updated_at' => Carbon::parse('2023-02-20 15:24:47')],
            ['id_kat' => 78, 'nm_kategori' => 'Kegiatan UPT PERPARKIRAN ', 'created_at' => Carbon::parse('2023-03-09 11:40:45'), 'updated_at' => Carbon::parse('2023-03-09 11:40:45')],
            ['id_kat' => 79, 'nm_kategori' => 'Gotong Royong UPT Perparkiran', 'created_at' => Carbon::parse('2023-03-09 13:15:13'), 'updated_at' => Carbon::parse('2023-03-09 13:15:13')],
        ];

        // Kosongkan tabel sebelum seeding (opsional)
        // DB::table('kat_lap_harian')->truncate();

        // Masukkan data ke tabel
        DB::table('kat_lap_harian')->insert($kategori);
    }
}
