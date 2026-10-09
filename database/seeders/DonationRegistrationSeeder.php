<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DonationRegistration;
use App\Models\User;
use App\Models\DonationSchedule;

class DonationRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donors = User::where('role', 'donor')->get();
        $schedules = DonationSchedule::all();

        // Create some registrations
        $registrations = [
            [
                'user_id' => $donors[0]->id, // Ahmad Rizki
                'schedule_id' => $schedules[0]->id, // RSUD Jakarta
                'status' => 'confirmed',
                'registration_time' => now()->subDays(2),
                'notes' => 'Pendonor rutin, golongan darah A',
            ],
            [
                'user_id' => $donors[1]->id, // Siti Nurhaliza
                'schedule_id' => $schedules[1]->id, // Universitas Indonesia
                'status' => 'registered',
                'registration_time' => now()->subDays(1),
                'notes' => 'Pertama kali donor, golongan darah B',
            ],
            [
                'user_id' => $donors[2]->id, // Budi Santoso
                'schedule_id' => $schedules[2]->id, // PMI Bandung
                'status' => 'confirmed',
                'registration_time' => now()->subHours(6),
                'notes' => 'Pendonor rutin, golongan darah O',
            ],
            [
                'user_id' => $donors[3]->id, // Dewi Lestari
                'schedule_id' => $schedules[3]->id, // PT. Teknologi Maju
                'status' => 'registered',
                'registration_time' => now()->subHours(12),
                'notes' => 'Pendonor rutin, golongan darah AB',
            ],
            [
                'user_id' => $donors[4]->id, // Eko Prasetyo
                'schedule_id' => $schedules[4]->id, // Komunitas Surabaya
                'status' => 'registered',
                'registration_time' => now()->subHours(3),
                'notes' => 'Pendonor rutin, golongan darah A',
            ],
            [
                'user_id' => $donors[0]->id, // Ahmad Rizki lagi
                'schedule_id' => $schedules[5]->id, // Mall Central Park
                'status' => 'registered',
                'registration_time' => now()->subHours(8),
                'notes' => 'Ikut program donor darah berhadiah',
            ],
            [
                'user_id' => $donors[1]->id, // Siti Nurhaliza lagi
                'schedule_id' => $schedules[0]->id, // RSUD Jakarta
                'status' => 'completed',
                'registration_time' => now()->subDays(10),
                'notes' => 'Sudah melakukan donor darah',
            ],
            [
                'user_id' => $donors[2]->id, // Budi Santoso lagi
                'schedule_id' => $schedules[1]->id, // Universitas Indonesia
                'status' => 'registered',
                'registration_time' => now()->subHours(15),
                'notes' => 'Mewakili teman yang tidak bisa hadir',
            ],
        ];

        foreach ($registrations as $registration) {
            DonationRegistration::create($registration);
        }
    }
}
