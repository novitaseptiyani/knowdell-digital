# Knowdell Digital

Platform asesmen kartu karier digital dengan tiga peran: pengguna,
konselor, dan admin.

## Tampilan
(screenshot ditambahkan di sini)

## Fitur Utama
**Pengguna**
- Registrasi, login, dan pengisian profil awal (onboarding)
- Sesi tes kartu dengan penyimpanan progres, worksheet, dan halaman hasil
- Riwayat tes dan pengelolaan profil

**Konselor**
- Dashboard, daftar klien, dan detail hasil tes
- Memberi rekomendasi pada hasil tes
- Daftar tes selesai dan yang belum ditinjau, ekspor data
- Profil dan biografi publik

**Admin**
- Mengelola pengguna, konselor, dan admin
- Menetapkan konselor untuk pengguna
- Ekspor data pengguna

Autentikasi memakai dua guard terpisah (pengguna dan staf) dengan
middleware peran.

## Tech Stack
Laravel 11, PHP 8.2, MySQL, Blade, Tailwind CSS 3, Alpine.js 3,
Vite 5, Axios

## Peran Saya
Semua saya kerjakan secara mandiri

## Cara Menjalankan
Butuh PHP 8.2+, Composer, Node.js, dan MySQL (misalnya XAMPP).

1. Clone repo, lalu masuk ke foldernya.
2. `composer install`
3. `npm install`
4. Salin `.env.example` menjadi `.env`, lalu `php artisan key:generate`
5. Buat database `knowdell_digital` di phpMyAdmin, lalu **Import**
   file `database/knowdell_schema.sql`.
6. Ubah di `.env`:
```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=knowdell_digital
   DB_USERNAME=root
   DB_PASSWORD=
   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
```
7. Jalankan `npm run dev` di satu terminal, dan `php artisan serve`
   di terminal lain. Buka `http://127.0.0.1:8000`.

**Jangan menjalankan `php artisan migrate`**: struktur sudah dibuat
oleh file import di langkah 5.

### Membuat akun admin demo
Jalankan di tab SQL phpMyAdmin (password: `Demo12345`):
```sql
INSERT INTO `staff` (`email`, `password`, `full_name`, `role`)
VALUES ('admin@example.com',
'$2y$10$luxa26O8W4MpfXDPSfLSyeE0Zdej5YgwP9MNDFxHDWFcb/qouOQBO',
'Admin Demo', 'admin');
```

### Catatan
Isi kartu (tabel `cards` dan `categories`) tidak disertakan di
repo ini, sehingga fitur tes memerlukan data kartu sendiri.
