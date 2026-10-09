-- Complete Database Setup for Sistem Donor Darah
-- Run this in phpMyAdmin SQL tab
-- This includes: database creation, all tables, and multi-role structure

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `pedulidarah` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `pedulidarah`;

-- Drop existing tables in correct order (respecting foreign key constraints)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `queues`;
DROP TABLE IF EXISTS `etickets`;
DROP TABLE IF EXISTS `donation_registrations`;
DROP TABLE IF EXISTS `donation_schedules`;
DROP TABLE IF EXISTS `collaborations`;
DROP TABLE IF EXISTS `staff_profiles`;
DROP TABLE IF EXISTS `donor_profiles`;
DROP TABLE IF EXISTS `otp_codes`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `migrations`;
SET FOREIGN_KEY_CHECKS = 1;

-- Create migrations table
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sessions table
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create users table (common account data)
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` ENUM('donor', 'staff') NOT NULL DEFAULT 'donor',
  `nama_lengkap` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `no_telp` VARCHAR(20) NOT NULL,
  `jenis_kelamin` ENUM('pria', 'wanita', 'lainnya') NOT NULL,
  `nik` VARCHAR(16) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `login_attempts` INT(11) NOT NULL DEFAULT 0,
  `locked_until` TIMESTAMP NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create donor_profiles table
CREATE TABLE IF NOT EXISTS `donor_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `golongan_darah` ENUM('A', 'B', 'AB', 'O') NOT NULL,
  `rhesus` ENUM('+', '-') NOT NULL DEFAULT '+',
  `riwayat_penyakit` TEXT NULL,
  `pernah_donor` TINYINT(1) DEFAULT 0,
  `detail_riwayat_donor` TEXT NULL,
  `alergi` VARCHAR(255) NULL,
  `obat` TEXT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `donor_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `donor_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create staff_profiles table
CREATE TABLE IF NOT EXISTS `staff_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `unit_pmi` VARCHAR(255) NOT NULL,
  `nomor_pegawai` VARCHAR(50) NOT NULL,
  `foto_id_card` VARCHAR(255) NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create otp_codes table
CREATE TABLE IF NOT EXISTS `otp_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` VARCHAR(6) NOT NULL,
  `type` ENUM('registration', 'login') NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otp_codes_user_id_foreign` (`user_id`),
  CONSTRAINT `otp_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create donation_schedules table
CREATE TABLE IF NOT EXISTS `donation_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_donors` int(11) NOT NULL,
  `current_donors` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create donation_registrations table
CREATE TABLE IF NOT EXISTS `donation_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `schedule_id` bigint(20) unsigned NOT NULL,
  `registration_time` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `donation_registrations_user_id_foreign` (`user_id`),
  KEY `donation_registrations_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `donation_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `donation_registrations_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `donation_schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create etickets table
CREATE TABLE IF NOT EXISTS `etickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `schedule_id` bigint(20) unsigned NOT NULL,
  `ticket_code` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `generated_at` timestamp NULL DEFAULT NULL,
  `scanned_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `etickets_ticket_code_unique` (`ticket_code`),
  KEY `etickets_user_id_foreign` (`user_id`),
  KEY `etickets_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `etickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `etickets_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `donation_schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create collaborations table
CREATE TABLE IF NOT EXISTS `collaborations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'hospital',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create queues table
CREATE TABLE IF NOT EXISTS `queues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `schedule_id` bigint(20) unsigned DEFAULT NULL,
  `queue_number` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'waiting',
  `estimated_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `queues_user_id_foreign` (`user_id`),
  KEY `queues_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `queues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `queues_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `donation_schedules` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create cache table
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create jobs table
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT SAMPLE DATA
-- ============================================

