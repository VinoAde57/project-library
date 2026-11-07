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
if ($id) {
    $stmt = $koneksi->prepare('SELECT sampul FROM tb_buku WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $buku = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($buku) {
        $stmt = $koneksi->prepare('DELETE FROM tb_buku WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        hapus_sampul($buku['sampul']); // unlink file gambar
        set_flash('success', 'Buku berhasil dihapus.');
    } else {
        set_flash('danger', 'Data buku tidak ditemukan.');
    }
}
header('Location: dashboard.php');
exit;
