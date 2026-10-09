<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use App\Models\DonationRegistration;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ETicketController extends Controller
{
    public function donorTicketsIndex()
    {
        $tickets = ETicket::whereHas('registration', function($query) {
            $query->where('user_id', auth()->id());
        })
        ->with('registration.schedule')
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('donor.tickets.index', compact('tickets'));
    }
    
    public function donorTicketShow(ETicket $ticket)
    {
        // Verify ownership
        if ($ticket->registration->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('donor.tickets.show', compact('ticket'));
    }

    public function generate(Request $request, DonationRegistration $registration)
    {
        if ($registration->eTicket) {
            return back()->with('error', 'E-ticket already generated for this registration.');
        }

        $ticketCode = 'TICKET-' . strtoupper(Str::random(8));
        
        // Generate QR code using SVG format (no GD extension required)
        try {
            $qrData = route('etickets.verify', $ticketCode);
            $qrCode = base64_encode(QrCode::format('svg')->size(200)->generate($qrData));
        } catch (\Exception $e) {
            // Fallback to null if QR generation fails
            $qrCode = null;
        }
        
        $eTicket = ETicket::create([
            'registration_id' => $registration->id,
            'ticket_code' => $ticketCode,
            'qr_code' => $qrCode,
            'status' => 'generated',
            'generated_at' => now(),
            'expires_at' => $registration->schedule->end_time,
        ]);

        return back()->with('success', 'E-ticket generated successfully!');
    }

    public function show(DonationRegistration $registration)
    {
        if (!$registration->eTicket) {
            return back()->with('error', 'E-ticket not yet generated.');
        }

        return view('donor.eticket', compact('registration'));
    }

    public function printFormulir(DonationRegistration $registration)
    {
        $registration->load('user', 'schedule', 'eTicket');
        return view('donor.formulir-print', compact('registration'));
    }

    public function index()
    {
        $eTickets = ETicket::with('registration.user', 'registration.schedule')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.etickets', compact('eTickets'));
    }

    public function scan(Request $request, ETicket $eTicket)
    {
        if ($eTicket->isExpired()) {
            return back()->with('error', 'E-ticket has expired.');
        }

        if ($eTicket->isScanned()) {
            return back()->with('error', 'E-ticket has already been used.');
        }

        $eTicket->update([
            'status' => 'scanned',
            'scanned_at' => now(),
        ]);

        return back()->with('success', 'E-ticket scanned successfully!');
    }

    public function verify($ticketCode)
    {
        $eTicket = ETicket::where('ticket_code', $ticketCode)->first();
        
        if (!$eTicket) {
            return response()->json(['valid' => false, 'message' => 'Invalid ticket code']);
        }

        if ($eTicket->isExpired()) {
            return response()->json(['valid' => false, 'message' => 'Ticket expired']);
        }

        if ($eTicket->isScanned()) {
            return response()->json(['valid' => false, 'message' => 'Ticket already used']);
        }

        return response()->json([
            'valid' => true,
            'ticket' => [
                'code' => $eTicket->ticket_code,
                'user' => $eTicket->registration->user->nama_lengkap,
                'schedule' => $eTicket->registration->schedule->title,
                'date' => $eTicket->registration->schedule->start_time->format('Y-m-d H:i'),
                'location' => $eTicket->registration->schedule->location,
            ]
        ]);
    }

    /**
     * Display the ticket scanning interface for admin
     */
    public function scanInterface()
    {
        return view('admin.tickets.scan');
    }

    /**
     * Verify ticket by ticket code for admin scanning
     */
    public function scanVerify(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string|max:255'
        ]);

        $ticketCode = $request->input('ticket_code');
        
        // Remove TICKET- prefix if present
        if (str_starts_with($ticketCode, 'TICKET-')) {
            $ticketCode = substr($ticketCode, 7);
        }

        $ticket = ETicket::with(['registration.user', 'registration.schedule'])
            ->where('ticket_code', 'TICKET-' . $ticketCode)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan. Silakan periksa kembali kode tiket.'
            ], 404);
        }

        // Check if ticket is expired
        if ($ticket->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah kadaluarsa. Tidak dapat digunakan.'
            ], 400);
        }

        // Check if ticket is already used
        if ($ticket->isScanned()) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah digunakan pada ' . $ticket->scanned_at->format('d M Y H:i')
            ], 400);
        }

        // Mark ticket as scanned
        $ticket->update([
            'status' => 'scanned',
            'scanned_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil diverifikasi!',
            'ticket' => [
                'code' => $ticket->ticket_code,
                'user_name' => $ticket->registration->user->nama_lengkap,
                'user_email' => $ticket->registration->user->email,
                'event_title' => $ticket->registration->schedule->title,
                'event_location' => $ticket->registration->schedule->location,
                'event_date' => $ticket->registration->schedule->start_time->format('l, F j, Y'),
                'event_time' => $ticket->registration->schedule->start_time->format('H:i') . ' - ' . $ticket->registration->schedule->end_time->format('H:i'),
                'queue_number' => $ticket->registration->queue->queue_number ?? 'Belum ada',
                'scanned_at' => $ticket->scanned_at->format('d M Y H:i')
            ]
        ]);
    }

    /**
     * Display scan history
     */
    public function scanHistory()
    {
        $scannedTickets = ETicket::with(['registration.user', 'registration.schedule'])
            ->where('status', 'scanned')
            ->orWhere('status', 'used')
            ->orderBy('scanned_at', 'desc')
            ->paginate(20);

        return view('admin.tickets.history', compact('scannedTickets'));
    }

    /**
     * Get recent scan statistics
     */
    public function scanStats()
    {
        $today = now()->startOfDay();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        $stats = [
            'today' => ETicket::where('scanned_at', '>=', $today)->count(),
            'this_week' => ETicket::where('scanned_at', '>=', $thisWeek)->count(),
            'this_month' => ETicket::where('scanned_at', '>=', $thisMonth)->count(),
            'total' => ETicket::where('status', 'scanned')->orWhere('status', 'used')->count()
        ];

        return response()->json($stats);
    }
}
