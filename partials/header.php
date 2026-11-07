<?php
// Wajib di-include setelah config/auth.php. Variabel opsional: $judul_halaman, $tampilkan_nav
$judul_halaman = $judul_halaman ?? 'Mini Digital Library';
$tampilkan_nav = $tampilkan_nav ?? true;
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul_halaman) ?> | Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; }
        .navbar-brand { font-weight: 700; letter-spacing: .3px; }
        .card { border: 0; border-radius: 14px; box-shadow: 0 4px 18px rgba(30, 41, 59, .07); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: grid; place-items: center; font-size: 1.4rem; }
        .cover-thumb { width: 48px; height: 64px; object-fit: cover; border-radius: 6px; background: #334155; }
        .cover-preview { max-height: 180px; border-radius: 8px; }
        .login-wrap { min-height: 100vh; display: grid; place-items: center;
            background: linear-gradient(135deg, #0f172a, #312e81); }
    </style>
</head>
<body>
<?php if ($tampilkan_nav): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-journal-bookmark-fill me-2"></i>Mini Digital Library</a>
        <div class="d-flex align-items-center text-white gap-3">
            <span class="small"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['nama'] ?? '') ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </div>
    </div>
</nav>
<?php endif; ?>
<?php if ($flash): ?>
<div class="container">
    <div class="alert alert-<?= e($flash['tipe']) ?> alert-dismissible fade show" role="alert">
        <?= e($flash['pesan']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
