# Rules & Spesifikasi — Aplikasi Manajemen Pelanggan ISP

> Dokumen ini adalah **acuan wajib**. Seluruh isi pada bagian **A (Ketentuan Pengerjaan)** dan **B (Studi Kasus)** berasal dari soal asli dan **tidak boleh diubah, dikurangi, atau ditafsirkan ulang**. Bagian **C (Aturan Tambahan untuk AI)** adalah aturan tambahan yang berlaku bersamaan dengan bagian A dan B.

---

## A. Ketentuan Pengerjaan

1. Backend wajib menggunakan Laravel versi terbaru.
2. Database menggunakan MySQL.
3. Frontend wajib dibuat sendiri (custom UI).
4. Dilarang menggunakan template admin siap pakai seperti:
   - AdminLTE
   - Metronic
   - Sneat
   - CoreUI
   - Tabler
   - Template premium maupun template gratis lainnya
5. Diperbolehkan menggunakan:
   - Bootstrap
   - Tailwind CSS
   - Alpine.js
   - jQuery
6. Source code harus menggunakan Git.
7. Kode program harus mengikuti standar clean code dan mudah dipahami.
8. Hasil pengerjaan dikirim dalam bentuk:
   - Source code melalui Git Repository (GitHub/GitLab)
   - Dokumentasi instalasi dan penggunaan aplikasi

---

## B. Studi Kasus

Buat sebuah aplikasi web "Manajemen Pelanggan ISP" yang digunakan untuk mengelola
data pelanggan internet dan tagihan pelanggan.

### Modul Autentikasi

#### Login

Pengguna harus dapat melakukan login menggunakan:

- Email
- Password

#### Hak Akses Pengguna

Terdapat dua jenis pengguna:

##### Administrator

Administrator memiliki akses penuh terhadap seluruh fitur aplikasi.

**Hak Akses Administrator**

- Kelola User
- Kelola Pelanggan
- Kelola Tagihan
- Melihat Dashboard
- Menghapus Data

##### Staff

Staff memiliki akses terbatas.

**Hak Akses Staff**

- Melihat Data Pelanggan
- Menambah Pelanggan
- Mengubah Data Pelanggan
- Melihat Tagihan

**Staff Tidak Dapat**

- Menghapus Data
- Mengelola User

### Modul User

Fitur ini hanya dapat diakses oleh Administrator.

#### Daftar User

Menampilkan informasi:

- Nama
- Email
- Role
- Tanggal Dibuat

#### Tambah User

Field:

- Nama
- Email
- Password
- Role

#### Edit User

Administrator dapat mengubah data pengguna.

#### Hapus User

Administrator dapat menghapus data pengguna.

### Modul Pelanggan

#### Struktur Data Pelanggan

Field yang harus tersedia:

- Nama Pelanggan
- Nomor Telepon
- Alamat
- Paket Internet
- Harga Paket
- Status Pelanggan

#### Status Pelanggan

- Aktif
- Suspend
- Putus

#### Fitur Pelanggan

##### Daftar Pelanggan

Menampilkan data pelanggan dalam bentuk tabel.

Fitur yang wajib tersedia:

- Pencarian Data
- Pagination
- Sorting Data

##### Tambah Pelanggan

Wajib menggunakan validasi data.

##### Edit Pelanggan

Pengguna dapat mengubah data pelanggan.

##### Hapus Pelanggan

Menggunakan Soft Delete Laravel.

### Modul Tagihan

Setiap pelanggan dapat memiliki lebih dari satu tagihan.

#### Struktur Data Tagihan

Field:

- Pelanggan
- Periode Tagihan
- Nominal Tagihan
- Status Pembayaran
- Tanggal Pembayaran

#### Status Pembayaran

- Belum Bayar
- Lunas

#### Fitur Tagihan

##### Daftar Tagihan

Menampilkan seluruh data tagihan pelanggan.

##### Tambah Tagihan

Menambahkan tagihan baru untuk pelanggan.

##### Pembayaran Tagihan

Saat tombol "Bayar" ditekan:

- Status berubah menjadi "Lunas"
- Tanggal pembayaran otomatis tersimpan

### Dashboard

Dashboard harus menampilkan informasi ringkas mengenai kondisi bisnis.

#### Statistik

Tampilkan:

- Total Pelanggan
- Total Pelanggan Aktif
- Total Pelanggan Suspend
- Total Pelanggan Putus
- Total Tagihan Belum Bayar

#### Grafik

Tampilkan grafik jumlah tagihan per bulan.

Jenis grafik bebas (Bar Chart atau Line Chart).

### Dokumentasi

Kandidat wajib menyediakan dokumentasi yang berisi:

1. Cara instalasi aplikasi
2. Konfigurasi environment
3. Cara menjalankan migration
4. Cara menjalankan seeder
5. Cara menjalankan aplikasi

---

## C. Aturan Tambahan untuk AI

Aturan di bagian ini bersifat **wajib** dan berlaku untuk setiap AI/asisten/agent (termasuk Antigravity) yang mengerjakan atau membantu proyek ini.

### C.1 Larangan Penggunaan Git oleh AI

