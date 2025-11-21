-- Database E-Mading Baknus
-- Created for Laravel Application

-- Create Database
CREATE DATABASE IF NOT EXISTS `mading_baknus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mading_baknus`;

-- Table: users
CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: kategori
CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `kategori_nama_kategori_unique` (`nama_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: artikel
CREATE TABLE `artikel` (
  `id_artikel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('draft','pending','publish','rejected') NOT NULL DEFAULT 'pending',
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_artikel`),
  KEY `artikel_id_user_foreign` (`id_user`),
  KEY `artikel_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `artikel_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `artikel_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: like
CREATE TABLE `like` (
  `id_like` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_artikel` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_like`),
  UNIQUE KEY `like_id_artikel_id_user_unique` (`id_artikel`,`id_user`),
  KEY `like_id_user_foreign` (`id_user`),
  CONSTRAINT `like_id_artikel_foreign` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`) ON DELETE CASCADE,
  CONSTRAINT `like_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: komentars
CREATE TABLE `komentars` (
  `id_komentar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `isi` text NOT NULL,
  `id_artikel` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komentar`),
  KEY `komentars_id_artikel_foreign` (`id_artikel`),
  KEY `komentars_id_user_foreign` (`id_user`),
  CONSTRAINT `komentars_id_artikel_foreign` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`) ON DELETE CASCADE,
  CONSTRAINT `komentars_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Data
-- Default Admin User (password: admin123)
INSERT INTO `users` (`nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW());

-- Default Guru User (password: guru123)
INSERT INTO `users` (`nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Guru Pembimbing', 'guru', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', NOW(), NOW());

-- Default Siswa User (password: siswa123)
INSERT INTO `users` (`nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Siswa SMK', 'siswa', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa', NOW(), NOW());

-- Default Categories
INSERT INTO `kategori` (`nama_kategori`, `created_at`, `updated_at`) VALUES
('Berita Sekolah', NOW(), NOW()),
('Prestasi', NOW(), NOW()),
('Kegiatan', NOW(), NOW()),
('Teknologi', NOW(), NOW()),
('Olahraga', NOW(), NOW()),
('Seni & Budaya', NOW(), NOW());

-- Sample Articles
INSERT INTO `artikel` (`judul`, `konten`, `status`, `id_user`, `id_kategori`, `created_at`, `updated_at`) VALUES
('Selamat Datang di E-Mading Baknus', 'Selamat datang di platform E-Mading SMK Bakti Nusantara 666. Platform ini dibuat untuk memfasilitasi siswa dan guru dalam berbagi informasi, berita, dan artikel menarik.', 'publish', 1, 1, NOW(), NOW()),
('Prestasi Siswa dalam Lomba Programming', 'Tim programming SMK Bakti Nusantara 666 berhasil meraih juara 2 dalam kompetisi programming tingkat provinsi. Selamat untuk para juara!', 'publish', 2, 2, NOW(), NOW()),
('Kegiatan Ekstrakurikuler Semester Ini', 'Berbagai kegiatan ekstrakurikuler telah dimulai untuk semester ini. Mari bergabung dan kembangkan bakat kalian!', 'publish', 3, 3, NOW(), NOW());