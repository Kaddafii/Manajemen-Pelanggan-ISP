# Panduan Instalasi dan Penggunaan Aplikasi Manajemen Pelanggan ISP

Dokumentasi ini berisi panduan langkah demi langkah untuk melakukan instalasi, konfigurasi, migrasi basis data, pengisian data awal, dan menjalankan aplikasi Manajemen Pelanggan ISP pada lingkungan lokal.

---

## Persyaratan Sistem

Sebelum memulai proses instalasi, pastikan komputer Anda telah memenuhi persyaratan perangkat lunak berikut:

- PHP: Minimal versi 8.3 (dengan ekstensi aktif: pdo_mysql, mbstring, openssl, curl, tokenizer, xml)
- Composer: Minimal versi 2.x
- Node.js & NPM: Minimal Node.js versi 18.x atau 20.x beserta npm
- Web Server & Database: Laragon atau XAMPP (MySQL versi 8.0 atau MariaDB versi 10.4 ke atas)
- Git: Terpasang pada sistem operasi

---

## Clone Repository

1. Buka Terminal, PowerShell, atau Command Prompt pada direktori mana pun di komputer Anda sesuai keinginan (misalnya di dalam folder `C:\laragon\www`, `D:\Projects`, atau direktori kerja lainnya).
2. Jalankan perintah untuk melakukan clone repository:
   ```bash
   git clone <URL_REPOSITORY_GITHUB>
   ```
3. Masuk ke dalam direktori proyek yang telah di-clone:
   ```bash
   cd Manajemen-Pelanggan-ISP
   ```

---

## 1. Cara Instalasi Aplikasi

Setelah berada di dalam direktori proyek, lakukan instalasi dependensi backend dan frontend:

1. Instal dependensi PHP menggunakan Composer:
   ```bash
   composer install
   ```

2. Instal dependensi JavaScript menggunakan NPM:
   ```bash
   npm install
   ```

---

## 2. Konfigurasi Environment

1. Salin file contoh konfigurasi environment (`.env.example`) menjadi file `.env`:
   - Pengguna Windows (PowerShell / Command Prompt):
     ```bash
     copy .env.example .env
     ```
   - Pengguna Linux / macOS:
     ```bash
     cp .env.example .env
     ```

2. Generate kunci enkripsi aplikasi (Application Key):
   ```bash
   php artisan key:generate
   ```

3. Buka dan pastikan aplikasi Laragon atau XAMPP sudah berjalan, lalu aktifkan layanan MySQL.

4. Buat database baru di MySQL dengan nama `manajemen_pelanggan_isp` melalui phpMyAdmin, HeidiSQL, atau terminal MySQL:
   ```sql
   CREATE DATABASE manajemen_pelanggan_isp;
   ```

5. Buka file `.env` menggunakan teks editor (seperti VS Code atau Notepad), kemudian sesuaikan konfigurasi koneksi database:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=manajemen_pelanggan_isp
   DB_USERNAME=root
   DB_PASSWORD=
   APP_TIMEZONE=Asia/Jakarta
   ```

---

## 3. Cara Menjalankan Migration

Jalankan perintah migrasi tabel database untuk membuat seluruh tabel yang diperlukan oleh sistem:

```bash
php artisan migrate
```

Perintah di atas akan membuat tabel users, cache, jobs, customers, dan invoices pada database `manajemen_pelanggan_isp`.

---

## 4. Cara Menjalankan Seeder

Jalankan perintah seeder untuk mengisi data awal ke dalam database:

```bash
php artisan db:seed
```

Catatan: Anda juga dapat menjalankan proses migration sekaligus seeder dalam satu perintah:
```bash
php artisan migrate --seed
```

Setelah seeder berhasil dijalankan, database akan terisi dengan akun pengguna pengujian, data pelanggan, dan data tagihan:

- Akun Administrator:
  - Email: admin@isp.com
  - Password: password
- Akun Staff:
  - Email: staff@isp.com
  - Password: password

---

## 5. Cara Menjalankan Aplikasi

1. Lakukan kompilasi aset frontend:
   - Mode produksi:
     ```bash
     npm run build
     ```
   - Atau mode pengembangan (opsional):
     ```bash
     npm run dev
     ```

2. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```

3. Buka peramban web (browser) dan akses alamat berikut:
   ```text
   http://127.0.0.1:8000
   ```

4. Masuk menggunakan salah satu akun pengujian yang telah disediakan di atas.
