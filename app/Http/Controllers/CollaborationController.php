<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    public function create()
    {
        return view('collaborations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'proposal_description' => 'required|string',
            'proposed_date' => 'required|date|after:today',
            'location' => 'nullable|string|max:255',
            'expected_donors' => 'nullable|integer|min:1',
        ]);

        Collaboration::create(array_merge($request->all(), [
            'pmi_id' => auth()->user()->pmi_id,
        ]));

        return redirect()->route('collaborations.create')
            ->with('success', 'Collaboration request submitted successfully!');
    }

    /**
     * Show collaboration request form for donors
     */
    public function donorRequest()
    {
        \App\Models\Pmi::firstOrCreate(['name' => 'PMI Tangerang Selatan']);
        \App\Models\Pmi::firstOrCreate(['name' => 'PMI Kota Tangerang Selatan']);
        $pmis = \App\Models\Pmi::orderBy('name')->pluck('name');
        return view('donor.collaboration-request', compact('pmis'));
    }

    /**
     * Store collaboration request from donor
     */
    public function storeDonorRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'organization_type' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'event_name' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|string|max:500',
            'estimated_donors' => 'required|string',
            'has_room' => 'required|boolean',
            'has_furniture' => 'required|boolean',
            'has_electricity' => 'required|boolean',
            'has_parking' => 'required|boolean',
            'event_type' => 'required|in:Publik,Private',
            'pmi_id' => 'required|string',
        ]);

        // Map form fields to database columns
        $collaborationData = [
            'name' => $request->name,
            'pic_name' => $request->pic_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization_type' => $request->organization_type,
            'address' => $request->address,
            'event_name' => $request->event_name,
            'proposed_date' => $request->proposed_date,
            'proposed_time' => $request->proposed_time,
            'location' => $request->location,
            'maps_link' => $request->maps_link,
            'estimated_donors' => $request->estimated_donors,
            'has_room' => $request->has_room,
            'has_furniture' => $request->has_furniture,
            'has_electricity' => $request->has_electricity,
            'has_parking' => $request->has_parking,
            'event_type' => $request->event_type,
            'status' => 'pending', // Set default status to pending for donor requests
            'pmi_id' => $request->pmi_id, 
            'type' => 'organization', // Default fallback for old enum
        ];

        Collaboration::create($collaborationData);

        return redirect()->route('donor.collaboration-request')
            ->with('success', 'Pengajuan kegiatan donor darah berhasil dikirim! Tim PMI akan segera menghubungi Anda.');
    }

    public function donorIndex()
    {
        // Get all collaborations for current user (both admin and donor form submissions)
        $collaborations = Collaboration::where('email', auth()->user()->email)
            ->orWhere('contact_email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('donor.collaborations', compact('collaborations'));
    }

    /**
     * Show collaboration details for donor
     */
    public function donorShow($id)
    {
        $collaboration = Collaboration::where('id', $id)
            ->where(function($query) {
                $query->where('email', auth()->user()->email)
                      ->orWhere('contact_email', auth()->user()->email);
            })
            ->firstOrFail();

        return view('donor.collaboration-show', compact('collaboration'));
    }

    public function donorDestroy($id)
    {
        $collaboration = Collaboration::where('id', $id)
            ->where(function($query) {
                $query->where('email', auth()->user()->email)
                      ->orWhere('contact_email', auth()->user()->email);
            })
            ->firstOrFail();

        if ($collaboration->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan yang berstatus pending yang dapat dihapus.');
        }

        $collaboration->delete();

        return redirect()->route('donor.collaborations')
            ->with('success', 'Pengajuan kolaborasi berhasil dibatalkan dan dihapus.');
    }

    public function index()
    {
        $collaborations = Collaboration::where('pmi_id', auth()->user()->pmi_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.collaborations.index', compact('collaborations'));
    }

    public function show(Collaboration $collaboration)
    {
        return view('admin.collaborations.show', compact('collaboration'));
    }

    public function edit(Collaboration $collaboration)
    {
        return view('admin.collaborations.edit', compact('collaboration'));
    }

    public function update(Request $request, Collaboration $collaboration)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $collaboration->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'admin_id' => auth()->id(),
        ]);

        return redirect()->route('admin.collaborations.index')
            ->with('success', 'Collaboration status updated successfully.');
    }

    public function print(Collaboration $collaboration)
    {
        return view('admin.collaborations.print', compact('collaboration'));
    }

    public function destroy(Collaboration $collaboration)
    {
        $collaboration->delete();

        return redirect()->route('admin.collaborations.index')
            ->with('success', 'Collaboration request deleted successfully.');
    }
}
