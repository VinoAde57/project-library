<?php
require_once 'config/koneksi.php';
require_once 'config/auth.php';
wajib_login();

// Pencarian (metode GET)
$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $like = '%' . $cari . '%';
    $stmt = $koneksi->prepare('SELECT id, judul_buku AS judul, kategori, penulis, tahun_terbit, status_ketersediaan AS stok, sampul FROM tb_buku WHERE judul_buku LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $stmt->bind_param('sss', $like, $like, $like);
    $stmt->execute();
    $hasil = $stmt->get_result();
} else {
    $hasil = $koneksi->query('SELECT id, judul_buku AS judul, kategori, penulis, tahun_terbit, status_ketersediaan AS stok, sampul FROM tb_buku ORDER BY id DESC');
}
$buku = $hasil->fetch_all(MYSQLI_ASSOC);

// Statistik
$total = (int) $koneksi->query('SELECT COUNT(*) c FROM tb_buku')->fetch_assoc()['c'];
$tersedia = (int) $koneksi->query('SELECT COUNT(*) c FROM tb_buku WHERE status_ketersediaan > 0')->fetch_assoc()['c'];
$dipinjam = $total - $tersedia;

$judul_halaman = 'Dashboard';
require 'partials/header.php';
?>
<div class="container pb-5">
    <div class="row g-3 mb-4">
        <?php
        $kartu = [
            ['Total Buku', $total, 'bi-journals', 'primary'],
            ['Tersedia', $tersedia, 'bi-check-circle', 'success'],
            ['Dipinjam', $dipinjam, 'bi-hourglass-split', 'danger'],
        ];
        foreach ($kartu as [$label, $nilai, $ikon, $warna]): ?>
        <div class="col-md-4">
            <div class="card p-3 d-flex flex-row align-items-center gap-3">
                <div class="stat-icon bg-<?= $warna ?>-subtle text-<?= $warna ?>"><i class="bi <?= $ikon ?>"></i></div>
                <div>
                    <div class="text-muted small"><?= $label ?></div>
                    <div class="fs-4 fw-bold"><?= $nilai ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="card p-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="fw-bold mb-0">Daftar Buku</h5>
            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul/penulis/kategori" value="<?= e($cari) ?>">
                    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-search"></i></button>
                </form>
                <a href="tambah_buku.php" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-plus-lg me-1"></i>Tambah Buku</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th><th>Sampul</th><th>Judul</th><th>Kategori</th><th>Penulis</th>
                        <th>Tahun</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$buku): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data buku.</td></tr>
                <?php endif; ?>
                <?php foreach ($buku as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if ($b['sampul'] && is_file('uploads/' . $b['sampul'])): ?>
                                <img src="uploads/<?= e($b['sampul']) ?>" class="cover-thumb" alt="Sampul">
                            <?php else: ?>
                                <div class="cover-thumb d-grid place-items-center text-muted" style="display:grid;place-items:center"><i class="bi bi-image"></i></div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= e($b['judul']) ?></td>
                        <td><?= e($b['kategori']) ?></td>
                        <td><?= e($b['penulis']) ?></td>
                        <td><?= e($b['tahun_terbit']) ?></td>
                        <td><?= (int) $b['stok'] ?></td>
                        <td><span class="badge text-bg-<?= badge_status((int) $b['stok']) ?>"><?= label_status((int) $b['stok']) ?></span></td>
                        <td class="text-end text-nowrap">
                            <a href="edit_buku.php?id=<?= (int) $b['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <form action="hapus_buku.php" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku &quot;<?= e(addslashes($b['judul'])) ?>&quot;?');">
                                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
