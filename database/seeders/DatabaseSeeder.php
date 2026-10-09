<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DonationScheduleSeeder::class,
            DonationRegistrationSeeder::class,
            ETicketSeeder::class,
            QueueSeeder::class,
            CollaborationSeeder::class,
        ]);
    }
}
