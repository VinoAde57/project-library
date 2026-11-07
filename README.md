# Mini Digital Library

Tugas Terstruktur Pemrograman Web — Program Studi Sistem Informasi.
Aplikasi manajemen data buku (CRUD) dengan Login, Session, Cookie (Remember Me), dan Upload Sampul, dibuat dengan **PHP Native + MySQL (mysqli)** dan Bootstrap 5.

- **Nama / NIM:** _isi nama dan NIM_
- **Video demo:** _tempel link YouTube_

## Fitur
- Login (POST), Session, Remember Me (cookie username 7 hari), Logout (hapus session & cookie)
- Dashboard dengan statistik, pencarian, dan tabel data buku
- CRUD buku + upload sampul (JPG/PNG, maks 2MB, validasi ekstensi, MIME, dan ukuran)
- Edit dengan opsi ganti sampul (file lama otomatis dihapus), Delete ikut menghapus file gambar
- Label status via if-else/switch: stok > 0 = **Tersedia**, stok 0 = **Dipinjam**
- Keamanan: prepared statement, `password_hash/password_verify`, CSRF token, `htmlspecialchars`, `session_regenerate_id`

## Cara Menjalankan
1. Pindahkan folder ke `htdocs` (XAMPP) atau web root lain.
2. Import `db_perpustakaan.sql` lewat phpMyAdmin (membuat database `data_buku`, tabel `tb_buku` dan `users`).
3. Sesuaikan kredensial di `config/koneksi.php` bila perlu.
4. Buka `http://localhost/project_perpustakaan/`
5. Login: **admin / admin123**

## Struktur Project
```
project_perpustakaan/
├── config/ (koneksi.php, auth.php, upload.php)
├── partials/ (header.php, footer.php, form_buku.php)
├── uploads/
├── index.php, proses_login.php, logout.php
├── dashboard.php
├── tambah_buku.php, proses_tambah.php
├── edit_buku.php, proses_edit.php
├── hapus_buku.php
└── db_perpustakaan.sql
```

## Struktur Tabel Database
**users**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT, PK, AI | |
| username | VARCHAR(50), UNIQUE | |
| password | VARCHAR(255) | hash bcrypt |
| nama_lengkap | VARCHAR(100) | |
| created_at | TIMESTAMP | |

**tb_buku**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT, PK, AI | |
| judul_buku | VARCHAR(200) | |
| kategori | VARCHAR(50) | |
| penulis | VARCHAR(120) | |
| tahun_terbit | YEAR | |
| status_ketersediaan | INT | jumlah stok: 0 = Dipinjam, >0 = Tersedia |
| sampul | VARCHAR(255) | nama file di folder `uploads/` |

## Screenshot
> Ganti path gambar di bawah dengan screenshot Anda (simpan di folder `screenshots/`).

| Halaman | Screenshot |
|---|---|
| Login | ![Login](screenshots/login.png) |
| Dashboard (Read) | ![Dashboard](screenshots/dashboard.png) |
| Tambah Buku (Create + Upload) | ![Tambah](screenshots/tambah.png) |
| Edit Buku (Update) | ![Edit](screenshots/edit.png) |
| Hapus Buku (Delete) | ![Hapus](screenshots/hapus.png) |
