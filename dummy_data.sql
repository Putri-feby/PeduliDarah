-- ============================================================
-- DATA DUMMY LENGKAP - SISTEM DONOR DARAH (PeduliDarah)
-- Sesuai dengan struktur database complete_database_setup.sql
-- Jalankan di phpMyAdmin atau via MySQL CLI
-- ============================================================

USE `pedulidarah`;

-- Bersihkan data lama (urutan harus sesuai foreign key)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `queues`;
TRUNCATE TABLE `etickets`;
TRUNCATE TABLE `donation_registrations`;
TRUNCATE TABLE `donation_schedules`;
TRUNCATE TABLE `collaborations`;
TRUNCATE TABLE `staff_profiles`;
TRUNCATE TABLE `donor_profiles`;
TRUNCATE TABLE `otp_codes`;
TRUNCATE TABLE `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- 1. USERS (STAFF / PMI)
-- Password = 'password123' (bcrypt hash)
-- ============================================================
INSERT INTO `users` (`role`, `nama_lengkap`, `email`, `no_telp`, `jenis_kelamin`, `nik`, `tanggal_lahir`, `password`, `login_attempts`, `locked_until`, `created_at`, `updated_at`) VALUES
-- Staff PMI Kota Tangerang (admin utama)
('staff', 'Admin PMI Kota Tangerang', 'adminpeduli@gmail.com', '082112345678', 'pria', '3671010101900001', '1990-01-01', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Staff PMI Jakarta Selatan
('staff', 'Dr. Rahmat Hidayat', 'rahmat.staff@pmi-jaksel.org', '082234567890', 'pria', '3174010205880002', '1988-02-05', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Staff PMI Jakarta Pusat
('staff', 'Sari Indah Permata', 'sari.staff@pmi-jakpus.org', '082345678901', 'wanita', '3171010803920003', '1992-03-08', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Staff PMI Kota Depok
('staff', 'Budi Kurniawan', 'budi.staff@pmi-depok.org', '082456789012', 'pria', '3276010612850004', '1985-06-12', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),

-- ============================================================
-- USERS (DONOR)
-- ============================================================
-- Donor 1: Ahmad Rizki (Gol A+)
('donor', 'Ahmad Rizki Pratama', 'ahmad.rizki@gmail.com', '081234567891', 'pria', '3171010115920011', '1992-01-15', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 2: Siti Nurhaliza (Gol B+)
('donor', 'Siti Nurhaliza', 'siti.nurhaliza@yahoo.com', '082112348821', 'wanita', '3174014508950012', '1995-08-05', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 3: Budi Santoso (Gol O+)
('donor', 'Budi Santoso', 'budi.santoso@hotmail.com', '081398765432', 'pria', '3578011012880013', '1988-10-10', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 4: Dewi Lestari (Gol AB+)
('donor', 'Dewi Lestari', 'dewi.lestari@gmail.com', '085612349876', 'wanita', '3402012503930014', '1993-03-25', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 5: Eko Prasetyo (Gol A-)
('donor', 'Eko Prasetyo', 'eko.prasetyo@gmail.com', '087812345678', 'pria', '1271011807900015', '1990-07-18', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 6: Fatimah Az-Zahra (Gol O+)
('donor', 'Fatimah Az-Zahra', 'fatimah.zahra@gmail.com', '081234567016', 'wanita', '3671014012980016', '1998-12-01', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 7: Rendra Kusuma (Gol B+)
('donor', 'Rendra Kusuma', 'rendra.kusuma@gmail.com', '089876543217', 'pria', '3671011505870017', '1987-05-15', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW()),
-- Donor 8: Zuzu Amelia (Gol A+)
('donor', 'Zuzu Amelia', 'zuzu@yopmail.com', '082398765018', 'wanita', '3671014301010018', '2001-01-03', '\$2y\$10\$UqfRqzRjaTglGWU5Zan96u.4AoMB/qjVrGbF842fm9FNQFqeXkyym', 0, NULL, NOW(), NOW());

-- ============================================================
-- 2. STAFF PROFILES
-- user_id 1-4 adalah staff
-- ============================================================
INSERT INTO `staff_profiles` (`user_id`, `unit_pmi`, `nomor_pegawai`, `created_at`, `updated_at`) VALUES
(1, 'PMI Kota Tangerang', 'PMI-TNG-001', NOW(), NOW()),
(2, 'PMI Jakarta Selatan', 'PMI-JAKSEL-001', NOW(), NOW()),
(3, 'PMI Jakarta Pusat', 'PMI-JAKPUS-001', NOW(), NOW()),
(4, 'PMI Kota Depok', 'PMI-DEPOK-001', NOW(), NOW());

-- ============================================================
-- 3. DONOR PROFILES
-- user_id 5-12 adalah donor
-- ============================================================
INSERT INTO `donor_profiles` (`user_id`, `golongan_darah`, `rhesus`, `riwayat_penyakit`, `pernah_donor`, `detail_riwayat_donor`, `alergi`, `obat`, `created_at`, `updated_at`) VALUES
(5,  'A',  '+', NULL, 1, 'Pernah donor di PMI Jakarta tahun 2024, total 3 kali', NULL, NULL, NOW(), NOW()),
(6,  'B',  '+', NULL, 0, NULL, 'Alergi debu', NULL, NOW(), NOW()),
(7,  'O',  '+', NULL, 1, 'Donor rutin 6 bulan sekali sejak 2020. Total 8 kali donor.', NULL, NULL, NOW(), NOW()),
(8,  'AB', '+', 'Pernah operasi usus buntu tahun 2019 (sudah sembuh)', 1, 'Pertama donor tahun 2022. Total 2 kali.', NULL, NULL, NOW(), NOW()),
(9,  'A',  '-', NULL, 1, 'Donor golongan darah A negatif yang langka. Total 5 kali.', NULL, NULL, NOW(), NOW()),
(10, 'O',  '+', NULL, 0, NULL, NULL, NULL, NOW(), NOW()),
(11, 'B',  '+', NULL, 1, 'Donor di berbagai event PMI dan rumah sakit. Total 12 kali.', 'Alergi penisilin', NULL, NOW(), NOW()),
(12, 'A',  '+', NULL, 0, NULL, NULL, NULL, NOW(), NOW());

-- ============================================================
-- 4. JADWAL DONOR (donation_schedules)
-- Struktur: title, description, location, date, start_time, end_time, max_donors, current_donors, status
-- ============================================================
INSERT INTO `donation_schedules` (`title`, `description`, `location`, `date`, `start_time`, `end_time`, `max_donors`, `current_donors`, `status`, `created_at`, `updated_at`) VALUES
-- Jadwal upcoming (mendatang)
('Donor Darah Rutin PMI Kota Tangerang',
 'Kegiatan donor darah rutin bulanan PMI Kota Tangerang. Terbuka untuk umum. Setiap pendonor mendapat snack dan sertifikat donor.',
 'Gedung PMI Kota Tangerang, Jl. Daan Mogot KM 19, Tangerang',
 DATE_ADD(CURDATE(), INTERVAL 3 DAY), '08:00:00', '14:00:00', 80, 34, 'upcoming', NOW(), NOW()),

('Blood Drive - Universitas Indonesia',
 'Program donor darah mahasiswa UI memperingati Hari Kesehatan Nasional. Terbuka untuk umum dan mahasiswa.',
 'Gedung Student Center UI, Depok',
 DATE_ADD(CURDATE(), INTERVAL 7 DAY), '09:00:00', '15:00:00', 100, 72, 'upcoming', NOW(), NOW()),

('Donor Darah Emergency - Stok Menipis',
 'Kebutuhan darah mendesak untuk rumah sakit di area Tangerang. Stok golongan O dan AB sangat menipis. Mohon bantuannya!',
 'Kantor PMI Jakarta Selatan, Jl. TB Simatupang No. 45',
 DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:00:00', '17:00:00', 50, 48, 'upcoming', NOW(), NOW()),

('Corporate Blood Drive - PT. Maju Bersama',
 'Program donor darah karyawan PT. Maju Bersama Indonesia sebagai bagian dari program CSR perusahaan.',
 'Kawasan Industri Jatake, Tangerang',
 DATE_ADD(CURDATE(), INTERVAL 10 DAY), '08:30:00', '13:30:00', 120, 45, 'upcoming', NOW(), NOW()),

('Donor Darah Berhadiah - Mall Central Park',
 'Donor darah spesial weekend dengan hadiah menarik dari sponsor. Goodie bag, voucher belanja, dan merchandise eksklusif untuk setiap pendonor.',
 'Atrium Mall Central Park, Jakarta Barat',
 DATE_ADD(CURDATE(), INTERVAL 5 DAY), '10:00:00', '18:00:00', 150, 98, 'upcoming', NOW(), NOW()),

('Pekan Donor Darah Mahasiswa UNPAM',
 'Pekan donor darah yang diselenggarakan Universitas Pamulang bersama PMI Kota Tangerang. Target 250 pendonor dari mahasiswa dan masyarakat sekitar.',
 'Student Center Universitas Pamulang, Pamulang',
 DATE_ADD(CURDATE(), INTERVAL 14 DAY), '07:30:00', '15:00:00', 250, 15, 'upcoming', NOW(), NOW()),

-- Jadwal completed (sudah selesai)
('Donor Darah Komunitas Surabaya Care',
 'Aksi donor darah komunitas Surabaya Care. Bersama membantu sesama warga yang membutuhkan.',
 'Balai Kota Surabaya, Jl. Tunjungan No. 1',
 DATE_SUB(CURDATE(), INTERVAL 5 DAY), '07:00:00', '12:00:00', 60, 60, 'completed', NOW(), NOW());

-- ============================================================
-- 5. REGISTRASI DONOR (donation_registrations)
-- Mengacu ke user_id dan schedule_id yang sudah dibuat
-- ============================================================
INSERT INTO `donation_registrations` (`user_id`, `schedule_id`, `registration_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
-- Jadwal 1 - PMI Tangerang (id=1)
(5,  1, DATE_SUB(NOW(), INTERVAL 2 DAY), 'confirmed', 'Pendonor rutin, golongan darah A positif', NOW(), NOW()),
(6,  1, DATE_SUB(NOW(), INTERVAL 1 DAY), 'registered', 'Baru pertama kali donor', NOW(), NOW()),
(9,  1, DATE_SUB(NOW(), INTERVAL 3 DAY), 'confirmed', 'Golongan darah A negatif yang langka', NOW(), NOW()),

