<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'status',
        'registration_time',
        'notes',
        'pmi_id',
    ];

    protected $casts = [
        'registration_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(DonationSchedule::class, 'schedule_id');
    }

    public function eTicket()
    {
        return $this->hasOne(ETicket::class, 'registration_id');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class, 'registration_id');
    }
}
