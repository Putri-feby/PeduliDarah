<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DonationSchedule;
use App\Models\User;

class DonationScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $schedules = [
            [
                'title' => 'Donor Darah Rutin - RSUD Jakarta',
                'description' => 'Kegiatan donor darah rutin bulanan yang diselenggarakan oleh RSUD Jakarta bekerja sama dengan PMI. Mari berpartisipasi untuk membantu pasien yang membutuhkan darah.',
                'start_time' => now()->addDays(3)->setTime(8, 0),
                'end_time' => now()->addDays(3)->setTime(14, 0),
                'location' => 'RSUD Jakarta, Jl. Sudirman No. 123, Jakarta Pusat',
                'max_donors' => 50,
                'current_donors' => 12,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
            [
                'title' => 'Blood Drive - Universitas Indonesia',
                'description' => 'Program donor darah mahasiswa UI dalam rangka memperingati Hari Kesehatan Nasional. Terbuka untuk umum.',
                'start_time' => now()->addDays(7)->setTime(9, 0),
                'end_time' => now()->addDays(7)->setTime(15, 0),
                'location' => 'Gedung Student Center UI, Depok',
                'max_donors' => 100,
                'current_donors' => 45,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
            [
                'title' => 'Donor Darah Emergency - PMI Bandung',
                'description' => 'Kebutuhan darah mendesak untuk rumah sakit di area Bandung. Stok darah menipis, dibutuhkan bantuan segera.',
                'start_time' => now()->addDays(1)->setTime(10, 0),
                'end_time' => now()->addDays(1)->setTime(16, 0),
                'location' => 'Kantor PMI Bandung, Jl. Aceh No. 45',
                'max_donors' => 30,
                'current_donors' => 28,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
            [
                'title' => 'Corporate Blood Drive - PT. Teknologi Maju',
                'description' => 'Program donor darah karyawan PT. Teknologi Maju sebagai bagian dari CSR perusahaan.',
                'start_time' => now()->addDays(10)->setTime(8, 30),
                'end_time' => now()->addDays(10)->setTime(13, 30),
                'location' => 'Kantor Pusat PT. Teknologi Maju, Jakarta Selatan',
                'max_donors' => 40,
                'current_donors' => 15,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
            [
                'title' => 'Komunitas Donor Darah - Surabaya',
                'description' => 'Aksi donor darah komunitas Surabaya Care. Mari bersama-sama membantu sesama.',
                'start_time' => now()->addDays(14)->setTime(7, 0),
                'end_time' => now()->addDays(14)->setTime(12, 0),
                'location' => 'Balai Kota Surabaya, Jl. Tunjungan No. 1',
                'max_donors' => 60,
                'current_donors' => 8,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
            [
                'title' => 'Donor Darah Berhadiah - Mall Central Park',
                'description' => 'Donor darah spesial dengan hadiah menarik dari sponsor. Setiap pendonor mendapatkan goodie bag dan voucher.',
                'start_time' => now()->addDays(5)->setTime(10, 0),
                'end_time' => now()->addDays(5)->setTime(18, 0),
                'location' => 'Mall Central Park, Jakarta Barat',
                'max_donors' => 80,
                'current_donors' => 35,
                'status' => 'scheduled',
                'admin_id' => $admin->id,
            ],
        ];

        foreach ($schedules as $schedule) {
            DonationSchedule::create($schedule);
        }
    }
}
