USE emading;

DROP TABLE IF EXISTS komentar;
DROP TABLE IF EXISTS like;
DROP TABLE IF EXISTS artikel;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'guru', 'siswa') DEFAULT 'siswa',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE kategori (
    id_kategori BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE artikel (
    id_artikel BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    konten TEXT NOT NULL,
    foto VARCHAR(255) NULL,
    status ENUM('draft', 'pending', 'publish', 'rejected') DEFAULT 'draft',
    id_user BIGINT UNSIGNED NOT NULL,
    id_kategori BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE like (
    id_like BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_artikel BIGINT UNSIGNED NOT NULL,
    id_user BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY unique_like (id_artikel, id_user)
);

CREATE TABLE komentar (
    id_komentar BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isi TEXT NOT NULL,
    id_artikel BIGINT UNSIGNED NOT NULL,
    id_user BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO users (nama, username, password, role) VALUES
('Administrator', 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Guru SMK', 'guru', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru'),
('Siswa SMK', 'siswa', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siswa');

INSERT INTO kategori (nama_kategori) VALUES
('Teknologi'),
('Pendidikan'),
('Olahraga'),
('Seni & Budaya'),
('Berita Sekolah'),
('Tips & Tutorial');