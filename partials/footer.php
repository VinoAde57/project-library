<?php if ($tampilkan_nav ?? true): ?>
<footer class="site-footer">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div>
                <i class="bi bi-journal-bookmark-fill me-1"></i>
                <strong>Mini Digital Library</strong>
                <span class="text-secondary">&copy; <?= date('Y') ?></span>
            </div>
            <div class="small text-secondary">
                Vino Ade C &middot; Sistem Informasi
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
