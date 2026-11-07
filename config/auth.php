<?php
// Helper: session, proteksi halaman, CSRF, flash message, label status
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function wajib_login(): void
{
    if (empty($_SESSION['user_id'])) {
        set_flash('warning', 'Silakan login terlebih dahulu.');
        header('Location: index.php');
        exit;
    }
}

function e($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_valid(?string $token): bool
{
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

function set_flash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function get_flash(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// Logika bisnis: label status berdasarkan stok (if-else)
function label_status(int $stok): string
{
    if ($stok > 0) {
        return 'Tersedia';
    }
    return 'Dipinjam';
}

function badge_status(int $stok): string
{
    switch (label_status($stok)) {
        case 'Tersedia':
            return 'success';
        default:
            return 'danger';
    }
}
