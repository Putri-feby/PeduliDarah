<?php

use App\Models\User;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\Hash;

$user = User::firstOrCreate(
    ['email' => 'tangsel@pmi.or.id'],
    [
        'name' => 'PMI Tangerang Selatan',
        'nama_lengkap' => 'PMI Kota Tangerang Selatan',
        'role' => 'staff',
        'password' => Hash::make('password123'),
        'no_telp' => '02112345678',
        'jenis_kelamin' => 'L',
        'nik' => '3674000000000001',
    ]
);

StaffProfile::updateOrCreate(
    ['user_id' => $user->id],
    [
        'unit_pmi' => 'PMI Kota Tangerang Selatan',
        'nomor_pegawai' => 'PMI-TANGSEL-001',
    ]
);

echo "Akun PMI Tangerang Selatan berhasil dibuat!\n";
echo "Email: tangsel@pmi.or.id\n";
echo "Password: password123\n";