-- Jadwal 2 - UI Blood Drive (id=2)
(6,  2, DATE_SUB(NOW(), INTERVAL 1 DAY), 'registered', 'Pertama kali donor di kampus', NOW(), NOW()),
(7,  2, DATE_SUB(NOW(), INTERVAL 2 DAY), 'confirmed', 'Pendonor rutin golongan O', NOW(), NOW()),
(10, 2, DATE_SUB(NOW(), INTERVAL 1 DAY), 'registered', NULL, NOW(), NOW()),

-- Jadwal 3 - Emergency (id=3)
(7,  3, NOW(), 'confirmed', 'Merespons permintaan darurat stok darah', NOW(), NOW()),
(8,  3, NOW(), 'confirmed', 'Golongan AB positif sangat dibutuhkan', NOW(), NOW()),

-- Jadwal 4 - Corporate (id=4)
(8,  4, DATE_SUB(NOW(), INTERVAL 5 DAY), 'registered', 'Peserta dari divisi HR perusahaan', NOW(), NOW()),
(11, 4, DATE_SUB(NOW(), INTERVAL 4 DAY), 'registered', 'Pendonor rutin golongan B positif', NOW(), NOW()),

-- Jadwal 5 - Mall Central Park (id=5)
(5,  5, DATE_SUB(NOW(), INTERVAL 3 DAY), 'confirmed', 'Ikut event donor darah berhadiah', NOW(), NOW()),
(11, 5, DATE_SUB(NOW(), INTERVAL 2 DAY), 'confirmed', 'Sudah donor, dapat voucher belanja', NOW(), NOW()),
(12, 5, DATE_SUB(NOW(), INTERVAL 1 DAY), 'registered', 'Pertama kali ikut event donor berhadiah', NOW(), NOW()),

