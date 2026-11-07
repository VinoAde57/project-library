<?php
require_once 'config/koneksi.php';
require_once 'config/auth.php';
require_once 'config/upload.php';
wajib_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid($_POST['csrf'] ?? null)) {
    set_flash('danger', 'Permintaan tidak valid.');
    header('Location: dashboard.php');
    exit;
}

$judul = trim($_POST['judul'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$penulis = trim($_POST['penulis'] ?? '');
$tahun = filter_var($_POST['tahun_terbit'] ?? '', FILTER_VALIDATE_INT);
$stok = filter_var($_POST['stok'] ?? '', FILTER_VALIDATE_INT);

$_SESSION['old'] = ['judul' => $judul, 'kategori' => $kategori, 'penulis' => $penulis, 'tahun_terbit' => $_POST['tahun_terbit'] ?? '', 'stok' => $_POST['stok'] ?? 1];

if ($judul === '' || $kategori === '' || $penulis === '' || $tahun === false || $stok === false || $stok < 0) {
    set_flash('danger', 'Semua field wajib diisi dengan benar.');
    header('Location: tambah_buku.php');
    exit;
}
if ($tahun < 1900 || $tahun > (int) date('Y')) {
    set_flash('danger', 'Tahun terbit tidak valid.');
    header('Location: tambah_buku.php');
    exit;
}

try {
    $sampul = upload_sampul($_FILES['sampul'] ?? []);
} catch (RuntimeException $ex) {
    set_flash('danger', $ex->getMessage());
    header('Location: tambah_buku.php');
    exit;
}

$stmt = $koneksi->prepare('INSERT INTO tb_buku (judul_buku, kategori, penulis, tahun_terbit, status_ketersediaan, sampul) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('sssiis', $judul, $kategori, $penulis, $tahun, $stok, $sampul);
$stmt->execute();
$stmt->close();

unset($_SESSION['old']);
set_flash('success', 'Buku berhasil ditambahkan.');
header('Location: dashboard.php');
exit;
