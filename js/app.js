/* ==========================================================
   Mini Digital Library - app.js
   ========================================================== */
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- 1. Mode terang / gelap ---------- */
    var html = document.documentElement;
    var tombolTema = document.querySelectorAll('[data-theme-toggle]');

    function ikonTema() {
        var gelap = html.getAttribute('data-bs-theme') === 'dark';
        tombolTema.forEach(function (btn) {
            btn.innerHTML = gelap ? '<i class="bi bi-sun-fill"></i>' : '<i class="bi bi-moon-stars-fill"></i>';
            btn.title = gelap ? 'Ganti ke mode terang' : 'Ganti ke mode gelap';
        });
    }
    ikonTema();
    tombolTema.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var baru = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', baru);
            try { localStorage.setItem('tema', baru); } catch (e) {}
            ikonTema();
        });
    });

    /* ---------- 2. Pesan (alert) hilang otomatis ---------- */
    document.querySelectorAll('.alert').forEach(function (el) {
        setTimeout(function () {
            if (window.bootstrap) { bootstrap.Alert.getOrCreateInstance(el).close(); }
        }, 4500);
    });

    /* ---------- 3. Animasi angka pada kartu statistik ---------- */
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseInt(el.dataset.count, 10) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        var mulai = null, durasi = 900;
        function langkah(t) {
            if (mulai === null) mulai = t;
            var p = Math.min((t - mulai) / durasi, 1);
            el.textContent = Math.round(target * p);
            if (p < 1) requestAnimationFrame(langkah);
        }
        requestAnimationFrame(langkah);
    });

    /* ---------- 4. Konfirmasi hapus (SweetAlert2, fallback confirm) ---------- */
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (form.dataset.sudah === '1') { return; }
            e.preventDefault();
            var judul = form.dataset.confirm;
            if (window.Swal) {
                Swal.fire({
                    title: 'Hapus buku ini?',
                    html: '<b>' + judul.replace(/[<>&"]/g, '') + '</b><br>Data dan file sampulnya akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545',
                    background: html.getAttribute('data-bs-theme') === 'dark' ? '#1e293b' : '#fff',
                    color: html.getAttribute('data-bs-theme') === 'dark' ? '#e2e8f0' : '#212529'
                }).then(function (hasil) {
                    if (hasil.isConfirmed) { form.dataset.sudah = '1'; form.submit(); }
                });
            } else if (confirm('Hapus buku "' + judul + '"?')) {
                form.dataset.sudah = '1';
                form.submit();
            }
        });
    });

    /* ---------- 5. Validasi & pratinjau sampul ---------- */
    var inputSampul = document.getElementById('sampul');
    var preview = document.getElementById('preview');
    if (inputSampul && preview) {
        inputSampul.addEventListener('change', function () {
            var f = this.files[0];
            if (!f) { preview.classList.add('d-none'); return; }
            if (['image/jpeg', 'image/png'].indexOf(f.type) === -1) {
                peringatan('Format file harus JPG atau PNG.');
                this.value = ''; preview.classList.add('d-none'); return;
            }
            if (f.size > 2 * 1024 * 1024) {
                peringatan('Ukuran file maksimal 2MB.');
                this.value = ''; preview.classList.add('d-none'); return;
            }
            preview.src = URL.createObjectURL(f);
            preview.classList.remove('d-none');
        });
    }
    function peringatan(teks) {
        if (window.Swal) { Swal.fire({ icon: 'error', title: 'File tidak valid', text: teks }); }
        else { alert(teks); }
    }

    /* ---------- 6. Tampilkan / sembunyikan password ---------- */
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.querySelector(btn.dataset.togglePassword);
            if (!input) return;
            var tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            btn.innerHTML = tampil ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });

    /* ---------- 7. Cegah klik ganda pada tombol submit ---------- */
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (form.dataset.confirm !== undefined) return;
            var btn = form.querySelector('button[type="submit"]');
            if (btn && form.checkValidity()) {
                setTimeout(function () {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                }, 0);
            }
        });
    });
});