1. AI **dilarang** menjalankan perintah atau syntax Git apa pun secara mandiri, tanpa pengecualian. Termasuk namun tidak terbatas pada:
   - `git init`, `git clone`
   - `git add`, `git commit`, `git commit --amend`
   - `git pull`, `git fetch`, `git push`
   - `git merge`, `git rebase`, `git cherry-pick`
   - `git checkout`, `git switch`, `git branch`, `git tag`
   - `git stash`, `git reset`, `git revert`, `git restore`, `git clean`
   - `git remote`, `git config`, `git submodule`
2. AI **dilarang** membuat commit, pull, push, atau mengubah state repository Git dalam bentuk apa pun secara otomatis, termasuk melalui script, hook, tool, atau perintah terminal.
3. AI **diperbolehkan** menginformasikan kepada pengguna:
   - syntax Git yang perlu dijalankan,
   - langkah-langkah Git yang sebaiknya dilakukan,
   - saran pesan commit,
   
   dengan syarat seluruh perintah tersebut **hanya ditampilkan sebagai informasi** dan **dijalankan sendiri oleh pengguna**.
4. Jika sebuah tugas membutuhkan tindakan Git, AI harus **berhenti dan memberi tahu pengguna** apa yang perlu dilakukan, bukan menjalankannya.

### C.2 Larangan Mencantumkan Author

1. AI **dilarang** mencantumkan nama author, kredit, atau atribusi apa pun yang menyebutkan bahwa proyek atau kode dikerjakan oleh AI, misalnya **Antigravity**, atau AI/tool lainnya.
2. Larangan ini berlaku di semua tempat, termasuk namun tidak terbatas pada:
   - komentar kode dan header file (misalnya `@author`, `Created by`, `Generated by`)
   - `README.md`, dokumentasi instalasi dan penggunaan, serta file `.md` lainnya
   - `composer.json`, `package.json`, dan file konfigurasi lainnya (field `authors`, dan sejenisnya)
   - pesan commit atau saran pesan commit (termasuk `Co-authored-by` dan sejenisnya)
   - footer, halaman "about", metadata, dan teks pada UI aplikasi
   - nama file, nama folder, dan seed data
3. Tidak boleh ada satu pun penyebutan nama AI/tool yang digunakan di dalam source code maupun dokumentasi hasil pengerjaan.

### C.3 Penamaan Fungsi dan Kode

1. Nama fungsi/method harus **mencerminkan dan menjelaskan fungsi dari kodenya**. Pembaca harus bisa memahami apa yang dilakukan sebuah fungsi hanya dari namanya, tanpa membaca isinya.
2. Nama fungsi harus berupa kata kerja yang spesifik dan deskriptif.
   - Contoh baik: `markInvoiceAsPaid()`, `getActiveCustomers()`, `calculateMonthlyInvoiceTotal()`, `validateCustomerData()`
   - Contoh buruk: `process()`, `handle()`, `doIt()`, `data()`, `update2()`, `temp()`
3. Aturan yang sama berlaku untuk nama variabel, class, model, controller, dan route agar maksud kodenya jelas.
4. Singkatan yang tidak umum dan nama generik yang tidak menjelaskan maksud **dilarang**.
5. Penamaan harus konsisten di seluruh proyek (satu bahasa dan satu gaya penulisan).

### C.4 Constraint Wajib Ditulis Secara Eksplisit

1. Setiap constraint **wajib ditulis secara eksplisit di dalam kode**, meskipun Laravel sebenarnya sudah dapat memahaminya secara otomatis lewat konvensi atau fitur bawaannya. Kode tidak boleh bergantung pada perilaku implisit Laravel.
2. Pada **migration**, tuliskan secara eksplisit:
   - foreign key beserta tabel referensinya dan aksi `onDelete` / `onUpdate`, tidak cukup dengan `constrained()` tanpa parameter
   - `unique`, `index`, `nullable`, `default`, panjang kolom, dan tipe data setiap kolom
   - nilai yang diizinkan untuk kolom status (Aktif, Suspend, Putus, Belum Bayar, Lunas)
   - kolom `softDeletes()` pada tabel yang menggunakan Soft Delete
3. Pada **model**, tuliskan secara eksplisit:
   - nama tabel (`$table`)
   - `$fillable`, `$casts`, dan trait seperti `SoftDeletes`
   - relasi beserta nama foreign key dan local key-nya (misalnya `hasMany(Invoice::class, 'customer_id', 'id')`)
4. Pada **validasi**, tuliskan seluruh aturan setiap field secara eksplisit (required, tipe, panjang, unique, `in:`, dan sebagainya), dan sertakan pesan error bila diperlukan.
5. Pada **route**, tuliskan nama route dan middleware hak akses (Administrator/Staff) secara eksplisit pada setiap route, tidak mengandalkan asumsi implisit.

### C.5 Kepatuhan terhadap Spesifikasi

1. AI **dilarang** mengubah, mengurangi, atau menafsirkan ulang isi bagian A dan B.
2. Jika ada bagian spesifikasi yang kurang jelas, AI harus **bertanya kepada pengguna** terlebih dahulu dan tidak boleh berasumsi sendiri.
