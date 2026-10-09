<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DonationSchedule;
use App\Models\DonationRegistration;
use App\Models\DonorProfile;
use Illuminate\Support\Facades\Hash;

class FullEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Get an admin/staff
        $admin = User::where('role', 'staff')->orWhere('role', 'admin')->first();

        // 2. Create a schedule that is full
        $schedule = DonationSchedule::create([
            'title' => 'Kegiatan Donor Darah Spesial (Kuota Penuh)',
            'description' => 'Kegiatan donor darah ini khusus dibuat untuk simulasi kuota penuh. Tidak bisa menerima pendaftar baru.',
            'start_time' => now()->addDays(2)->setTime(9, 0),
            'end_time' => now()->addDays(2)->setTime(14, 0),
            'location' => 'PMI Pusat Jakarta',
            'max_donors' => 10,
            'current_donors' => 10,
            'status' => 'upcoming',
            'event_type' => 'Publik',
            'admin_id' => $admin ? $admin->id : 1,
        ]);

        // 3. Create 10 donors
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'nama_lengkap' => 'Donor Dummy ' . $i,
                'email' => 'donor_full_' . $i . '@dummy.com',
                'no_telp' => '0812000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'jenis_kelamin' => $i % 2 == 0 ? 'pria' : 'wanita',
                'nik' => '31700000000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'tanggal_lahir' => '1990-01-0' . ($i % 9 + 1),
                'password' => Hash::make('password123'),
                'role' => 'donor',
            ]);

            // Create DonorProfile
            DonorProfile::create([
                'user_id' => $user->id,
                'golongan_darah' => ['A', 'B', 'AB', 'O'][array_rand(['A', 'B', 'AB', 'O'])],
                'rhesus' => '+',
                'pernah_donor' => false,
            ]);

            // Create registrations
            DonationRegistration::create([
                'user_id' => $user->id,
                'schedule_id' => $schedule->id,
                'status' => 'registered',
                'registration_time' => now()->subHours(rand(1, 48)),
                'notes' => 'Pendaftaran simulasi kuota penuh',
            ]);
        }
    }
}
