<?php
// Variabel: $aksi, $csrf, $data (array), $tombol
?>
<form action="<?= e($aksi) ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <?php if (!empty($data['id'])): ?>
        <input type="hidden" name="id" value="<?= (int) $data['id'] ?>">
    <?php endif; ?>
    <div class="row g-3">
        <div class="col-12">
            <label class="form-label">Judul Buku</label>
            <input type="text" name="judul" class="form-control" value="<?= e($data['judul'] ?? '') ?>" required maxlength="200">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <?php $kategori_list = ['Akademik', 'Sejarah', 'Dongeng', 'Filsafat', 'Novel', 'Sains', 'Pemograman', 'Lainnya']; ?>
            <select name="kategori" class="form-select" required>
                <option value="">-- Pilih kategori --</option>
                <?php foreach ($kategori_list as $k): ?>
                    <option value="<?= e($k) ?>" <?= (($data['kategori'] ?? '') === $k) ? 'selected' : '' ?>><?= e($k) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" value="<?= e($data['penulis'] ?? '') ?>" required maxlength="120">
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" min="1900" max="<?= date('Y') ?>" value="<?= e($data['tahun_terbit'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Stok <small class="text-muted">(0 = Dipinjam, &gt;0 = Tersedia)</small></label>
            <input type="number" name="stok" class="form-control" min="0" value="<?= e($data['stok'] ?? 1) ?>" required>
        </div>
        <div class="col-12">
            <label class="form-label">Sampul Buku <small class="text-muted">(.jpg/.png, maks 2MB<?= !empty($data['id']) ? ', kosongkan jika tidak diganti' : '' ?>)</small></label>
            <input type="file" name="sampul" id="sampul" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            <?php if (!empty($data['sampul']) && is_file('uploads/' . $data['sampul'])): ?>
                <div class="mt-2"><small class="text-muted d-block">Sampul saat ini:</small>
                <img src="uploads/<?= e($data['sampul']) ?>" class="cover-preview" alt="Sampul saat ini"></div>
            <?php endif; ?>
            <img id="preview" class="cover-preview mt-2 d-none" alt="Pratinjau">
        </div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i><?= e($tombol) ?></button>
        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
<script>
// JS: validasi ukuran/tipe di sisi klien + pratinjau gambar
document.getElementById('sampul').addEventListener('change', function () {
    const f = this.files[0];
    const prev = document.getElementById('preview');
    if (!f) { prev.classList.add('d-none'); return; }
    if (!['image/jpeg', 'image/png'].includes(f.type)) {
        alert('Format harus JPG atau PNG.'); this.value = ''; prev.classList.add('d-none'); return;
    }
    if (f.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB.'); this.value = ''; prev.classList.add('d-none'); return;
    }
    prev.src = URL.createObjectURL(f);
    prev.classList.remove('d-none');
});
</script>
