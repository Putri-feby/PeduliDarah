<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DonationSchedule;
use App\Models\User;
use Faker\Factory as Faker;

class DummyEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil admin pertama atau buat jika tidak ada (meskipun biasanya sudah ada)
        $admin = User::where('role', 'admin')->orWhere('role', 'staff')->first();
        $adminId = $admin ? $admin->id : 1;

        $statuses = ['scheduled', 'upcoming', 'ongoing', 'completed', 'cancelled'];
        
        for ($i = 0; $i < 100; $i++) {
            $daysOffset = $faker->numberBetween(-30, 60);
            $startHour = $faker->numberBetween(7, 11);
            $duration = $faker->numberBetween(3, 6);
            
            // Generate start and end times
            $startTime = now()->addDays($daysOffset)->setTime($startHour, 0);
            $endTime = now()->addDays($daysOffset)->setTime($startHour + $duration, 0);
            
            // Determine logical status based on date
            $status = 'scheduled';
            if ($daysOffset < 0) {
                $status = $faker->randomElement(['completed', 'completed', 'cancelled']);
            } elseif ($daysOffset == 0) {
                $status = 'ongoing';
            } else {
                $status = $faker->randomElement(['upcoming', 'scheduled', 'scheduled']);
            }

            $maxDonors = $faker->numberBetween(30, 150);
            $currentDonors = $faker->numberBetween(0, $maxDonors);

            DonationSchedule::create([
                'title' => 'Kegiatan Donor Darah ' . $faker->company . ' ' . $faker->city,
                'description' => 'Kegiatan donor darah ini diselenggarakan oleh ' . $faker->company . '. ' . $faker->paragraph(3),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location' => $faker->address,
                'max_donors' => $maxDonors,
                'current_donors' => $currentDonors,
                'status' => $status,
                'admin_id' => $adminId,
                'event_type' => $faker->randomElement(['Publik', 'Instansi', 'Publik']),
            ]);
        }
    }
}