-- Insert sample users
INSERT INTO `users` (`role`, `nama_lengkap`, `email`, `no_telp`, `jenis_kelamin`, `nik`, `tanggal_lahir`, `password`, `login_attempts`, `locked_until`, `created_at`, `updated_at`) VALUES
('donor', 'Donor 1', 'donor1@example.com', '08123456790', 'pria', '1234567890123456', '1990-01-15', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, NULL, NOW(), NOW()),
('donor', 'Donor 2', 'donor2@example.com', '08123456791', 'wanita', '1234567890123457', '1995-05-20', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, NULL, NOW(), NOW()),
('staff', 'Staff 1', 'staff1@example.com', '08123456792', 'pria', '1234567890123458', '1985-03-10', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, NULL, NOW(), NOW());

-- Insert sample donor profiles
INSERT INTO `donor_profiles` (`user_id`, `golongan_darah`, `rhesus`, `riwayat_penyakit`, `pernah_donor`, `detail_riwayat_donor`, `alergi`, `obat`, `created_at`, `updated_at`) VALUES
(1, 'B+', '+', NULL, 0, NULL, NULL, NULL, NOW(), NOW()),
(2, 'O+', '+', NULL, 1, 'Donor di PMI Jakarta tahun 2023', NULL, NULL, NOW(), NOW());

-- Insert sample staff profile
INSERT INTO `staff_profiles` (`user_id`, `unit_pmi`, `nomor_pegawai`, `created_at`, `updated_at`) VALUES
(3, 'PMI Jakarta Pusat', 'PMI001', NOW(), NOW());

-- Insert sample donation schedules
INSERT INTO `donation_schedules` (`title`, `description`, `location`, `date`, `start_time`, `end_time`, `max_donors`, `current_donors`, `status`, `created_at`, `updated_at`) VALUES
('Donor Darah PMI Jakarta', 'Donor darah rutin bulanan bersama PMI Jakarta Pusat', 'PMI Jakarta Pusat', '2026-04-15', '08:00:00', '14:00:00', 50, 0, 'upcoming', NOW(), NOW()),
('Donor Darah RS Ciledug', 'Donor darah di RS Ciledug untuk membantu pasien', 'RS Ciledug', '2026-04-16', '09:00:00', '15:00:00', 30, 0, 'upcoming', NOW(), NOW()),
('Donor Darah Kampus', 'Donor darah bersama Universitas Indonesia', 'Universitas Indonesia', '2026-04-17', '10:00:00', '16:00:00', 100, 0, 'upcoming', NOW(), NOW()),
('Donor Darah Kantor', 'Donor darah di kantor pemerintah', 'Kantor Pemerintah', '2026-04-18', '08:30:00', '13:30:00', 40, 0, 'upcoming', NOW(), NOW()),
('Donor Darah Komunitas', 'Donor darah komunitas untuk kegiatan sosial', 'Komunitas Donor Darah', '2026-04-19', '09:30:00', '14:30:00', 60, 0, 'upcoming', NOW(), NOW());

-- Insert sample collaborations
INSERT INTO `collaborations` (`name`, `email`, `phone`, `type`, `status`, `description`, `created_at`, `updated_at`) VALUES
('PMI Jakarta', 'pmi@example.com', '021-123456', 'organization', 'active', 'Palang Merah Indonesia cabang Jakarta Pusat', NOW(), NOW()),
('RS Ciledug', 'ciledug@hospital.com', '021-789012', 'hospital', 'active', 'Rumah Sakit Ciledug Tangerang', NOW(), NOW()),
('Universitas Indonesia', 'ui@ac.id', '021-345678', 'university', 'pending', 'Universitas Indonesia Depok', NOW(), NOW());

-- Success message
SELECT 'Multi-role database setup completed successfully!' as message,
       (SELECT COUNT(*) FROM users) as total_users,
       (SELECT COUNT(*) FROM donor_profiles) as total_donor_profiles,
       (SELECT COUNT(*) FROM staff_profiles) as total_staff_profiles,
       (SELECT COUNT(*) FROM donation_schedules) as total_schedules,
       (SELECT COUNT(*) FROM collaborations) as total_collaborations,
       (SELECT COUNT(*) FROM sessions) as sessions_table_ready,
       'Multi-role structure with separate profile tables is now ready!' as status;
