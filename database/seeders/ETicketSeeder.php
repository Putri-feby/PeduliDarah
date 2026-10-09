<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ETicket;
use App\Models\DonationRegistration;
use Illuminate\Support\Str;

class ETicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrations = DonationRegistration::where('status', '!=', 'completed')->get();

        foreach ($registrations as $registration) {
            // Generate ticket code
            $ticketCode = 'TICKET-' . strtoupper(Str::random(8));
            
            // Generate QR code (dummy base64 data for now)
            $qrCode = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
            
            ETicket::create([
                'registration_id' => $registration->id,
                'ticket_code' => $ticketCode,
                'qr_code' => $qrCode,
                'status' => 'generated',
                'generated_at' => now(),
                'expires_at' => $registration->schedule->end_time,
            ]);
        }
    }
}
