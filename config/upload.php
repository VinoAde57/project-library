<?php
// Fungsi upload sampul buku (validasi ekstensi, MIME, dan ukuran maks 2MB)
const UPLOAD_DIR = __DIR__ . '/../uploads/';
const MAKS_UKURAN = 2 * 1024 * 1024; // 2MB

/**
 * @return string|null nama file baru, atau null jika tidak ada file diunggah
 * @throws RuntimeException jika file tidak valid
 */
function upload_sampul(array $file): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        throw new RuntimeException('Ukuran file melebihi batas (maksimal 2MB).');
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Terjadi kesalahan saat mengunggah file.');
    }
    if ($file['size'] > MAKS_UKURAN) {
        throw new RuntimeException('Ukuran file melebihi 2MB.');
    }

    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $ekstensi_ok = ['jpg', 'jpeg', 'png'];
    if (!in_array($ekstensi, $ekstensi_ok, true)) {
        throw new RuntimeException('Format file harus .jpg atau .png.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'], true)) {
        throw new RuntimeException('Isi file bukan gambar JPG/PNG yang valid.');
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    $nama_baru = 'sampul_' . bin2hex(random_bytes(8)) . '.' . ($mime === 'image/png' ? 'png' : 'jpg');
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $nama_baru)) {
        throw new RuntimeException('Gagal menyimpan file ke folder uploads.');
    }
    return $nama_baru;
}

function hapus_sampul(?string $nama_file): void
{
    if ($nama_file) {
        $path = UPLOAD_DIR . basename($nama_file);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
