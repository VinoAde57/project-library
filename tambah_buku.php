<?php
require_once 'config/koneksi.php';
require_once 'config/auth.php';
wajib_login();

// Isi ulang form jika validasi gagal
$data = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$judul_halaman = 'Tambah Buku';
require 'partials/header.php';
?>
<div class="container pb-5" style="max-width: 760px;">
    <div class="card p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</h5>
        <?php
        $aksi = 'proses_tambah.php';
        $tombol = 'Simpan';
        require 'partials/form_buku.php';
        ?>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
