<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    use HasFactory;

    protected $table = 'etickets';

    protected $fillable = [
        'registration_id',
        'ticket_code',
        'qr_code',
        'status',
        'generated_at',
        'scanned_at',
        'expires_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'scanned_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(DonationRegistration::class, 'registration_id');
    }

    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isScanned()
    {
        return $this->status === 'scanned' || $this->status === 'used';
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->isScanned();
    }
}
