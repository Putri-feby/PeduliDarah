<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DonorProfile;
use App\Models\StaffProfile;
use App\Models\Pmi;
use App\Models\DonationSchedule;
use App\Models\DonationRegistration;
use App\Models\ETicket;
use App\Models\Queue;
use App\Models\Collaboration;

class MasterDummySeeder extends Seeder
{
    /**
     * Seed semua data dummy untuk sistem donor darah.
     * Mencakup: PMI, Users (donor & staff), Profil, Jadwal, Registrasi, E-Tiket, Antrean, Kolaborasi
     */
    public function run(): void
    {
        $this->command->info('🩸 Memulai seeding data dummy sistem donor darah...');

        // =============================================
        // 1. SEED DATA PMI
        // =============================================
        $this->command->info('📍 Seeding data PMI...');
        $pmiList = [
            'PMI Kota Tangerang',
            'PMI Tangerang Selatan',
            'PMI Kota Tangerang Selatan',
            'PMI Kabupaten Tangerang',
            'PMI Jakarta Barat',
            'PMI Jakarta Selatan',
            'PMI Jakarta Utara',
            'PMI Jakarta Timur',
            'PMI Jakarta Pusat',
            'PMI DKI Jakarta',
            'PMI Kota Depok',
            'PMI Kota Bogor',
            'PMI Kota Bekasi',
        ];

        foreach ($pmiList as $pmiName) {
            Pmi::firstOrCreate(['name' => $pmiName]);
        }

        // =============================================
        // 2. SEED STAFF USERS (Admin PMI)
        // =============================================
        $this->command->info('👨‍⚕️ Seeding data staff PMI...');
        $staffData = [
            [
                'user' => [
                    'role'          => 'staff',
                    'nama_lengkap'  => 'Admin PMI Kota Tangerang',
                    'email'         => 'adminpeduli@gmail.com',
                    'no_telp'       => '082112345678',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3671010101900001',
                    'tanggal_lahir' => '1990-01-01',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'unit_pmi'       => 'PMI Kota Tangerang',
                    'nomor_pegawai'  => 'PMI-TNG-001',
                ],
            ],
            [
                'user' => [
                    'role'          => 'staff',
                    'nama_lengkap'  => 'Dr. Rahmat Hidayat',
                    'email'         => 'rahmat.staff@pmi-jaksel.org',
                    'no_telp'       => '082234567890',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3174010205880002',
                    'tanggal_lahir' => '1988-02-05',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'unit_pmi'       => 'PMI Jakarta Selatan',
                    'nomor_pegawai'  => 'PMI-JAKSEL-001',
                ],
            ],
            [
                'user' => [
                    'role'          => 'staff',
                    'nama_lengkap'  => 'Sari Indah Permata',
                    'email'         => 'sari.staff@pmi-jakpus.org',
                    'no_telp'       => '082345678901',
                    'jenis_kelamin' => 'wanita',
                    'nik'           => '3171010803920003',
                    'tanggal_lahir' => '1992-03-08',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'unit_pmi'       => 'PMI Jakarta Pusat',
                    'nomor_pegawai'  => 'PMI-JAKPUS-001',
                ],
            ],
            [
                'user' => [
                    'role'          => 'staff',
                    'nama_lengkap'  => 'Budi Kurniawan',
                    'email'         => 'budi.staff@pmi-depok.org',
                    'no_telp'       => '082456789012',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3276010612850004',
                    'tanggal_lahir' => '1985-06-12',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'unit_pmi'       => 'PMI Kota Depok',
                    'nomor_pegawai'  => 'PMI-DEPOK-001',
                ],
            ],
        ];

        $staffUsers = [];
        foreach ($staffData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['user']['email']],
                $data['user']
            );
            StaffProfile::firstOrCreate(
                ['user_id' => $user->id],
                array_merge($data['profile'], ['user_id' => $user->id])
            );
            $staffUsers[] = $user;
        }

        $adminUser = $staffUsers[0]; // Admin PMI Kota Tangerang

        // =============================================
        // 3. SEED DONOR USERS
        // =============================================
        $this->command->info('🧑 Seeding data pendonor...');
        $donorData = [
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Ahmad Rizki Pratama',
                    'email'         => 'ahmad.rizki@gmail.com',
                    'no_telp'       => '081234567891',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3171010115920011',
                    'tanggal_lahir' => '1992-01-15',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'A',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => true,
                    'detail_riwayat_donor'  => 'Pernah donor di PMI Jakarta tahun 2024, total 3 kali',
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Siti Nurhaliza',
                    'email'         => 'siti.nurhaliza@yahoo.com',
                    'no_telp'       => '082112348821',
                    'jenis_kelamin' => 'wanita',
                    'nik'           => '3174014508950012',
                    'tanggal_lahir' => '1995-08-05',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'B',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => false,
                    'detail_riwayat_donor'  => null,
                    'alergi'                => 'Alergi debu',
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Budi Santoso',
                    'email'         => 'budi.santoso@hotmail.com',
                    'no_telp'       => '081398765432',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3578011012880013',
                    'tanggal_lahir' => '1988-10-10',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'O',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => true,
                    'detail_riwayat_donor'  => 'Donor rutin 6 bulan sekali sejak 2020. Total 8 kali donor.',
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Dewi Lestari',
                    'email'         => 'dewi.lestari@gmail.com',
                    'no_telp'       => '085612349876',
                    'jenis_kelamin' => 'wanita',
                    'nik'           => '3402012503930014',
                    'tanggal_lahir' => '1993-03-25',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'AB',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => 'Pernah operasi usus buntu tahun 2019 (sudah sembuh)',
                    'pernah_donor'          => true,
                    'detail_riwayat_donor'  => 'Pertama donor tahun 2022. Total 2 kali.',
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Eko Prasetyo',
                    'email'         => 'eko.prasetyo@gmail.com',
                    'no_telp'       => '087812345678',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '1271011807900015',
                    'tanggal_lahir' => '1990-07-18',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'A',
                    'rhesus'                => '-',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => true,
                    'detail_riwayat_donor'  => 'Donor golongan darah A negatif yang langka. Total 5 kali.',
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Fatimah Az-Zahra',
                    'email'         => 'fatimah.zahra@gmail.com',
                    'no_telp'       => '081234567016',
                    'jenis_kelamin' => 'wanita',
                    'nik'           => '3671014012980016',
                    'tanggal_lahir' => '1998-12-01',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'O',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => false,
                    'detail_riwayat_donor'  => null,
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Rendra Kusuma',
                    'email'         => 'rendra.kusuma@gmail.com',
                    'no_telp'       => '089876543217',
                    'jenis_kelamin' => 'pria',
                    'nik'           => '3671011505870017',
                    'tanggal_lahir' => '1987-05-15',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'B',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => true,
                    'detail_riwayat_donor'  => 'Donor di berbagai event PMI dan rumah sakit. Total 12 kali.',
                    'alergi'                => 'Alergi penisilin',
                    'obat'                  => null,
                ],
            ],
            [
                'user' => [
                    'role'          => 'donor',
                    'nama_lengkap'  => 'Zuzu Amelia',
                    'email'         => 'zuzu@yopmail.com',
                    'no_telp'       => '082398765018',
                    'jenis_kelamin' => 'wanita',
                    'nik'           => '3671014301010018',
                    'tanggal_lahir' => '2001-01-03',
                    'password'      => Hash::make('password123'),
                ],
                'profile' => [
                    'golongan_darah'        => 'A',
                    'rhesus'                => '+',
                    'riwayat_penyakit'      => null,
                    'pernah_donor'          => false,
                    'detail_riwayat_donor'  => null,
                    'alergi'                => null,
                    'obat'                  => null,
                ],
            ],
        ];

        $donorUsers = [];
        foreach ($donorData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['user']['email']],
                $data['user']
            );
            DonorProfile::firstOrCreate(
                ['user_id' => $user->id],
                array_merge($data['profile'], ['user_id' => $user->id])
            );
            $donorUsers[] = $user;
        }

        // =============================================
        // 4. SEED JADWAL DONOR (DonationSchedule)
        // =============================================
        $this->command->info('📅 Seeding jadwal donor...');
        $scheduleData = [
            [
                'title'           => 'Donor Darah Rutin PMI Kota Tangerang',
                'description'     => 'Kegiatan donor darah rutin bulanan yang diselenggarakan oleh PMI Kota Tangerang. Terbuka untuk umum. Setiap pendonor akan mendapatkan snack dan sertifikat donor.',
                'start_time'      => now()->addDays(3)->setTime(8, 0),
                'end_time'        => now()->addDays(3)->setTime(14, 0),
                'location'        => 'Gedung PMI Kota Tangerang, Jl. Daan Mogot KM 19, Tangerang',
                'max_donors'      => 80,
                'current_donors'  => 34,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Kota Tangerang',
                'event_type'      => 'Publik',
                'admin_id'        => $adminUser->id,
            ],
            [
                'title'           => 'Blood Drive - Universitas Indonesia',
                'description'     => 'Program donor darah mahasiswa UI dalam rangka memperingati Hari Kesehatan Nasional. Terbuka untuk umum dan mahasiswa.',
                'start_time'      => now()->addDays(7)->setTime(9, 0),
                'end_time'        => now()->addDays(7)->setTime(15, 0),
                'location'        => 'Gedung Student Center UI, Depok',
                'max_donors'      => 100,
                'current_donors'  => 72,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Kota Depok',
                'event_type'      => 'Publik',
                'admin_id'        => $staffUsers[3]->id,
            ],
            [
                'title'           => 'Donor Darah Emergency - Stok Menipis',
                'description'     => 'Kebutuhan darah mendesak untuk beberapa rumah sakit di area Tangerang. Stok golongan O dan AB sangat menipis.',
                'start_time'      => now()->addDays(1)->setTime(10, 0),
                'end_time'        => now()->addDays(1)->setTime(17, 0),
                'location'        => 'Kantor PMI Jakarta Selatan, Jl. TB Simatupang No. 45',
                'max_donors'      => 50,
                'current_donors'  => 48,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Jakarta Selatan',
                'event_type'      => 'Publik',
                'admin_id'        => $staffUsers[1]->id,
            ],
            [
                'title'           => 'Corporate Blood Drive - PT. Maju Bersama',
                'description'     => 'Program donor darah karyawan PT. Maju Bersama Indonesia sebagai bagian dari CSR perusahaan. Eksklusif untuk karyawan dan keluarga.',
                'start_time'      => now()->addDays(10)->setTime(8, 30),
                'end_time'        => now()->addDays(10)->setTime(13, 30),
                'location'        => 'Kawasan Industri Jatake, Tangerang',
                'max_donors'      => 120,
                'current_donors'  => 45,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Kota Tangerang',
                'event_type'      => 'Private',
                'admin_id'        => $adminUser->id,
            ],
            [
                'title'           => 'Donor Darah Berhadiah - Mall Central Park',
                'description'     => 'Donor darah spesial weekend dengan hadiah menarik dari sponsor. Setiap pendonor mendapatkan goodie bag, voucher belanja, dan merchandise eksklusif.',
                'start_time'      => now()->addDays(5)->setTime(10, 0),
                'end_time'        => now()->addDays(5)->setTime(18, 0),
                'location'        => 'Atrium Mall Central Park, Jakarta Barat',
                'max_donors'      => 150,
                'current_donors'  => 98,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Jakarta Pusat',
                'event_type'      => 'Publik',
                'admin_id'        => $staffUsers[2]->id,
            ],
            [
                'title'           => 'Pekan Donor Darah Mahasiswa UNPAM',
                'description'     => 'Pekan donor darah yang diselenggarakan oleh Universitas Pamulang bekerja sama dengan PMI Kota Tangerang. Target 250 pendonor.',
                'start_time'      => now()->addDays(14)->setTime(7, 30),
                'end_time'        => now()->addDays(14)->setTime(15, 0),
                'location'        => 'Student Center Universitas Pamulang, Pamulang',
                'max_donors'      => 250,
                'current_donors'  => 15,
                'status'          => 'scheduled',
                'pmi_id'          => 'PMI Kota Tangerang',
                'event_type'      => 'Publik',
                'admin_id'        => $adminUser->id,
            ],
            [
                'title'           => 'Donor Darah Komunitas Surabaya Care',
                'description'     => 'Aksi donor darah komunitas Surabaya Care. Mari bersama-sama membantu sesama warga yang membutuhkan.',
                'start_time'      => now()->subDays(5)->setTime(7, 0),
                'end_time'        => now()->subDays(5)->setTime(12, 0),
                'location'        => 'Balai Kota Surabaya, Jl. Tunjungan No. 1',
                'max_donors'      => 60,
                'current_donors'  => 60,
                'status'          => 'completed',
                'pmi_id'          => 'PMI Kota Tangerang',
                'event_type'      => 'Publik',
                'admin_id'        => $adminUser->id,
            ],
        ];

        $schedules = [];
        foreach ($scheduleData as $data) {
            $schedule = DonationSchedule::create($data);
            $schedules[] = $schedule;
        }

        // =============================================
        // 5. SEED REGISTRASI DONOR (DonationRegistration)
        // =============================================
        $this->command->info('📋 Seeding registrasi donor...');
        $registrationData = [
            // Jadwal 0 - PMI Tangerang
            ['user' => $donorUsers[0], 'schedule' => $schedules[0], 'status' => 'confirmed', 'days_ago' => 2, 'notes' => 'Pendonor rutin, golongan darah A positif'],
            ['user' => $donorUsers[1], 'schedule' => $schedules[0], 'status' => 'registered', 'days_ago' => 1, 'notes' => 'Baru pertama kali donor'],
            ['user' => $donorUsers[4], 'schedule' => $schedules[0], 'status' => 'confirmed', 'days_ago' => 3, 'notes' => 'Golongan darah A negatif yang langka'],

            // Jadwal 1 - UI Blood Drive
            ['user' => $donorUsers[1], 'schedule' => $schedules[1], 'status' => 'registered', 'days_ago' => 1, 'notes' => 'Pertama kali donor'],
            ['user' => $donorUsers[2], 'schedule' => $schedules[1], 'status' => 'confirmed', 'days_ago' => 2, 'notes' => 'Pendonor rutin golongan O'],
            ['user' => $donorUsers[5], 'schedule' => $schedules[1], 'status' => 'registered', 'days_ago' => 1, 'notes' => null],

            // Jadwal 2 - Emergency
            ['user' => $donorUsers[2], 'schedule' => $schedules[2], 'status' => 'confirmed', 'days_ago' => 0, 'notes' => 'Merespons permintaan darurat'],
            ['user' => $donorUsers[3], 'schedule' => $schedules[2], 'status' => 'confirmed', 'days_ago' => 0, 'notes' => 'Golongan AB positif dibutuhkan'],

            // Jadwal 3 - Corporate
            ['user' => $donorUsers[3], 'schedule' => $schedules[3], 'status' => 'registered', 'days_ago' => 5, 'notes' => 'Peserta dari divisi HR'],
            ['user' => $donorUsers[6], 'schedule' => $schedules[3], 'status' => 'registered', 'days_ago' => 4, 'notes' => 'Pendonor rutin B positif'],

            // Jadwal 4 - Mall Central Park
            ['user' => $donorUsers[0], 'schedule' => $schedules[4], 'status' => 'confirmed', 'days_ago' => 3, 'notes' => 'Ikut event donor berhadiah'],
            ['user' => $donorUsers[6], 'schedule' => $schedules[4], 'status' => 'confirmed', 'days_ago' => 2, 'notes' => 'Donor berhadiah'],
            ['user' => $donorUsers[7], 'schedule' => $schedules[4], 'status' => 'registered', 'days_ago' => 1, 'notes' => 'Pertama kali ikut event ini'],

            // Jadwal 5 - UNPAM
            ['user' => $donorUsers[7], 'schedule' => $schedules[5], 'status' => 'registered', 'days_ago' => 0, 'notes' => 'Mahasiswa UNPAM semester 6'],
            ['user' => $donorUsers[5], 'schedule' => $schedules[5], 'status' => 'registered', 'days_ago' => 0, 'notes' => null],

            // Jadwal 6 - Sudah selesai
            ['user' => $donorUsers[0], 'schedule' => $schedules[6], 'status' => 'completed', 'days_ago' => 6, 'notes' => 'Berhasil donor dengan lancar'],
            ['user' => $donorUsers[2], 'schedule' => $schedules[6], 'status' => 'completed', 'days_ago' => 6, 'notes' => 'Pendonor setia. Terima kasih!'],
            ['user' => $donorUsers[4], 'schedule' => $schedules[6], 'status' => 'cancelled', 'days_ago' => 7, 'notes' => 'Batal karena sakit'],
        ];

        $registrations = [];
        foreach ($registrationData as $data) {
            $reg = DonationRegistration::create([
                'user_id'           => $data['user']->id,
                'schedule_id'       => $data['schedule']->id,
                'status'            => $data['status'],
                'registration_time' => now()->subDays($data['days_ago']),
                'notes'             => $data['notes'],
                'pmi_id'            => $data['schedule']->pmi_id ?? null,
            ]);
            $registrations[] = $reg;
        }

        // =============================================
        // 6. SEED E-TIKET (ETicket)
        // =============================================
        $this->command->info('🎫 Seeding e-tiket...');
        $dummyQrBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

        foreach ($registrations as $reg) {
            if ($reg->status === 'cancelled') {
                continue;
            }

            $schedule = DonationSchedule::find($reg->schedule_id);
            $isCompleted = $reg->status === 'completed';

            ETicket::create([
                'registration_id' => $reg->id,
                'ticket_code'     => 'TKT-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)),
                'qr_code'         => $dummyQrBase64,
                'status'          => $isCompleted ? 'used' : 'generated',
                'generated_at'    => $reg->registration_time ?? now(),
                'scanned_at'      => $isCompleted ? now()->subDays(rand(1, 5)) : null,
                'expires_at'      => $schedule ? $schedule->end_time : now()->addDays(7),
            ]);
        }

        // =============================================
        // 7. SEED ANTREAN (Queue)
        // =============================================
        $this->command->info('🔢 Seeding data antrean...');

        // Antrean untuk registrasi aktif
        $activeRegistrations = DonationRegistration::whereIn('status', ['confirmed', 'registered'])
            ->whereHas('schedule', function ($q) {
                $q->where('status', 'scheduled');
            })
            ->get();

        foreach ($activeRegistrations as $reg) {
            $lastQueue = Queue::where('schedule_id', $reg->schedule_id)
                ->orderBy('queue_number', 'desc')
                ->first();

            $queueNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

            if ($queueNumber <= 3) {
                $status = 'completed';
            } elseif ($queueNumber <= 5) {
                $status = 'serving';
            } elseif ($queueNumber <= 7) {
                $status = 'called';
            } else {
                $status = 'waiting';
            }

            Queue::create([
                'schedule_id'    => $reg->schedule_id,
                'registration_id' => $reg->id,
                'queue_number'   => $queueNumber,
                'status'         => $status,
                'pmi_id'         => $reg->pmi_id,
                'called_at'      => in_array($status, ['called', 'serving', 'completed']) ? now()->subMinutes(rand(5, 60)) : null,
                'serving_at'     => in_array($status, ['serving', 'completed']) ? now()->subMinutes(rand(1, 20)) : null,
                'completed_at'   => $status === 'completed' ? now()->subMinutes(rand(1, 10)) : null,
            ]);
        }

        // Antrean untuk jadwal yang sudah selesai
        $completedRegistrations = DonationRegistration::where('status', 'completed')->get();
        foreach ($completedRegistrations as $reg) {
            $lastQueue = Queue::where('schedule_id', $reg->schedule_id)
                ->orderBy('queue_number', 'desc')
                ->first();

            $queueNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

            Queue::create([
                'schedule_id'    => $reg->schedule_id,
                'registration_id' => $reg->id,
                'queue_number'   => $queueNumber,
                'status'         => 'completed',
                'pmi_id'         => $reg->pmi_id,
                'called_at'      => now()->subDays(5)->subMinutes(rand(10, 60)),
                'serving_at'     => now()->subDays(5)->subMinutes(rand(5, 30)),
                'completed_at'   => now()->subDays(5)->subMinutes(rand(1, 10)),
            ]);
        }

        // =============================================
        // 8. SEED KOLABORASI (Collaboration)
        // =============================================
        $this->command->info('🤝 Seeding data kolaborasi...');
        $collaborationData = [
            [
                'name'              => 'SMA Negeri 5 Tangerang',
                'pic_name'          => 'Bapak Hendra Saputra',
                'email'             => 'hendra.saputra@sman5tng.sch.id',
                'phone'             => '082198765401',
                'organization_type' => 'Sekolah',
                'address'           => 'Jl. Merdeka No. 10, Tangerang',
                'event_name'        => 'Donor Darah HUT Sekolah ke-35',
                'proposed_date'     => now()->addDays(12)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Aula SMA Negeri 5 Tangerang',
                'maps_link'         => 'https://maps.google.com/?q=SMA+Negeri+5+Tangerang',
                'estimated_donors'  => '80',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'pending',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
            ],
            [
                'name'              => 'PT. Maju Bersama Indonesia',
                'pic_name'          => 'Ibu Rina Kusumawati',
                'email'             => 'rina.kusumawati@majubersama.co.id',
                'phone'             => '081345678920',
                'organization_type' => 'Perusahaan',
                'address'           => 'Kawasan Industri Jatake, Tangerang',
                'event_name'        => 'Bakti Sosial Donor Darah Hari Buruh',
                'proposed_date'     => now()->addDays(20)->format('Y-m-d'),
                'proposed_time'     => '09:00',
                'location'          => 'Gedung Serbaguna PT. Maju Bersama Indonesia',
                'maps_link'         => 'https://maps.google.com/?q=PT+Maju+Bersama+Jatake',
                'estimated_donors'  => '120',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'under_review',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'company',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Sedang diverifikasi kapasitas gedung dan jumlah target pendonor.',
            ],
            [
                'name'              => 'Universitas Pamulang Kampus Tangerang',
                'pic_name'          => 'Dr. Ahmad Fauzi',
                'email'             => 'ahmad.fauzi@unpam.ac.id',
                'phone'             => '087765432109',
                'organization_type' => 'Universitas',
                'address'           => 'Jl. Surya Kencana No. 1, Pamulang, Tangerang Selatan',
                'event_name'        => 'Pekan Donor Darah Mahasiswa 2026',
                'proposed_date'     => now()->addDays(35)->format('Y-m-d'),
                'proposed_time'     => '07:30',
                'location'          => 'Student Center Unpam',
                'maps_link'         => 'https://maps.google.com/?q=Universitas+Pamulang',
                'estimated_donors'  => '250',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'approved',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'university',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Disetujui. Jadwalkan koordinasi teknis 2 minggu sebelum acara.',
            ],
            [
                'name'              => 'Komunitas Pemuda Tangerang Bergerak',
                'pic_name'          => 'Sdr. Rizky Ramadhan',
                'email'             => 'rizky.ramadhan@pemudatng.org',
                'phone'             => '089654321078',
                'organization_type' => 'Komunitas',
                'address'           => 'Jl. Cikokol Raya No. 5, Tangerang',
                'event_name'        => 'Aksi Nyata Generasi Muda - Donor Darah Serentak',
                'proposed_date'     => now()->addDays(8)->format('Y-m-d'),
                'proposed_time'     => '08:30',
                'location'          => 'Lapangan Maulana Yusuf, Tangerang',
                'maps_link'         => null,
                'estimated_donors'  => '60',
                'has_room'          => false,
                'has_furniture'     => false,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Publik',
                'status'            => 'pending',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
            ],
            [
                'name'              => 'Masjid Al-Ikhlas Perumnas II',
                'pic_name'          => 'Ust. Mansyur Hakim',
                'email'             => 'mansyur.hakim@alikhlas.org',
                'phone'             => '081287654398',
                'organization_type' => 'Organisasi Keagamaan',
                'address'           => 'Perumnas II, Karawaci, Tangerang',
                'event_name'        => 'Donor Darah Ramadan - Berbagi Kehidupan',
                'proposed_date'     => now()->addDays(45)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Halaman Masjid Al-Ikhlas Perumnas II',
                'maps_link'         => 'https://maps.google.com/?q=Masjid+Al-Ikhlas+Perumnas+II+Tangerang',
                'estimated_donors'  => '40',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => false,
                'event_type'        => 'Publik',
                'status'            => 'rejected',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Ditolak sementara karena jadwal bentrok dengan kegiatan PMI lain. Silakan ajukan ulang untuk bulan berikutnya.',
            ],
            [
                'name'              => 'Rumah Sakit Siloam Tangerang',
                'pic_name'          => 'dr. Carla Dewi, Sp.PD',
                'email'             => 'carla.dewi@siloam.co.id',
                'phone'             => '021-55789900',
                'organization_type' => 'Rumah Sakit',
                'address'           => 'Jl. M.H. Thamrin No. 3, Tangerang',
                'event_name'        => 'Donor Darah Rutin Bulanan Siloam',
                'proposed_date'     => now()->addDays(15)->format('Y-m-d'),
                'proposed_time'     => '09:00',
                'location'          => 'Lobby RS Siloam Tangerang',
                'maps_link'         => 'https://maps.google.com/?q=RS+Siloam+Tangerang',
                'estimated_donors'  => '75',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'under_review',
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'hospital',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Menunggu kelengkapan dokumen MOU dengan pihak RS.',
            ],
            // Kolaborasi dari donor Zuzu
            [
                'name'              => 'Kelompok Arisan RT 07 Cipondoh',
                'pic_name'          => 'Zuzu Amelia',
                'email'             => 'zuzu@yopmail.com',
                'phone'             => '082398765018',
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
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
            ],
            [
                'name'              => 'OSIS SMP Harapan Bangsa',
                'pic_name'          => 'Zuzu Amelia',
                'email'             => 'zuzu@yopmail.com',
                'phone'             => '082398765018',
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
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Menunggu konfirmasi jumlah peserta dari pihak sekolah.',
            ],
            [
                'name'              => 'Koperasi Serba Usaha Mekar Jaya',
                'pic_name'          => 'Zuzu Amelia',
                'email'             => 'zuzu@yopmail.com',
                'phone'             => '082398765018',
                'organization_type' => 'Koperasi',
                'address'           => 'Jl. Mekar Raya No. 8, Karawaci, Tangerang',
                'event_name'        => 'Hari Koperasi Nasional - Aksi Donor Darah',
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
                'pmi_id'            => 'PMI Kota Tangerang',
                'type'              => 'organization',
                'admin_id'          => $adminUser->id,
                'admin_notes'       => 'Disetujui. Koordinasi jadwal petugas medis sudah dikonfirmasi.',
            ],
            // Kolaborasi untuk PMI Jakarta Selatan
            [
                'name'              => 'PT. Sehat Selalu Jakarta',
                'pic_name'          => 'Dr. Budi Wijaya',
                'email'             => 'budi.wijaya@sehat.com',
                'phone'             => '081234567891',
                'organization_type' => 'Perusahaan',
                'address'           => 'Kantor PT. Sehat Selalu, Jakarta Selatan',
                'event_name'        => 'Donor Darah Rutin Kuartalan',
                'proposed_date'     => now()->addDays(21)->format('Y-m-d'),
                'proposed_time'     => '08:00',
                'location'          => 'Kantor PT. Sehat Selalu, Jakarta Selatan',
                'maps_link'         => null,
                'estimated_donors'  => '100',
                'has_room'          => true,
                'has_furniture'     => true,
                'has_electricity'   => true,
                'has_parking'       => true,
                'event_type'        => 'Private',
                'status'            => 'approved',
                'pmi_id'            => 'PMI Jakarta Selatan',
                'type'              => 'company',
                'admin_id'          => $staffUsers[1]->id,
                'admin_notes'       => 'Disetujui untuk jangka panjang. Jadwalkan setiap kuartal.',
            ],
        ];

        foreach ($collaborationData as $data) {
            Collaboration::create($data);
        }

        // =============================================
        // RINGKASAN
        // =============================================
        $this->command->newLine();
        $this->command->info('=============================================');
        $this->command->info('  Seeding data dummy SELESAI!');
        $this->command->info('=============================================');
        $this->command->table(
            ['Tabel', 'Jumlah Data'],
            [
                ['pmis',                    Pmi::count()],
                ['users (staff)',            User::where('role', 'staff')->count()],
                ['users (donor)',            User::where('role', 'donor')->count()],
                ['donor_profiles',          DonorProfile::count()],
                ['staff_profiles',          StaffProfile::count()],
                ['donation_schedules',      DonationSchedule::count()],
                ['donation_registrations',  DonationRegistration::count()],
                ['etickets',                ETicket::count()],
                ['queues',                  Queue::count()],
                ['collaborations',          Collaboration::count()],
            ]
        );
        $this->command->newLine();
        $this->command->line('Akun Login yang Tersedia:');
        $this->command->line('  [STAFF] adminpeduli@gmail.com         | password: password123 (PMI Kota Tangerang)');
        $this->command->line('  [STAFF] rahmat.staff@pmi-jaksel.org   | password: password123 (PMI Jakarta Selatan)');
        $this->command->line('  [STAFF] sari.staff@pmi-jakpus.org     | password: password123 (PMI Jakarta Pusat)');
        $this->command->line('  [STAFF] budi.staff@pmi-depok.org      | password: password123 (PMI Kota Depok)');
        $this->command->line('  [DONOR] ahmad.rizki@gmail.com         | password: password123 (Gol. A+)');
        $this->command->line('  [DONOR] siti.nurhaliza@yahoo.com      | password: password123 (Gol. B+)');
        $this->command->line('  [DONOR] budi.santoso@hotmail.com      | password: password123 (Gol. O+)');
        $this->command->line('  [DONOR] dewi.lestari@gmail.com        | password: password123 (Gol. AB+)');
        $this->command->line('  [DONOR] eko.prasetyo@gmail.com        | password: password123 (Gol. A-)');
        $this->command->line('  [DONOR] rendra.kusuma@gmail.com       | password: password123 (Gol. B+)');
        $this->command->line('  [DONOR] zuzu@yopmail.com              | password: password123 (Gol. A+)');
    }
}
