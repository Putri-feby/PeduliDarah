<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collaboration;
use App\Models\User;

class DummyCollaborationSeeder extends Seeder
{
    /**
     * Buat data dummy kolaborasi yang ditujukan ke admin PMI Kota Tangerang
     * (adminpeduli@gmail.com, pmi_id = "PMI Kota Tangerang")
     */
    public function run(): void
    {
        $admin = User::where('email', 'adminpeduli@gmail.com')->first();

        if (!$admin) {
            $this->command->error('Admin dengan email adminpeduli@gmail.com tidak ditemukan!');
            return;
        }

        $pmiId = $admin->pmi_id; // "PMI Kota Tangerang"

        $collaborations = [
            // --- Pengajuan via form donor (menggunakan kolom email / name) ---
            [
                'name'              => 'SMA Negeri 5 Tangerang',
                'pic_name'          => 'Bapak Hendra Saputra',
                'email'             => 'hendra.saputra@sman5tng.sch.id',
                'phone'             => '082198765401',
                'organization_type' => 'Sekolah',
                'address'           => 'Jl. Merdeka No. 10, Tangerang',
                'event_name'        => 'Donor Darah HUT Sekolah ke-35',
                'proposed_date'     => now()->addDays(12)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Aula SMA Negeri 5 Tangerang',
                'maps_link'         => 'https://maps.google.com/?q=SMA+Negeri+5+Tangerang',
                'estimated_donors'  => '80',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'pending',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
            ],
            [
                'name'              => 'PT. Maju Bersama Indonesia',
                'pic_name'          => 'Ibu Rina Kusumawati',
                'email'             => 'rina.kusumawati@majubersama.co.id',
                'phone'             => '081345678920',
                'organization_type' => 'Perusahaan',
                'address'           => 'Kawasan Industri Jatake, Tangerang',
                'event_name'        => 'Bakti Sosial Donor Darah Hari Buruh',
                'proposed_date'     => now()->addDays(20)->format('Y-m-d'),
                'proposed_time'     => '09:00',
                'location'          => 'Gedung Serbaguna PT. Maju Bersama Indonesia',
                'maps_link'         => 'https://maps.google.com/?q=PT+Maju+Bersama+Jatake',
                'estimated_donors'  => '120',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'under_review',
                'pmi_id'            => $pmiId,
                'type'              => 'company',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Sedang diverifikasi kapasitas gedung dan jumlah target pendonor.',
            ],
            [
                'name'              => 'Universitas Pamulang Kampus Tangerang',
                'pic_name'          => 'Dr. Ahmad Fauzi',
                'email'             => 'ahmad.fauzi@unpam.ac.id',
                'phone'             => '087765432109',
                'organization_type' => 'Universitas',
                'address'           => 'Jl. Surya Kencana No. 1, Pamulang, Tangerang Selatan',
                'event_name'        => 'Pekan Donor Darah Mahasiswa 2026',
                'proposed_date'     => now()->addDays(35)->format('Y-m-d'),
                'proposed_time'     => '07:30',
                'location'          => 'Student Center Unpam',
                'maps_link'         => 'https://maps.google.com/?q=Universitas+Pamulang',
                'estimated_donors'  => '250',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'approved',
                'pmi_id'            => $pmiId,
                'type'              => 'university',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Disetujui. Jadwalkan koordinasi teknis 2 minggu sebelum acara.',
            ],
            [
                'name'              => 'Komunitas Pemuda Tangerang Bergerak',
                'pic_name'          => 'Sdr. Rizky Ramadhan',
                'email'             => 'rizky.ramadhan@pemudatng.org',
                'phone'             => '089654321078',
                'organization_type' => 'Komunitas',
                'address'           => 'Jl. Cikokol Raya No. 5, Tangerang',
                'event_name'        => 'Aksi Nyata Generasi Muda – Donor Darah Serentak',
                'proposed_date'     => now()->addDays(8)->format('Y-m-d'),
                'proposed_time'     => '08:30',
                'location'          => 'Lapangan Maulana Yusuf, Tangerang',
                'maps_link'         => null,
                'estimated_donors'  => '60',
                'has_room'          => false,
                'has_furniture'     => false,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'pending',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
            ],
            [
                'name'              => 'Masjid Al-Ikhlas Perumnas II',
                'pic_name'          => 'Ust. Mansyur Hakim',
                'email'             => 'mansyur.hakim@alikhlas.org',
                'phone'             => '081287654398',
                'organization_type' => 'Organisasi Keagamaan',
                'address'           => 'Perumnas II, Karawaci, Tangerang',
                'event_name'        => 'Donor Darah Ramadan – Berbagi Kehidupan',
                'proposed_date'     => now()->addDays(45)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Halaman Masjid Al-Ikhlas Perumnas II',
                'maps_link'         => 'https://maps.google.com/?q=Masjid+Al-Ikhlas+Perumnas+II+Tangerang',
                'estimated_donors'  => '40',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => false,
                'event_type'        => 'Publik',
                'status'            => 'rejected',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Ditolak sementara karena jadwal bentrok dengan kegiatan PMI lain. Silakan ajukan ulang untuk bulan berikutnya.',
            ],
            [
                'name'              => 'Rumah Sakit Siloam Tangerang',
                'pic_name'          => 'dr. Carla Dewi, Sp.PD',
                'email'             => 'carla.dewi@siloam.co.id',
                'phone'             => '021-55789900',
                'organization_type' => 'Rumah Sakit',
                'address'           => 'Jl. M.H. Thamrin No. 3, Tangerang',
                'event_name'        => 'Donor Darah Rutin Bulanan Siloam',
                'proposed_date'     => now()->addDays(15)->format('Y-m-d'),
                'proposed_time'     => '09:00',
                'location'          => 'Lobby RS Siloam Tangerang',
                'maps_link'         => 'https://maps.google.com/?q=RS+Siloam+Tangerang',
                'estimated_donors'  => '75',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'under_review',
                'pmi_id'            => $pmiId,
                'type'              => 'hospital',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Menunggu kelengkapan dokumen MOU dengan pihak RS.',
            ],
        ];

        foreach ($collaborations as $data) {
            Collaboration::create($data);
        }

        $this->command->info('✅ Berhasil membuat ' . count($collaborations) . ' data dummy kolaborasi untuk admin ' . $admin->email . ' (PMI: ' . $pmiId . ')');
    }
}