-- Jadwal 6 - UNPAM (id=6)
(12, 6, NOW(), 'registered', 'Mahasiswa UNPAM semester 6', NOW(), NOW()),
(10, 6, NOW(), 'registered', NULL, NOW(), NOW()),

-- Jadwal 7 - Surabaya (sudah selesai) (id=7)
(5,  7, DATE_SUB(NOW(), INTERVAL 6 DAY), 'completed', 'Berhasil donor dengan lancar', NOW(), NOW()),
(7,  7, DATE_SUB(NOW(), INTERVAL 6 DAY), 'completed', 'Pendonor setia. Terima kasih sudah membantu!', NOW(), NOW()),
(9,  7, DATE_SUB(NOW(), INTERVAL 7 DAY), 'cancelled', 'Batal karena sakit mendadak', NOW(), NOW());

-- ============================================================
-- 6. E-TIKET (etickets)
-- Mengacu ke user_id dan schedule_id
-- ============================================================
INSERT INTO `etickets` (`user_id`, `schedule_id`, `ticket_code`, `status`, `generated_at`, `scanned_at`, `expires_at`, `created_at`, `updated_at`) VALUES
-- Tiket untuk jadwal 1 - PMI Tangerang
(5,  1, 'TKT-PMITNG-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 3 DAY), NOW(), NOW()),
(6,  1, 'TKT-PMITNG-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 3 DAY), NOW(), NOW()),
(9,  1, 'TKT-PMITNG-003', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 3 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 2 - UI Blood Drive
(6,  2, 'TKT-UI-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 7 DAY), NOW(), NOW()),
(7,  2, 'TKT-UI-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 7 DAY), NOW(), NOW()),
(10, 2, 'TKT-UI-003', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 7 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 3 - Emergency
(7,  3, 'TKT-EMG-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 1 DAY), NOW(), NOW()),
(8,  3, 'TKT-EMG-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 1 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 4 - Corporate
(8,  4, 'TKT-CORP-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 10 DAY), NOW(), NOW()),
(11, 4, 'TKT-CORP-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 10 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 5 - Mall
(5,  5, 'TKT-MALL-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 5 DAY), NOW(), NOW()),
(11, 5, 'TKT-MALL-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 5 DAY), NOW(), NOW()),
(12, 5, 'TKT-MALL-003', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 5 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 6 - UNPAM
(12, 6, 'TKT-UNPAM-001', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 14 DAY), NOW(), NOW()),
(10, 6, 'TKT-UNPAM-002', 'active', NOW(), NULL, DATE_ADD(NOW(), INTERVAL 14 DAY), NOW(), NOW()),

-- Tiket untuk jadwal 7 - Surabaya (sudah digunakan)
(5,  7, 'TKT-SBY-001', 'used', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW(), NOW()),
(7,  7, 'TKT-SBY-002', 'used', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW(), NOW());

-- ============================================================
-- 7. ANTREAN (queues)
-- Mengacu ke user_id dan schedule_id
-- ============================================================
INSERT INTO `queues` (`user_id`, `schedule_id`, `queue_number`, `status`, `estimated_time`, `created_at`, `updated_at`) VALUES
-- Antrean jadwal 1 - PMI Tangerang
(5,  1, 1, 'waiting',  '08:00:00', NOW(), NOW()),
(6,  1, 2, 'waiting',  '08:15:00', NOW(), NOW()),
(9,  1, 3, 'waiting',  '08:30:00', NOW(), NOW()),

-- Antrean jadwal 2 - UI Blood Drive
(6,  2, 1, 'waiting',  '09:00:00', NOW(), NOW()),
(7,  2, 2, 'waiting',  '09:15:00', NOW(), NOW()),
(10, 2, 3, 'waiting',  '09:30:00', NOW(), NOW()),

-- Antrean jadwal 3 - Emergency (sudah dipanggil dan dilayani)
(7,  3, 1, 'serving',  '10:00:00', NOW(), NOW()),
(8,  3, 2, 'called',   '10:15:00', NOW(), NOW()),

-- Antrean jadwal 4 - Corporate
(8,  4, 1, 'waiting',  '08:30:00', NOW(), NOW()),
(11, 4, 2, 'waiting',  '08:45:00', NOW(), NOW()),

-- Antrean jadwal 5 - Mall
(5,  5, 1, 'waiting',  '10:00:00', NOW(), NOW()),
(11, 5, 2, 'waiting',  '10:15:00', NOW(), NOW()),
(12, 5, 3, 'waiting',  '10:30:00', NOW(), NOW()),

-- Antrean jadwal 6 - UNPAM
(12, 6, 1, 'waiting',  '07:30:00', NOW(), NOW()),
(10, 6, 2, 'waiting',  '07:45:00', NOW(), NOW()),

-- Antrean jadwal 7 - Surabaya (completed)
(5,  7, 1, 'completed', '07:00:00', NOW(), NOW()),
(7,  7, 2, 'completed', '07:15:00', NOW(), NOW());

-- ============================================================
-- 8. KOLABORASI (collaborations)
-- Struktur dasar: name, email, phone, address, type, status, description
-- ============================================================
INSERT INTO `collaborations` (`name`, `email`, `phone`, `address`, `type`, `status`, `description`, `created_at`, `updated_at`) VALUES
('SMA Negeri 5 Tangerang', 'hendra.saputra@sman5tng.sch.id', '082198765401',
 'Jl. Merdeka No. 10, Tangerang', 'organization', 'active',
 'Pengajuan kolaborasi untuk kegiatan Donor Darah HUT Sekolah ke-35. PIC: Bapak Hendra Saputra. Estimasi 80 pendonor. Lokasi: Aula SMA Negeri 5 Tangerang. Tanggal: ' || DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 12 DAY), '%d-%m-%Y'),
 NOW(), NOW()),

('PT. Maju Bersama Indonesia', 'rina.kusumawati@majubersama.co.id', '081345678920',
 'Kawasan Industri Jatake, Tangerang', 'organization', 'pending',
 'Bakti Sosial Donor Darah Hari Buruh. PIC: Ibu Rina Kusumawati. Estimasi 120 pendonor. Lokasi: Gedung Serbaguna PT. Maju Bersama Indonesia.',
 NOW(), NOW()),

('Universitas Pamulang Kampus Tangerang', 'ahmad.fauzi@unpam.ac.id', '087765432109',
 'Jl. Surya Kencana No. 1, Pamulang, Tangerang Selatan', 'university', 'active',
 'Pekan Donor Darah Mahasiswa 2026. PIC: Dr. Ahmad Fauzi. Estimasi 250 pendonor. Lokasi: Student Center Unpam. Disetujui oleh admin PMI.',
 NOW(), NOW()),

('Komunitas Pemuda Tangerang Bergerak', 'rizky.ramadhan@pemudatng.org', '089654321078',
 'Jl. Cikokol Raya No. 5, Tangerang', 'organization', 'pending',
 'Aksi Nyata Generasi Muda - Donor Darah Serentak. PIC: Sdr. Rizky Ramadhan. Estimasi 60 pendonor. Lokasi: Lapangan Maulana Yusuf, Tangerang.',
 NOW(), NOW()),

('Masjid Al-Ikhlas Perumnas II', 'mansyur.hakim@alikhlas.org', '081287654398',
 'Perumnas II, Karawaci, Tangerang', 'organization', 'active',
 'Donor Darah Ramadan - Berbagi Kehidupan. PIC: Ust. Mansyur Hakim. Estimasi 40 pendonor. Lokasi: Halaman Masjid Al-Ikhlas.',
 NOW(), NOW()),

('Rumah Sakit Siloam Tangerang', 'carla.dewi@siloam.co.id', '021-55789900',
 'Jl. M.H. Thamrin No. 3, Tangerang', 'hospital', 'active',
 'Donor Darah Rutin Bulanan Siloam. PIC: dr. Carla Dewi, Sp.PD. Estimasi 75 pendonor. Lokasi: Lobby RS Siloam Tangerang.',
 NOW(), NOW()),

('PT. Sehat Selalu Jakarta', 'budi.wijaya@sehat.com', '081234567891',
 'Kantor PT. Sehat Selalu, Jakarta Selatan', 'organization', 'active',
 'Donor Darah Rutin Kuartalan. PIC: Dr. Budi Wijaya. Estimasi 100 pendonor. Disetujui untuk jangka panjang.',
 NOW(), NOW()),

('Kelompok Arisan RT 07 Cipondoh', 'zuzu@yopmail.com', '082398765018',
 'Jl. Cipondoh Indah No. 12, Tangerang', 'organization', 'pending',
 'Donor Darah Bareng Warga RT 07. PIC: Zuzu Amelia. Estimasi 30 pendonor. Lokasi: Balai Warga RT 07.',
 NOW(), NOW()),

('OSIS SMP Harapan Bangsa', 'zuzu@yopmail.com', '082398765018',
 'Jl. Harapan No. 45, Tangerang', 'organization', 'pending',
 'Gerakan Pelajar Peduli Darah 2026. PIC: Zuzu Amelia. Estimasi 50 pendonor. Lokasi: Aula SMP Harapan Bangsa.',
 NOW(), NOW()),

('Koperasi Serba Usaha Mekar Jaya', 'zuzu@yopmail.com', '082398765018',
 'Jl. Mekar Raya No. 8, Karawaci, Tangerang', 'organization', 'active',
 'Hari Koperasi Nasional - Aksi Donor Darah. PIC: Zuzu Amelia. Estimasi 45 pendonor. Disetujui oleh admin PMI.',
 NOW(), NOW());

-- ============================================================
-- VERIFIKASI DATA
-- ============================================================
SELECT 
  'users (staff)'         as tabel, COUNT(*) as jumlah FROM users WHERE role = 'staff'
UNION ALL SELECT 'users (donor)', COUNT(*) FROM users WHERE role = 'donor'
UNION ALL SELECT 'donor_profiles', COUNT(*) FROM donor_profiles
UNION ALL SELECT 'staff_profiles', COUNT(*) FROM staff_profiles
UNION ALL SELECT 'donation_schedules', COUNT(*) FROM donation_schedules
UNION ALL SELECT 'donation_registrations', COUNT(*) FROM donation_registrations
UNION ALL SELECT 'etickets', COUNT(*) FROM etickets
UNION ALL SELECT 'queues', COUNT(*) FROM queues
UNION ALL SELECT 'collaborations', COUNT(*) FROM collaborations;

SELECT 'Data dummy berhasil dimasukkan!' as status, NOW() as waktu;
