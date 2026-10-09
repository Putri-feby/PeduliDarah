<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'nama_lengkap',
        'email',
        'no_telp',
        'jenis_kelamin',
        'nik',
        'tanggal_lahir',
        'password',
        'login_attempts',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donationRegistrations()
    {
        return $this->hasMany(DonationRegistration::class);
    }

    public function donationSchedules()
    {
        return $this->hasMany(DonationSchedule::class, 'admin_id');
    }

    public function collaborations()
    {
        return $this->hasMany(Collaboration::class, 'admin_id');
    }

    /**
     * Get the donor profile associated with the user.
     */
    public function donorProfile()
    {
        return $this->hasOne(DonorProfile::class);
    }

    /**
     * Get the staff profile associated with the user.
     */
    public function staffProfile()
    {
        return $this->hasOne(StaffProfile::class);
    }

    public function isAdmin()
    {
        return $this->role === 'staff';
    }

    public function isDonor()
    {
        return $this->role === 'donor';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Get the pmi_id dynamically from staff profile.
     */
    public function getPmiIdAttribute()
    {
        if ($this->role === 'staff') {
            return $this->staffProfile ? $this->staffProfile->unit_pmi : null;
        }
        return $this->attributes['pmi_id'] ?? null;
    }
}
