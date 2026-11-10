# Manajemen Pelanggan ISP

Aplikasi web manajemen pelanggan internet dan penagihan (billing) untuk penyedia layanan internet (ISP). Aplikasi ini dibangun menggunakan Laravel, Tailwind CSS, dan MySQL dengan mengusung antarmuka tactile neo-retro surface.

---

## 📌 Daftar Isi

1. [Fitur Utama](#-fitur-utama)
2. [Hak Akses Pengguna](#-hak-akses-pengguna)
3. [Persyaratan Sistem](#-persyaratan-sistem)
4. [Panduan Instalasi](#-panduan-instalasi)
5. [Akun Pengujian (Default Credentials)](#-akun-pengujian-default-credentials)
6. [Menjalankan Pengujian Otomatis (Testing)](#-menjalankan-pengujian-otomatis-testing)
7. [Struktur Proyek](#-struktur-proyek)

---

## 🚀 Fitur Utama

- **Desain Antarmuka Tactile Neo-Retro Surface**:
  - Tampilan custom berkarakter tactile dengan palet *warm paper* (`#FAF8F5`), border solid (`#18181B`), dan bayangan tegas (*hard shadows*).
  - Dilengkapi interaksi transisi mikro tactile (*hover shift* & *active press*) pada seluruh tombol, kartu, dan komponen interaktif.
  - Komponen dropdown select custom dengan dukungan kotak pencarian real-time (*searchable*), indikator status berwarna, navigasi keyboard, dan auto-submit filter.
  - Auto-dismiss flash alert yang menghilang secara otomatis setelah 4 detik atau saat ditutup manual.
  - Tampilan waktu pada seluruh tanggal menggunakan format waktu Indonesia Barat (**WIB / Asia/Jakarta**).

- **Modul Autentikasi**:
  - Login aman berbasis email dan password.
  - Pembatasan percobaan login (*Rate Limiting / Throttling*): Membatasi maksimal 5 kali percobaan gagal dalam 1 menit untuk mencegah serangan *brute force*.
  - Fitur *Remember Me* untuk mempertahankan sesi login pengguna.
  - Pengalihan cerdas berbasis peran (*role-based redirect*): Administrator diarahkan ke Dashboard, Staff diarahkan ke Pelanggan.

- **Modul Dashboard (Khusus Administrator)**:
  - 5 Kartu Metrik Ringkasan Bisnis: Total Pelanggan, Pelanggan Aktif, Pelanggan Suspend, Pelanggan Putus, dan Tagihan Belum Bayar.
  - Grafik Batang Interaktif (*Monthly Billing Bar Chart*): Visualisasi rekapitulasi nominal tagihan bulanan beserta tooltip nominal mata uang rupiah.

- **Modul Pelanggan**:
  - Manajemen data pelanggan lengkap (Nama, Nomor Telepon, Alamat, Paket Internet, Harga Paket, Status Pelanggan).
  - Status pelanggan: **Aktif**, **Suspend**, **Putus**.
  - Pencarian data pelanggan (*search*) secara instan.
  - Pengurutan data (*sorting*) multi-kolom yang dinamis (Nama, Paket, Harga, Status).
  - Navigasi halaman bertema (*tactile pagination*).
  - Penghapusan aman menggunakan **Soft Delete** Laravel (hanya dapat dilakukan oleh Administrator).

- **Modul Tagihan (Billing)**:
  - Pencatatan tagihan pelanggan dengan dukungan multi-tagihan per pelanggan.
  - Struktur data: Pelanggan, Periode Tagihan (`YYYY-MM`), Nominal Tagihan, Status Pembayaran, Tanggal Pembayaran.
  - Status pembayaran: **Belum Bayar** dan **Lunas**.
  - Dropdown pilih pelanggan dilengkapi kotak pencarian (*searchbar*) untuk kemudahan saat data pelanggan berjumlah banyak.
  - Tombol aksi bayar cepat yang secara otomatis mengubah status menjadi **Lunas** dan mencatat timestamp tanggal bayar waktu nyata (**WIB**).

- **Modul Kelola User (Khusus Administrator)**:
  - Manajemen akun staf dan administrator (Nama, Email, Role, Tanggal Dibuat).
  - Penggantian kata sandi aman dengan opsi melihat kata sandi (*toggle show/hide password*).
  - Proteksi *Self-Deletion Lockout*: Administrator tidak dapat menghapus akunnya sendiri yang sedang aktif digunakan.

---

## 👥 Hak Akses Pengguna

| Fitur / Menu | Administrator | Staff |
| :--- | :---: | :---: |
| **Melihat Dashboard & Grafik** | ✅ Ya | ❌ Tidak |
| **Melihat Daftar Pelanggan** | ✅ Ya | ✅ Ya |
| **Menambah Data Pelanggan** | ✅ Ya | ✅ Ya |
| **Mengubah Data Pelanggan** | ✅ Ya | ✅ Ya |
| **Menghapus Pelanggan (Soft Delete)** | ✅ Ya | ❌ Tidak |
| **Melihat Daftar Tagihan** | ✅ Ya | ✅ Ya |
| **Menambah Tagihan Pelanggan** | ✅ Ya | ❌ Tidak |
| **Melakukan Pembayaran Tagihan** | ✅ Ya | ❌ Tidak |
| **Kelola Data Pengguna (User)** | ✅ Ya | ❌ Tidak |

---

## 💻 Persyaratan Sistem

Pastikan lingkungan lokal Anda memenuhi spesifikasi berikut:

- **PHP**: Versi `^8.2` atau `^8.3` (dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer**: Versi `^2.x`
- **Node.js**: Versi `^18.x` atau `^20.x` & **npm**
- **Database Server**: MySQL `^8.0` atau MariaDB `^10.4` (misal via XAMPP, Laragon, Docker, atau instalasi native)

---

## 🛠️ Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan aplikasi dari awal:

### 1. Masuk ke Direktori Proyek
Buka terminal / PowerShell dan arahkan ke folder proyek:
```bash
cd "d:/Manajemen Pelanggan ISP/Manajemen-Pelanggan-ISP"
```

### 2. Pasang Dependensi PHP (Composer)
```bash
composer install
```

### 3. Pasang Dependensi Frontend (NPM)
```bash
npm install
```

### 4. Konfigurasi Environment File
Salin file `.env.example` menjadi `.env`:
- **Windows (PowerShell):**
  ```powershell
  copy .env.example .env
  ```
- **Linux / macOS:**
  ```bash
  cp .env.example .env
  ```

### 5. Generate Application Encryption Key
```bash
php artisan key:generate
```

### 6. Konfigurasi Database
Buka file `.env` pada teks editor Anda, sesuaikan konfigurasi koneksi database MySQL:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_pelanggan_isp
DB_USERNAME=root
DB_PASSWORD=
APP_TIMEZONE=Asia/Jakarta
```

> **Catatan:** Pastikan database dengan nama `manajemen_pelanggan_isp` telah dibuat di MySQL server Anda sebelum menjalankan langkah berikutnya.

### 7. Jalankan Migrasi dan Database Seeder
Jalankan perintah migrasi tabel basis data beserta pengisian data awal (*seeder*):
```bash
php artisan migrate --seed
```

Perintah di atas akan secara otomatis mengeksekusi migrasi tabel dan mengisi data seeder:
- Akun Pengguna (`John Doe` sebagai Administrator, `Jane Smith` sebagai Staff, dsb.).
- 26 Data Pelanggan ISP dengan nama standar (John Doe, Jane Smith, Robert Taylor, dsb.) beserta ragam paket dan status untuk pengujian pencarian, filter, dan pagination.
- Data Tagihan Pelanggan dengan berbagai periode bulan dan status pembayaran.

### 8. Kompilasi Aset Frontend (Tailwind CSS & JavaScript)
- **Untuk Produksi (Disarankan):**
  ```bash
  npm run build
  ```
- **Untuk Pengembangan (Hot Reloading):**
  ```bash
  npm run dev
  ```

### 9. Jalankan Web Server Lokal
Jalankan development server Laravel:
```bash
php artisan serve
```

Aplikasi siap diakses melalui peramban web pada alamat:
👉 **`http://127.0.0.1:8000`**

---

## 🔑 Akun Pengujian (Default Credentials)

Gunakan akun berikut untuk masuk dan menguji seluruh hak akses sistem:

### 1. Akun Administrator
- **Nama:** `John Doe`
- **Email:** `admin@isp.com`
- **Password:** `password`
- **Akses:** Akses penuh ke seluruh menu (Dashboard, Pelanggan, Tagihan, Kelola User, Hapus Data).

### 2. Akun Staff
- **Nama:** `Jane Smith`
- **Email:** `staff@isp.com`
- **Password:** `password`
- **Akses:** Terbatas untuk melihat dan mengelola data Pelanggan serta melihat Tagihan. Tidak memiliki hak akses Dashboard, Hapus Data, Pembayaran Tagihan, maupun Kelola User.

---

## 🧪 Menjalankan Pengujian Otomatis (Testing)

Aplikasi telah dilengkapi dengan pengujian unit dan fitur komprehensif menggunakan PHPUnit:

```bash
php artisan test
```

Cakupan pengujian otomatis meliputi:
- `CustomerManagementTest`: Autentikasi pelanggan, pencarian, sorting, validasi form, pengubahan data, dan soft delete.
- `InvoiceManagementTest`: Akses tagihan, filter status, pencarian, otorisasi bayar tagihan Administrator vs Staff.
- `UserManagementTest`: Proteksi akses Administrator, CRUD user, filter role, dan pencegahan hapus akun sendiri (*self-deletion lockout*).
- `UserAuthenticationTest`: Pengujian login, invalid credentials, pembatasan percobaan login (rate limiting / throttling), remember me cookie persistence, dan logout.
- `MasterLayoutAndAuthorizationTest`: Pengujian navigasi role-based, proteksi rute, dan keterlihatan menu sidebar.
- `DashboardOverviewTest`: Verifikasi perhitungan metrik agregasi bisnis dan visualisasi grafik tagihan.

---

## 📁 Struktur Proyek

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CustomerManagementController.php
│   │   │   ├── DashboardOverviewController.php
│   │   │   ├── InvoiceManagementController.php
│   │   │   ├── UserAuthenticationController.php
│   │   │   └── UserManagementController.php
│   │   ├── Middleware/
│   │   │   └── EnsureUserHasRole.php
│   │   └── Requests/
│   │       ├── CustomerStoreRequest.php
│   │       ├── CustomerUpdateRequest.php
│   │       ├── InvoiceStoreRequest.php
│   │       ├── UserStoreRequest.php
│   │       └── UserUpdateRequest.php
│   └── Models/
│       ├── Customer.php
│       ├── Invoice.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_03_18_000001_create_customers_table.php
│   │   └── 2026_03_18_000002_create_invoices_table.php
│   └── seeders/
│       ├── CustomerSeeder.php
│       ├── DatabaseSeeder.php
│       ├── InvoiceSeeder.php
│       └── UserSeeder.php
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   ├── components/
│   │   │   ├── alert.js
│   │   │   ├── dropdown.js
│   │   │   └── mobile-nav.js
│   │   ├── customers/
│   │   │   └── delete-modal.js
│   │   ├── invoices/
│   │   │   ├── create.js
│   │   │   └── payment.js
│   │   └── users/
│   │       ├── delete-modal.js
│   │       └── password-toggle.js
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── components/
│       │   ├── tactile-alert.blade.php
│       │   └── tactile-select.blade.php
│       ├── customers/
│       ├── dashboard/
│       ├── invoices/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── guest.blade.php
│       └── users/
├── routes/
│   └── web.php
└── tests/
    └── Feature/
```
