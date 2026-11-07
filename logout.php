<?php
require_once 'config/auth.php';

// Hapus seluruh data session
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

// Hapus cookie Remember Me
setcookie('remember_username', '', ['expires' => time() - 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);

// Mulai session baru hanya untuk pesan flash
session_start();
set_flash('success', 'Anda berhasil logout.');
header('Location: index.php');
exit;
