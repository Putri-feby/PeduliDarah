<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'nik',
        'unit_pmi',
        'nomor_pegawai',
        'foto_id_card',
    ];

    /**
     * Get the user that owns the staff profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
