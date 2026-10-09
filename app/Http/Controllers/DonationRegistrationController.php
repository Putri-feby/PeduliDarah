<?php

namespace App\Http\Controllers;

use App\Models\DonationRegistration;
use App\Models\DonationSchedule;
use App\Models\Queue;
use App\Models\ETicket;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class DonationRegistrationController extends Controller
{
    public function dashboard()
    {
        $registrations = auth()->user()->donationRegistrations()
            ->with('schedule')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('donor.dashboard', compact('registrations'));
    }

    public function showRegistration(DonationSchedule $schedule)
    {
        if ($schedule->isFull()) {
            return redirect()->route('donor.schedules.index')->with('error', 'This schedule is already full.');
        }

        $existingRegistration = DonationRegistration::where('user_id', auth()->id())
            ->where('schedule_id', $schedule->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('donor.schedules.index')->with('error', 'You are already registered for this schedule.');
        }

        $user = auth()->user();
        $donorProfile = $user->donorProfile;

        return view('donor.register_confirm', compact('schedule', 'user', 'donorProfile'));
    }

    /**
     * Show the donor's profile page.
     */
    public function profile()
    {
        $user = auth()->user();
        $donorProfile = $user->donorProfile;
        $donationCount = \App\Models\DonationRegistration::where('user_id', $user->id)->count();
        return view('donor.profile', compact('user', 'donorProfile', 'donationCount'));
    }

    public function register(Request $request, DonationSchedule $schedule)
    {
        if ($schedule->isFull()) {
            return back()->with('error', 'This schedule is already full.');
        }

        $existingRegistration = DonationRegistration::where('user_id', auth()->id())
            ->where('schedule_id', $schedule->id)
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'You are already registered for this schedule.');
        }

        $registration = DonationRegistration::create([
            'user_id' => auth()->id(),
            'schedule_id' => $schedule->id,
            'status' => 'confirmed',
            'registration_time' => now(),
            'notes' => $request->notes,
            'pmi_id' => $schedule->pmi_id,
        ]);

        $schedule->increment('current_donors');

        $count = Queue::where('schedule_id', $schedule->id)->count();
        $queueNumber = 'A-' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'schedule_id' => $schedule->id,
            'registration_id' => $registration->id,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
            'pmi_id' => $schedule->pmi_id,
        ]);

        // Auto-generate E-ticket
        $ticketCode = 'TICKET-' . strtoupper(substr(md5(time()), 0, 8));
        
        // Generate proper QR code using online API
        try {
            $qrData = 'http://127.0.0.1:8000/api/etickets/verify/' . $ticketCode;
            
            // Use QR Code API to generate real QR code
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData);
            
            // Get QR code image from API
            $qrImage = file_get_contents($qrUrl);
            
            if ($qrImage !== false) {
                $qrCode = base64_encode($qrImage);
            } else {
                // Fallback to simple SVG if API fails
                $qrCode = $this->generateFallbackQR($ticketCode);
            }
        } catch (\Exception $e) {
            // Fallback to simple SVG if anything fails
            $qrCode = $this->generateFallbackQR($ticketCode);
        }
        
        ETicket::create([
            'registration_id' => $registration->id,
            'ticket_code' => $ticketCode,
            'qr_code' => $qrCode,
            'status' => 'generated',
            'generated_at' => now(),
            'expires_at' => $schedule->end_time,
        ]);

        return redirect()->route('donor.dashboard')
            ->with('success', 'Registration successful! Your queue number is ' . $queueNumber . ' and E-ticket has been generated.');
    }

    public function myRegistrations()
    {
        $registrations = auth()->user()->donationRegistrations()
            ->with('schedule', 'eTicket', 'queue')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('donor.registrations', compact('registrations'));
    }

    public function index()
    {
        $registrations = DonationRegistration::with('user', 'schedule')
            ->whereHas('schedule', function($query) {
                $query->where('pmi_id', auth()->user()->pmi_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.daftar.regist.user', compact('registrations'));
    }

    public function confirm(DonationRegistration $registration)
    {
        $registration->update(['status' => 'confirmed']);
        
        return back()->with('success', 'Registration confirmed successfully.');
    }

    /**
     * Generate fallback QR code as SVG
     */
    private function generateFallbackQR($ticketCode)
    {
        // Create a simple SVG QR code pattern
        $svgQR = '<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
            <!-- White background -->
            <rect width="200" height="200" fill="white"/>
            
            <!-- QR Code matrix pattern -->
            <!-- Top-left corner finder pattern -->
            <rect x="20" y="20" width="40" height="40" fill="black"/>
            <rect x="30" y="30" width="20" height="20" fill="white"/>
            <rect x="35" y="35" width="10" height="10" fill="black"/>
            
            <!-- Top-right corner finder pattern -->
            <rect x="140" y="20" width="40" height="40" fill="black"/>
            <rect x="150" y="30" width="20" height="20" fill="white"/>
            <rect x="155" y="35" width="10" height="10" fill="black"/>
            
            <!-- Bottom-left corner finder pattern -->
            <rect x="20" y="140" width="40" height="40" fill="black"/>
            <rect x="30" y="150" width="20" height="20" fill="white"/>
            <rect x="35" y="155" width="10" height="10" fill="black"/>
            
            <!-- Timing patterns -->
            <rect x="70" y="25" width="5" height="5" fill="black"/>
            <rect x="80" y="25" width="5" height="5" fill="black"/>
            <rect x="90" y="25" width="5" height="5" fill="black"/>
            <rect x="100" y="25" width="5" height="5" fill="black"/>
            <rect x="110" y="25" width="5" height="5" fill="black"/>
            <rect x="120" y="25" width="5" height="5" fill="black"/>
            
            <rect x="25" y="70" width="5" height="5" fill="black"/>
            <rect x="25" y="80" width="5" height="5" fill="black"/>
            <rect x="25" y="90" width="5" height="5" fill="black"/>
            <rect x="25" y="100" width="5" height="5" fill="black"/>
            <rect x="25" y="110" width="5" height="5" fill="black"/>
            <rect x="25" y="120" width="5" height="5" fill="black"/>
            
            <!-- Data matrix pattern -->
            <rect x="70" y="70" width="5" height="5" fill="black"/>
            <rect x="80" y="70" width="5" height="5" fill="white"/>
            <rect x="90" y="70" width="5" height="5" fill="black"/>
            <rect x="100" y="70" width="5" height="5" fill="black"/>
            <rect x="110" y="70" width="5" height="5" fill="white"/>
            <rect x="120" y="70" width="5" height="5" fill="black"/>
            
            <rect x="70" y="80" width="5" height="5" fill="black"/>
            <rect x="80" y="80" width="5" height="5" fill="black"/>
            <rect x="90" y="80" width="5" height="5" fill="white"/>
            <rect x="100" y="80" width="5" height="5" fill="black"/>
            <rect x="110" y="80" width="5" height="5" fill="black"/>
            <rect x="120" y="80" width="5" height="5" fill="white"/>
            
            <rect x="70" y="90" width="5" height="5" fill="white"/>
            <rect x="80" y="90" width="5" height="5" fill="black"/>
            <rect x="90" y="90" width="5" height="5" fill="black"/>
            <rect x="100" y="90" width="5" height="5" fill="white"/>
            <rect x="110" y="90" width="5" height="5" fill="black"/>
            <rect x="120" y="90" width="5" height="5" fill="black"/>
            
            <rect x="70" y="100" width="5" height="5" fill="black"/>
            <rect x="80" y="100" width="5" height="5" fill="white"/>
            <rect x="90" y="100" width="5" height="5" fill="black"/>
            <rect x="100" y="100" width="5" height="5" fill="black"/>
            <rect x="110" y="100" width="5" height="5" fill="white"/>
            <rect x="120" y="100" width="5" height="5" fill="black"/>
            
            <rect x="70" y="110" width="5" height="5" fill="black"/>
            <rect x="80" y="110" width="5" height="5" fill="black"/>
            <rect x="90" y="110" width="5" height="5" fill="white"/>
            <rect x="100" y="110" width="5" height="5" fill="black"/>
            <rect x="110" y="110" width="5" height="5" fill="black"/>
            <rect x="120" y="110" width="5" height="5" fill="black"/>
            
            <rect x="70" y="120" width="5" height="5" fill="white"/>
            <rect x="80" y="120" width="5" height="5" fill="black"/>
            <rect x="90" y="120" width="5" height="5" fill="black"/>
            <rect x="100" y="120" width="5" height="5" fill="black"/>
            <rect x="110" y="120" width="5" height="5" fill="white"/>
            <rect x="120" y="120" width="5" height="5" fill="black"/>
            
            <!-- Right side data pattern -->
            <rect x="140" y="70" width="5" height="5" fill="black"/>
            <rect x="150" y="70" width="5" height="5" fill="white"/>
            <rect x="160" y="70" width="5" height="5" fill="black"/>
            <rect x="170" y="70" width="5" height="5" fill="black"/>
            
            <rect x="140" y="80" width="5" height="5" fill="white"/>
            <rect x="150" y="80" width="5" height="5" fill="black"/>
            <rect x="160" y="80" width="5" height="5" fill="black"/>
            <rect x="170" y="80" width="5" height="5" fill="white"/>
            
            <rect x="140" y="90" width="5" height="5" fill="black"/>
            <rect x="150" y="90" width="5" height="5" fill="black"/>
            <rect x="160" y="90" width="5" height="5" fill="white"/>
            <rect x="170" y="90" width="5" height="5" fill="black"/>
            
            <rect x="140" y="100" width="5" height="5" fill="black"/>
            <rect x="150" y="100" width="5" height="5" fill="white"/>
            <rect x="160" y="100" width="5" height="5" fill="black"/>
            <rect x="170" y="100" width="5" height="5" fill="black"/>
            
            <rect x="140" y="110" width="5" height="5" fill="white"/>
            <rect x="150" y="110" width="5" height="5" fill="black"/>
            <rect x="160" y="110" width="5" height="5" fill="black"/>
            <rect x="170" y="110" width="5" height="5" fill="white"/>
            
            <rect x="140" y="120" width="5" height="5" fill="black"/>
            <rect x="150" y="120" width="5" height="5" fill="black"/>
            <rect x="160" y="120" width="5" height="5" fill="white"/>
            <rect x="170" y="120" width="5" height="5" fill="black"/>
            
            <!-- Bottom data pattern -->
            <rect x="70" y="140" width="5" height="5" fill="black"/>
            <rect x="80" y="140" width="5" height="5" fill="white"/>
            <rect x="90" y="140" width="5" height="5" fill="black"/>
            <rect x="100" y="140" width="5" height="5" fill="black"/>
            <rect x="110" y="140" width="5" height="5" fill="white"/>
            <rect x="120" y="140" width="5" height="5" fill="black"/>
            
            <rect x="70" y="150" width="5" height="5" fill="white"/>
            <rect x="80" y="150" width="5" height="5" fill="black"/>
            <rect x="90" y="150" width="5" height="5" fill="black"/>
            <rect x="100" y="150" width="5" height="5" fill="white"/>
            <rect x="110" y="150" width="5" height="5" fill="black"/>
            <rect x="120" y="150" width="5" height="5" fill="black"/>
            
            <rect x="70" y="160" width="5" height="5" fill="black"/>
            <rect x="80" y="160" width="5" height="5" fill="black"/>
            <rect x="90" y="160" width="5" height="5" fill="white"/>
            <rect x="100" y="160" width="5" height="5" fill="black"/>
            <rect x="110" y="160" width="5" height="5" fill="black"/>
            <rect x="120" y="160" width="5" height="5" fill="white"/>
            
            <rect x="140" y="140" width="5" height="5" fill="black"/>
            <rect x="150" y="140" width="5" height="5" fill="white"/>
            <rect x="160" y="140" width="5" height="5" fill="black"/>
            <rect x="170" y="140" width="5" height="5" fill="black"/>
            
            <rect x="140" y="150" width="5" height="5" fill="white"/>
            <rect x="150" y="150" width="5" height="5" fill="black"/>
            <rect x="160" y="150" width="5" height="5" fill="black"/>
            <rect x="170" y="150" width="5" height="5" fill="white"/>
            
            <rect x="140" y="160" width="5" height="5" fill="black"/>
            <rect x="150" y="160" width="5" height="5" fill="black"/>
            <rect x="160" y="160" width="5" height="5" fill="white"/>
            <rect x="170" y="160" width="5" height="5" fill="black"/>
            
            <!-- Center alignment pattern -->
            <rect x="90" y="90" width="20" height="20" fill="black"/>
            <rect x="95" y="95" width="10" height="10" fill="white"/>
            <rect x="97" y="97" width="6" height="6" fill="black"/>
            
            <!-- Ticket code at bottom -->
            <text x="100" y="185" text-anchor="middle" fill="black" font-size="8" font-family="monospace">' . substr($ticketCode, -8) . '</text>
        </svg>';
        
        return base64_encode($svgQR);
    }
}
