<?php
require_once 'config/auth.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Fitur Cookie: isi otomatis username jika "Remember Me" pernah dipilih
$username_cookie = $_COOKIE['remember_username'] ?? '';

$judul_halaman = 'Login';
$tampilkan_nav = false;
require 'partials/header.php';
?>
<div class="login-wrap">
    <div class="card login-card fade-up">
        <div class="text-center mb-4">
            <div class="login-logo"><i class="bi bi-journal-bookmark-fill"></i></div>
            <h4 class="fw-bold mt-2 mb-0">Mini Digital Library</h4>
            <p class="text-muted small">Silakan login untuk melanjutkan</p>
        </div>
        <form action="proses_login.php" method="POST">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" value="<?= e($username_cookie) ?>" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" data-toggle-password="#password"><i class="bi bi-eye"></i></button>
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?= $username_cookie ? 'checked' : '' ?>>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-1"></i>Login</button>
        </form>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
