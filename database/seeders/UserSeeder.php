<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin Peduli Darah',
            'email' => 'admin@pedulidarah.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'birth_date' => '1990-01-01',
            'blood_type' => 'O',
        ]);

        // Create Dummy Donors
        $donors = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@email.com',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => '081234567891',
                'address' => 'Jakarta Selatan, DKI Jakarta',
                'birth_date' => '1992-05-15',
                'blood_type' => 'A',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@email.com',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => '081234567892',
                'address' => 'Bandung, Jawa Barat',
                'birth_date' => '1995-08-20',
                'blood_type' => 'B',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => '081234567893',
                'address' => 'Surabaya, Jawa Timur',
                'birth_date' => '1988-12-10',
                'blood_type' => 'O',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@email.com',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => '081234567894',
                'address' => 'Yogyakarta, DI Yogyakarta',
                'birth_date' => '1993-03-25',
                'blood_type' => 'AB',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@email.com',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'phone' => '081234567895',
                'address' => 'Medan, Sumatera Utara',
                'birth_date' => '1990-07-18',
                'blood_type' => 'A',
            ],
        ];

        foreach ($donors as $donor) {
            User::create($donor);
        }
    }
}
