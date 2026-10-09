<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DonationSchedule;

class EmptyEventSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'staff')->orWhere('role', 'admin')->first();

        DonationSchedule::create([
            'title' => 'Kegiatan Donor Darah (Masih Kosong)',
            'description' => 'Kegiatan donor darah ini masih kosong pendaftar, silakan mendaftar bagi yang memenuhi syarat.',
            'start_time' => now()->addDays(5)->setTime(8, 0),
            'end_time' => now()->addDays(5)->setTime(13, 0),
            'location' => 'PMI Pusat Jakarta',
            'max_donors' => 50,
            'current_donors' => 0,
            'status' => 'upcoming',
            'event_type' => 'Publik',
            'admin_id' => $admin ? $admin->id : 1,
        ]);
    }
}
