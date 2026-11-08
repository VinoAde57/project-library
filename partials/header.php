<?php
// Wajib di-include setelah config/auth.php. Variabel opsional: $judul_halaman, $tampilkan_nav
$judul_halaman = $judul_halaman ?? 'Mini Digital Library';
$tampilkan_nav = $tampilkan_nav ?? true;
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul_halaman) ?> | Mini Digital Library</title>
    <script>
        // Terapkan tema tersimpan sebelum halaman tampil (hindari kedip)
        try { document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('tema') || 'dark'); } catch (e) {}
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php if ($tampilkan_nav): ?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-gradient mb-4 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-journal-bookmark-fill me-2"></i>Mini Digital Library</a>
        <div class="d-flex align-items-center text-white gap-2">
            <span class="small d-none d-sm-inline me-1"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['nama'] ?? '') ?></span>
            <button type="button" class="btn btn-outline-light btn-sm" data-theme-toggle></button>
            <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </div>
    </div>
</nav>
<?php else: ?>
<button type="button" class="btn btn-light theme-float" data-theme-toggle></button>
<?php endif; ?>
<?php if ($flash): ?>
<div class="container" style="position: relative; z-index: 10;">
    <div class="alert alert-<?= e($flash['tipe']) ?> alert-dismissible fade show mt-3" role="alert">
        <?= e($flash['pesan']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
