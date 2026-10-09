<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'golongan_darah',
        'rhesus',
        'riwayat_penyakit',
        'pernah_donor',
        'detail_riwayat_donor',
        'alergi',
        'obat',
    ];

    protected $casts = [
        'pernah_donor' => 'boolean',
    ];

    /**
     * Get the user that owns the donor profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
