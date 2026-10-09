<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'registration_id',
        'queue_number',
        'status',
        'called_at',
        'serving_at',
        'completed_at',
        'pmi_id',
    ];

    protected $casts = [
        'called_at' => 'datetime',
        'serving_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function schedule()
    {
        return $this->belongsTo(DonationSchedule::class);
    }

    public function registration()
    {
        return $this->belongsTo(DonationRegistration::class, 'registration_id');
    }

    public function user()
    {
        return $this->registration->user;
    }

    public function isWaiting()
    {
        return $this->status === 'waiting';
    }

    public function isCalled()
    {
        return $this->status === 'called';
    }

    public function isServing()
    {
        return $this->status === 'serving';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isPreparing()
    {
        return $this->status === 'preparing';
    }

    public function isSkipped()
    {
        return $this->status === 'skipped';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
