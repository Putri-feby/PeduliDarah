<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collaboration;
use App\Models\User;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $collaborations = [
            [
                'organization_name' => 'PT. Sehat Selalu',
                'contact_person' => 'Dr. Budi Wijaya',
                'contact_email' => 'budi.wijaya@sehat.com',
                'contact_phone' => '081234567891',
                'proposal_description' => 'Kami ingin mengadakan donor darah rutin setiap 3 bulan untuk karyawan kami. Perusahaan memiliki 500 karyawan dan target kami adalah 100 pendonor per kegiatan. Kami menyediakan lokasi, konsumsi, dan fasilitas pendukung.',
                'status' => 'approved',
                'proposed_date' => now()->addDays(21),
                'location' => 'Kantor PT. Sehat Selalu, Jakarta Selatan',
                'expected_donors' => 100,
                'admin_notes' => 'Disetujui untuk jangka panjang. Jadwalkan setiap kuartal.',
                'admin_id' => $admin->id,
            ],
            [
                'organization_name' => 'Universitas Teknologi Indonesia',
                'contact_person' => 'Prof. Siti Aminah',
                'contact_email' => 'siti.aminah@uti.ac.id',
                'contact_phone' => '081234567892',
                'proposal_description' => 'Program donor darah mahasiswa dalam rangka Dies Natalis ke-50 universitas. Target 200 pendonor dari mahasiswa dan dosen. Kegiatan akan disiarkan langsung melalui YouTube.',
                'status' => 'under_review',
                'proposed_date' => now()->addDays(14),
                'location' => 'Kampus UTI, Jakarta',
                'expected_donors' => 200,
                'admin_notes' => 'Perlu koordinasi lebih lanjut mengenai teknis acara.',
                'admin_id' => $admin->id,
            ],
            [
                'organization_name' => 'Komunitas Peduli Sosial',
                'contact_person' => 'Andi Kusuma',
                'contact_email' => 'andi.kusuma@peduli.org',
                'contact_phone' => '081234567893',
                'proposal_description' => 'Aksi donor darah komunitas untuk membantu korban bencana di daerah. Target 50 pendonor. Kami akan bekerja sama dengan PMI setempat.',
                'status' => 'pending',
                'proposed_date' => now()->addDays(7),
                'location' => 'Posko Bantuan, Tangerang',
                'expected_donors' => 50,
                'admin_notes' => 'Menunggu konfirmasi dari PMI setempat.',
                'admin_id' => $admin->id,
            ],
            [
                'organization_name' => 'Mall Century Plaza',
                'contact_person' => 'Marketing Manager',
                'contact_email' => 'marketing@centuryplaza.com',
                'contact_phone' => '081234567894',
                'proposal_description' => 'Event donor darah spesial weekend dengan hadiah menarik. Target 150 pendonor. Mall menyediakan lokasi strategis dan promosi.',
                'status' => 'approved',
                'proposed_date' => now()->addDays(28),
                'location' => 'Mall Century Plaza, Jakarta',
                'expected_donors' => 150,
                'admin_notes' => 'Event besar perlu persiapan khusus.',
                'admin_id' => $admin->id,
            ],
            [
                'organization_name' => 'RS. Kasih Ibu',
                'contact_person' => 'Direktur RS. Dr. Harianto',
                'contact_email' => 'direktur@kasihibu.com',
                'contact_phone' => '081234567895',
                'proposal_description' => 'Donor darah rutin rumah sakit untuk menjaga ketersediaan darah. Target 30 pendonor per minggu. RS menyediakan semua fasilitas medis.',
                'status' => 'rejected',
                'proposed_date' => now()->subDays(5),
                'location' => 'RS. Kasih Ibu, Bekasi',
                'expected_donors' => 30,
                'admin_notes' => 'Lokasi terlalu jauh dan sasaran pendonor terbatas.',
                'admin_id' => $admin->id,
            ],
        ];

        foreach ($collaborations as $collaboration) {
            Collaboration::create($collaboration);
        }
    }
}
