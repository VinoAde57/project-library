<?php
require_once 'config/koneksi.php';
require_once 'config/auth.php';
wajib_login();

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $koneksi->prepare('SELECT id, judul_buku AS judul, kategori, penulis, tahun_terbit, status_ketersediaan AS stok, sampul FROM tb_buku WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    set_flash('danger', 'Data buku tidak ditemukan.');
    header('Location: dashboard.php');
    exit;
}

$judul_halaman = 'Edit Buku';
require 'partials/header.php';
?>
<div class="container pb-5" style="max-width: 760px;">
    <div class="card fade-up p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2"></i>Edit Buku</h5>
        <?php
        $aksi = 'proses_edit.php';
        $tombol = 'Simpan Perubahan';
        require 'partials/form_buku.php';
        ?>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
