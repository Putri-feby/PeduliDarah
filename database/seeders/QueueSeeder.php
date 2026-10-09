<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Queue;
use App\Models\DonationRegistration;
use App\Models\DonationSchedule;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrations = DonationRegistration::where('status', '!=', 'completed')->get();
        
        foreach ($registrations as $registration) {
            // Get the highest queue number for this schedule
            $lastQueue = Queue::where('schedule_id', $registration->schedule_id)
                ->orderBy('queue_number', 'desc')
                ->first();
            
            $queueNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;
            
            // Random status for variety
            $statuses = ['waiting', 'called', 'serving'];
            $status = $statuses[array_rand($statuses)];
            
            Queue::create([
                'schedule_id' => $registration->schedule_id,
                'registration_id' => $registration->id,
                'queue_number' => $queueNumber,
                'status' => $status,
                'called_at' => $status === 'called' || $status === 'serving' ? now()->subMinutes(rand(5, 30)) : null,
                'serving_at' => $status === 'serving' ? now()->subMinutes(rand(1, 10)) : null,
                'completed_at' => null,
            ]);
        }
    }
}
