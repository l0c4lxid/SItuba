# SITUBA – Sistem Informasi Tuberkulosis Surakarta

SITUBA adalah aplikasi web berbasis Laravel 12 untuk pemantauan, edukasi, dan pelaporan tuberkulosis di Kota Surakarta. Aplikasi ini menghubungkan Pemda, puskesmas, kelurahan, kader, hingga pasien dalam satu dasbor.

## Fitur Utama

- **Multi-role auth & dashboard**: Pemda, Puskesmas, Kelurahan, Kader, Pasien; autentikasi via nomor HP.
- **Verifikasi akun Pemda**: validasi, ubah kredensial, aktif/nonaktif, dan bulk update status.
- **Manajemen pasien puskesmas**: daftar pasien, anggota keluarga, status berobat, dan tindak lanjut.
- **Skrining & pendampingan**: modul skrining dan pencatatan pendampingan minum obat di lapangan.
- **Monitoring kelurahan**: pantau puskesmas dan kader di wilayahnya.
- **Portal berita/edukasi**: publikasi artikel di `/blog`, lengkap dengan publish/unpublish.
- **Landing + SEO dasar**: sitemap XML dinamis dan robots.txt otomatis mengikuti domain.

## Persyaratan

- PHP 8.2+
- Composer 2+
- Node.js 20+ & npm
- MySQL/MariaDB (atau database lain yang kompatibel dengan Laravel)

## Cara Menjalankan Proyek

1. **Clone & install dependency**
   ```bash
   composer install
   npm install
   ```

2. **Siapkan environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Lalu perbarui konfigurasi database di `.env` (misal `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

3. **Migrasi database**
   ```bash
   php artisan migrate
   ```
   Untuk fitur blog pastikan storage publik tersambung:
   ```bash
   php artisan storage:link
   ```
   Jika ingin memulai dengan data contoh (pemda, puskesmas, kader, pasien, treatment Faskes, dll) jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Build asset**
   ```bash
   npm run dev   # atau npm run build untuk mode produksi
   ```

5. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

## Struktur Autentikasi

- `app/Enums/UserRole.php` — daftar peran resmi dan label tampilan.
- `app/Models/User` — menyimpan role & status aktif.
- `app/Models/UserDetail` — detail tambahan setiap user.
- `resources/views/auth/register.blade.php` — form registrasi multi-role.
- `resources/views/dashboard.blade.php` — dashboard ringkas menampilkan info pengguna.

## Kontribusi & Lisensi

Proyek ini dibangun di atas Laravel dan menggunakan lisensi MIT. Silakan buka issue atau pull request jika ingin berkontribusi pada SITUBA.
