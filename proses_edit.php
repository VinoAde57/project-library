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

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
$judul = trim($_POST['judul'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$penulis = trim($_POST['penulis'] ?? '');
$tahun = filter_var($_POST['tahun_terbit'] ?? '', FILTER_VALIDATE_INT);
$stok = filter_var($_POST['stok'] ?? '', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: dashboard.php');
    exit;
}
if ($judul === '' || $kategori === '' || $penulis === '' || $tahun === false || $stok === false || $stok < 0
    || $tahun < 1900 || $tahun > (int) date('Y')) {
    set_flash('danger', 'Semua field wajib diisi dengan benar.');
    header('Location: edit_buku.php?id=' . $id);
    exit;
}

// Ambil data lama (untuk mengetahui sampul lama)
$stmt = $koneksi->prepare('SELECT sampul FROM tb_buku WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$lama) {
    set_flash('danger', 'Data buku tidak ditemukan.');
    header('Location: dashboard.php');
    exit;
}

try {
    $sampul_baru = upload_sampul($_FILES['sampul'] ?? []);
} catch (RuntimeException $ex) {
    set_flash('danger', $ex->getMessage());
    header('Location: edit_buku.php?id=' . $id);
    exit;
}

if ($sampul_baru !== null) {
    $stmt = $koneksi->prepare('UPDATE tb_buku SET judul_buku=?, kategori=?, penulis=?, tahun_terbit=?, status_ketersediaan=?, sampul=? WHERE id=?');
    $stmt->bind_param('sssiisi', $judul, $kategori, $penulis, $tahun, $stok, $sampul_baru, $id);
    $stmt->execute();
    $stmt->close();
    hapus_sampul($lama['sampul']); // hapus file lama dari server
} else {
    $stmt = $koneksi->prepare('UPDATE tb_buku SET judul_buku=?, kategori=?, penulis=?, tahun_terbit=?, status_ketersediaan=? WHERE id=?');
    $stmt->bind_param('sssiii', $judul, $kategori, $penulis, $tahun, $stok, $id);
    $stmt->execute();
    $stmt->close();
}

set_flash('success', 'Data buku berhasil diperbarui.');
header('Location: dashboard.php');
exit;
