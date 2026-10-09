<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'max_donors',
        'current_donors',
        'status',
        'admin_id',
        'pmi_id',
        'event_type',
        'collaboration_id',
        'invitation_code',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function donationRegistrations()
    {
        return $this->hasMany(DonationRegistration::class, 'schedule_id');
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function availableSlots()
    {
        return $this->max_donors - $this->current_donors;
    }

    public function isFull()
    {
        return $this->current_donors >= $this->max_donors;
    }

    public function collaboration()
    {
        return $this->belongsTo(Collaboration::class, 'collaboration_id');
    }
}
