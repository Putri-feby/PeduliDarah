<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collaboration;
use App\Models\User;

class DummyDonorCollaborationSeeder extends Seeder
{
    /**
     * Buat data dummy kolaborasi dari pendonor zuzu@yopmail.com
     * yang ditujukan ke admin PMI Kota Tangerang (adminpeduli@gmail.com)
     */
    public function run(): void
    {
        $admin  = User::where('email', 'adminpeduli@gmail.com')->first();
        $donor  = User::where('email', 'zuzu@yopmail.com')->first();

        if (!$admin) {
            $this->command->error('Admin dengan email adminpeduli@gmail.com tidak ditemukan!');
            return;
        }

        if (!$donor) {
            $this->command->error('Donor dengan email zuzu@yopmail.com tidak ditemukan!');
            return;
        }

        $pmiId = $admin->pmi_id; // "PMI Kota Tangerang"

        $collaborations = [
            [
                // Pending – baru diajukan
                'name'              => 'Kelompok Arisan RT 07 Cipondoh',
                'pic_name'          => $donor->nama_lengkap ?? 'Zuzu',
                'email'             => $donor->email,   // zuzu@yopmail.com — ini yg dipakai untuk filter
                'phone'             => $donor->no_telp ?? '08123456789',
                'organization_type' => 'Komunitas',
                'address'           => 'Jl. Cipondoh Indah No. 12, Tangerang',
                'event_name'        => 'Donor Darah Bareng Warga RT 07',
                'proposed_date'     => now()->addDays(10)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Balai Warga RT 07, Cipondoh, Tangerang',
                'maps_link'         => null,
                'estimated_donors'  => '30',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => false,
                'event_type'        => 'Publik',
                'status'            => 'pending',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
            ],
            [
                // Under review – sedang diproses admin
                'name'              => 'OSIS SMP Harapan Bangsa',
                'pic_name'          => $donor->nama_lengkap ?? 'Zuzu',
                'email'             => $donor->email,
                'phone'             => $donor->no_telp ?? '08123456789',
                'organization_type' => 'Sekolah',
                'address'           => 'Jl. Harapan No. 45, Tangerang',
                'event_name'        => 'Gerakan Pelajar Peduli Darah 2026',
                'proposed_date'     => now()->addDays(25)->format('Y-m-d'),
                'proposed_time'     => '09:00',
                'location'          => 'Aula SMP Harapan Bangsa, Tangerang',
                'maps_link'         => 'https://maps.google.com/?q=SMP+Harapan+Bangsa+Tangerang',
                'estimated_donors'  => '50',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'under_review',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Menunggu konfirmasi jumlah peserta dari pihak sekolah.',
            ],
            [
                // Approved – disetujui admin
                'name'              => 'Koperasi Serba Usaha Mekar Jaya',
                'pic_name'          => $donor->nama_lengkap ?? 'Zuzu',
                'email'             => $donor->email,
                'phone'             => $donor->no_telp ?? '08123456789',
                'organization_type' => 'Koperasi',
                'address'           => 'Jl. Mekar Raya No. 8, Karawaci, Tangerang',
                'event_name'        => 'Hari Koperasi Nasional – Aksi Donor Darah',
                'proposed_date'     => now()->addDays(40)->format('Y-m-d'),
                'proposed_time'     => '08:30',
                'location'          => 'Gedung Koperasi Mekar Jaya, Karawaci',
                'maps_link'         => 'https://maps.google.com/?q=Koperasi+Mekar+Jaya+Karawaci',
                'estimated_donors'  => '45',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'approved',
                'pmi_id'            => $pmiId,
                'type'              => 'organization',
                'admin_id'          => $admin->id,
                'admin_notes'       => 'Disetujui. Koordinasi jadwal petugas medis sudah dikonfirmasi.',
            ],
        ];

        foreach ($collaborations as $data) {
            Collaboration::create($data);
        }

        $this->command->info('✅ Berhasil membuat ' . count($collaborations) . ' data dummy kolaborasi dari pendonor ' . $donor->email . ' ke admin ' . $admin->email . ' (PMI: ' . $pmiId . ')');
    }
}
