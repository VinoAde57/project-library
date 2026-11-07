<?php
require_once 'config/koneksi.php';
require_once 'config/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
if (!csrf_valid($_POST['csrf'] ?? null)) {
    set_flash('danger', 'Token tidak valid, silakan coba lagi.');
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

if ($username === '' || $password === '') {
    set_flash('danger', 'Username dan password wajib diisi.');
    header('Location: index.php');
    exit;
}

$stmt = $koneksi->prepare('SELECT id, username, password, nama_lengkap FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama'] = $user['nama_lengkap'];

    $opsi_cookie = ['path' => '/', 'httponly' => true, 'samesite' => 'Lax'];
    if ($remember) {
        // Simpan username di browser selama 7 hari
        setcookie('remember_username', $user['username'], $opsi_cookie + ['expires' => time() + 7 * 24 * 3600]);
    } else {
        setcookie('remember_username', '', $opsi_cookie + ['expires' => time() - 3600]);
    }

    header('Location: dashboard.php');
    exit;
}

set_flash('danger', 'Username atau password salah.');
header('Location: index.php');
exit;
