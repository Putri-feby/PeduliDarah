<?php

namespace App\Http\Controllers;

use App\Models\DonationSchedule;
use Illuminate\Http\Request;

class DonationScheduleController extends Controller
{
    public function index()
    {
        // Auto-update status to ongoing if start time has passed
        DonationSchedule::where('pmi_id', auth()->user()->pmi_id)
            ->where('status', 'upcoming')
            ->whereRaw("TIMESTAMP(date, start_time) <= ?", [now()])
            ->update(['status' => 'ongoing']);

        $schedules = DonationSchedule::withCount('donationRegistrations')
            ->where('pmi_id', auth()->user()->pmi_id)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function donorIndex()
    {
        DonationSchedule::where('status', 'upcoming')
            ->whereRaw("TIMESTAMP(date, start_time) <= ?", [now()])
            ->update(['status' => 'ongoing']);

        $schedules = DonationSchedule::whereRaw("TIMESTAMP(date, end_time) > ?", [now()])
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->where('event_type', 'Publik')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
            
        return view('donor.schedules', compact('schedules'));
    }

    public function verifyInvite(Request $request)
    {
        $request->validate([
            'invitation_code' => 'required|string',
        ]);

        $schedule = DonationSchedule::where('invitation_code', $request->invitation_code)
            ->where('event_type', 'Private')
            ->whereRaw("TIMESTAMP(date, end_time) > ?", [now()])
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->first();

        if (!$schedule) {
            return back()->with('error', 'Kode undangan tidak valid atau jadwal sudah tidak tersedia.');
        }

        return redirect()->route('donor.register.show', $schedule->id)
            ->with('success', 'Kode undangan valid! Silakan mendaftar untuk jadwal private ini.');
    }



    public function create(Request $request)
    {
        $collaboration = null;
        if ($request->has('collaboration_id')) {
            $collaboration = \App\Models\Collaboration::findOrFail($request->collaboration_id);
        }
        return view('admin.schedules.create', compact('collaboration'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_donors' => 'required|integer|min:1',
            'event_type' => 'required|in:Publik,Private',
            'collaboration_id' => 'nullable|exists:collaborations,id',
        ]);

        $invitationCode = null;
        if ($request->event_type === 'Private') {
            $invitationCode = \Illuminate\Support\Str::random(8);
        }

        DonationSchedule::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => \Carbon\Carbon::parse($request->start_time)->toDateString(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'max_donors' => $request->max_donors,
            'event_type' => $request->event_type,
            'collaboration_id' => $request->collaboration_id,
            'invitation_code' => $invitationCode,
            'admin_id' => auth()->id(),
            'pmi_id' => auth()->user()->pmi_id,
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Donation schedule created successfully.');
    }

    public function edit(DonationSchedule $schedule)
    {
        if ($schedule->pmi_id !== auth()->user()->pmi_id) {
            abort(403, 'Unauthorized');
        }

        $readOnly = $schedule->status === 'completed';

        return view('admin.schedules.edit', compact('schedule', 'readOnly'));
    }

    public function update(Request $request, DonationSchedule $schedule)
    {
        if ($schedule->pmi_id !== auth()->user()->pmi_id) {
            abort(403, 'Unauthorized');
        }

        if ($schedule->status === 'completed') {
            return redirect()->route('admin.schedules.index')
                ->with('error', 'Jadwal yang sudah selesai tidak dapat diedit.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_donors' => 'required|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $schedule->update($request->all());

        if ($request->status === 'completed') {
            \App\Models\Queue::where('schedule_id', $schedule->id)
                ->where('status', 'skipped')
                ->update(['status' => 'failed']);
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Donation schedule updated successfully.');
    }

    public function destroy(DonationSchedule $schedule)
    {
        if ($schedule->pmi_id !== auth()->user()->pmi_id) {
            abort(403, 'Unauthorized');
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Donation schedule deleted successfully.');
    }
}
