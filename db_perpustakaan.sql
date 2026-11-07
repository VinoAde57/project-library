-- Database: data_buku (sesuai database yang sudah dibuat di phpMyAdmin)
CREATE DATABASE IF NOT EXISTS data_buku CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE data_buku;

-- Tabel tb_buku: jika sudah ada (dan sudah berisi data), bagian ini tidak mengubah apa pun
CREATE TABLE IF NOT EXISTS tb_buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_buku VARCHAR(200) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    penulis VARCHAR(120) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    status_ketersediaan INT NOT NULL DEFAULT 1, -- jumlah stok: 0 = Dipinjam, >0 = Tersedia
    sampul VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- Tabel pengguna untuk login (tabel baru)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun default: username "admin", password "admin123" (bcrypt)
INSERT IGNORE INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$12$V1Vizwu2y//Kl3zA4eSN7ew0pkixNQGB2ZQo3VSi9RKnG480eezYq', 'Administrator');
