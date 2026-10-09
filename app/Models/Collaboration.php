<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'type',
        'organization_type',
        'pic_name',
        'event_name',
        'proposed_date',
        'proposed_time',
        'location',
        'maps_link',
        'estimated_donors',
        'has_room',
        'has_furniture',
        'has_electricity',
        'has_parking',
        'description',
        'status',
        'organization_name',
        'contact_person',
        'contact_email',
        'contact_phone',
        'proposal_description',

        'event_type',
        'expected_donors',
        'admin_notes',
        'admin_id',
        'pmi_id',
    ];

    protected $casts = [
        'proposed_date' => 'date',
        'has_room' => 'boolean',
        'has_furniture' => 'boolean',
        'has_electricity' => 'boolean',
        'has_parking' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function donationSchedule()
    {
        return $this->hasOne(DonationSchedule::class, 'collaboration_id');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isUnderReview()
    {
        return $this->status === 'under_review';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
