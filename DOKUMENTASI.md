# 📚 PerpustakaanKU — Dokumentasi Lengkap Sistem Manajemen Perpustakaan

---

## 1. Gambaran Umum Proyek

**PerpustakaanKU** adalah sistem manajemen perpustakaan berbasis web yang dibangun menggunakan framework Laravel. Sistem ini dirancang untuk memudahkan pengelolaan buku, peminjaman (online & offline), reservasi antrian, notifikasi, dan pelaporan — semuanya dalam satu platform yang modern, responsif, dan mendukung **Dark Mode**.

**Tujuan utama sistem:**
- Mendigitalisasi proses peminjaman buku di perpustakaan
- Memisahkan data peminjaman online (via akun user) dan offline (langsung via admin)
- Memberikan transparansi stok buku secara real-time kepada pengunjung
- Menyediakan laporan dan statistik peminjaman untuk administrator

---

## 2. Teknologi yang Digunakan (Tech Stack)

| Komponen | Teknologi |
|---|---|
| Backend Framework | **Laravel 13** (PHP 8.5) |
| Frontend Styling | **Bootstrap 5.3** + Vanilla CSS |
| Ikon | **Bootstrap Icons 1.11** |
| Font | **Inter** (Google Fonts) |
| Grafik | **Chart.js 4.4** |
| QR Code | **api.qrserver.com** (API eksternal) |
| Database | **MySQL** |
| Server Lokal | **php artisan serve** / XAMPP |
| Template Engine | **Blade** (bawaan Laravel) |

---

## 3. Persyaratan Sistem (Requirements)

Untuk menjalankan proyek ini, Anda membutuhkan:

- **PHP** versi 8.1 ke atas
- **Composer** (package manager PHP)
- **MySQL** (atau MariaDB via XAMPP/Laragon)
- **Node.js & NPM** (opsional, untuk assets)
- Browser modern (Chrome, Firefox, Brave, dll.)

### Cara Install & Menjalankan

```bash
# 1. Clone atau buka folder proyek
cd /home/ayata/Documents/latihan_laravel

# 2. Install dependensi PHP
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Set konfigurasi database di file .env
DB_DATABASE=latihan_laravel
DB_USERNAME=root
DB_PASSWORD=

# 5. Generate application key
php artisan key:generate

# 6. Jalankan migrasi database
php artisan migrate

# 7. Buat akun admin pertama
# Akses URL: http://127.0.0.1:8000/setup-admin

# 8. Jalankan server
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

---

## 4. Struktur Database

Berikut adalah semua tabel yang digunakan beserta penjelasannya:

### Tabel `users`
Menyimpan data semua pengguna (admin dan user biasa).

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| name | varchar | Nama lengkap pengguna |
| username | varchar | Username untuk login |
| email | varchar | Email pengguna |
| password | varchar | Password (ter-hash) |
| role | varchar | `admin` atau `user` |

---

### Tabel `books`
Menyimpan data koleksi buku perpustakaan.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| title | varchar | Judul buku |
| author | varchar | Nama penulis |
| publisher | varchar | Nama penerbit |
| year | integer | Tahun terbit |
| description | text | Sinopsis/deskripsi buku |
| category | varchar | Kategori buku (Fiksi, Sains, dll.) |
| stock | integer | Jumlah eksemplar yang dimiliki |

---

### Tabel `borrowings`
Menyimpan semua riwayat peminjaman buku.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint (nullable) | FK ke users — NULL jika peminjaman offline |
| borrower_name | varchar (nullable) | Nama manual jika peminjaman offline |
| book_id | bigint | FK ke books |
| borrow_date | date | Tanggal peminjaman |
| return_date | date | Batas tanggal pengembalian |
| status | varchar | `borrowed` atau `returned` |
| notes | text | Catatan tambahan (opsional) |
| fine | integer | Nominal denda keterlambatan (Rupiah) |

> **Catatan:** Jika `user_id` NULL maka ini adalah peminjaman **offline**. Jika berisi ID user maka ini peminjaman **online**.

---

### Tabel `reservations`
Menyimpan antrian reservasi buku yang sedang habis stok.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint | FK ke users |
| book_id | bigint | FK ke books |
| status | enum | `waiting`, `notified`, `cancelled`, `fulfilled` |
| notified_at | timestamp | Waktu notifikasi dikirim |

---

### Tabel `notifications`
Menyimpan notifikasi yang dikirim admin atau sistem.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint (nullable) | Target user — NULL jika broadcast |
| title | varchar | Judul notifikasi |
| message | text | Isi pesan notifikasi |
| is_broadcast | boolean | `true` jika dikirim ke semua user |

---

### Tabel `notification_reads`
Mencatat notifikasi mana yang sudah dibaca oleh user tertentu.

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| notification_id | bigint | FK ke notifications |
| user_id | bigint | FK ke users |

---

## 5. Fitur-Fitur Lengkap

### 🔐 A. Sistem Autentikasi
- **Login** menggunakan username + password
- **Register** akun user baru
- **Role-based access**: Admin memiliki akses penuh, User hanya bisa akses fitur tertentu
- **Logout** dengan CSRF protection
- Setup admin pertama via URL `/setup-admin`

---

### 📊 B. Dashboard Admin — Statistik Pintar

Dashboard admin menampilkan data analitik secara real-time:

| Widget | Penjelasan |
|---|---|
| Total Buku | Jumlah seluruh koleksi buku |
| Total User | Jumlah pengguna terdaftar (role: user) |
| Sedang Dipinjam | Jumlah buku yang statusnya `borrowed` |
| Terlambat | Buku yang melewati batas pengembalian |
| Grafik Bulanan | Line chart peminjaman per bulan (6 bulan terakhir) |
| Buku Paling Populer | Top 5 buku yang paling banyak dipinjam |
| User Paling Aktif | Top 5 user dengan peminjaman terbanyak |
| Kategori Favorit | Statistik jumlah buku per kategori |
| Peminjaman Terbaru | 5 aktivitas peminjaman paling baru |

---

### 📊 C. Dashboard User

Dashboard user menampilkan informasi personal:
- Jumlah buku yang sedang dipinjam
- Total riwayat peminjaman
- Jumlah keterlambatan
- Total akumulasi denda
- Daftar reservasi aktif (buku yang sedang di-booking)
- Tabel 5 riwayat peminjaman terakhir

---

### 📖 D. Manajemen Buku

**Untuk Admin:**
- Tambah buku baru (dengan field: judul, penulis, penerbit, tahun, kategori, stok, deskripsi)
- Edit data buku — dengan validasi agar stok tidak boleh dikurangi di bawah jumlah yang sedang dipinjam
- Hapus buku (dengan konfirmasi)
- Lihat QR Code setiap buku (untuk ditempel di buku fisik)
- Tampilan: **Tabel** dengan info stok tersedia

**Untuk User:**
- Melihat seluruh daftar buku dalam bentuk **Card Grid** yang menarik
- Setiap kartu menampilkan: kategori, status stok (Tersedia/Habis), judul, penulis, dan sinopsis singkat
- Tombol **"Detail"** untuk melihat informasi lengkap buku via pop-up modal
- Tombol **"Pinjam"** jika stok tersedia
- Tombol **"Booking"** (kuning) jika stok habis — untuk masuk antrian
- Tombol **QR Code** untuk melihat kode QR buku
- Fitur pencarian live (real-time filter judul/penulis)

---

### 🔄 E. Manajemen Peminjaman

**Peminjaman Online (oleh User):**
- User klik tombol "Pinjam" di halaman buku
- Sistem otomatis set tanggal pinjam = hari ini, batas kembali = 7 hari ke depan
- Sistem cek: apakah stok masih ada dan user belum meminjam buku yang sama
- Data tersimpan dengan `user_id` terisi

**Peminjaman Offline (oleh Admin):**
- Admin akses menu "Tambah Offline" di halaman Riwayat Peminjaman
- Admin isi: nama peminjam, pilih buku, tanggal pinjam, batas kembali, catatan (opsional)
- Data tersimpan dengan `user_id = NULL` dan `borrower_name` terisi

**Pengembalian Buku (Admin):**
- Admin klik "Tandai Kembali" di tabel riwayat
- Sistem otomatis hitung denda jika terlambat (Rp 1.000 × jumlah hari keterlambatan)
- Setelah buku dikembalikan, sistem otomatis cek antrian reservasi dan kirim notifikasi

**Filter Riwayat:**
- Admin bisa filter: Semua / Online / Offline
- Kolom yang ditampilkan: No, Peminjam, Judul Buku, Tgl Pinjam, Batas Kembali, Tipe, Status, Denda, Aksi

---

### 📅 F. Sistem Reservasi & Antrian

Fitur ini aktif ketika stok buku **habis**:

1. User menekan tombol **"Booking"** di halaman buku
2. Sistem memasukkan user ke **waiting list** (tabel `reservations`)
3. User melihat status reservasinya di Dashboard
4. User bisa **batalkan** reservasi kapan saja
5. Saat admin klik "Tandai Kembali" pada sebuah peminjaman:
   - Sistem otomatis ambil user **pertama** di antrian buku tersebut
   - Kirim **notifikasi otomatis** ke user tersebut: *"Buku yang Anda reservasi sudah tersedia!"*
   - Status reservasi berubah dari `waiting` → `notified`

**Admin** dapat melihat semua antrian aktif di halaman **"Antrian Reservasi"** (sidebar), lengkap dengan badge jumlah antrian.

---

### 💰 G. Sistem Denda Otomatis

- Denda dihitung **otomatis** saat admin menandai buku dikembalikan
- Tarif: **Rp 1.000 per hari keterlambatan**
- Rumus: `denda = (hari ini - batas kembali) × 1.000`
- Nominal denda ditampilkan di tabel riwayat dengan warna merah
- Denda juga muncul di laporan PDF dan di dashboard user (total akumulasi denda)
- Jika tidak terlambat, denda = Rp 0

---

### 🔔 H. Sistem Notifikasi

**Admin dapat:**
- Mengirim notifikasi manual ke **user tertentu** atau **broadcast ke semua user**
- Melihat riwayat semua notifikasi yang pernah dikirim

**User mendapat notifikasi:**
- Notifikasi manual dari admin
- Notifikasi otomatis dari sistem saat buku reservasi tersedia

**Fitur baca notifikasi:**
- Badge merah di sidebar menampilkan jumlah notifikasi belum dibaca
- User bisa klik "Tandai Dibaca" pada notifikasi individual
- Bisa tandai semua sebagai dibaca sekaligus

---

### 🖨️ I. Cetak Laporan PDF

- Admin dapat mengklik tombol **"Cetak PDF"** di halaman Riwayat Peminjaman
- Sistem merender halaman laporan dalam format cetak (print-friendly)
- Laporan berisi: No, Nama Peminjam, Judul Buku, Tgl Pinjam, Batas Kembali, Tipe (Online/Offline), Status, Denda
- Bisa filter sebelum cetak: Semua / Online / Offline
- Browser otomatis membuka dialog Print → bisa di-save sebagai PDF

---

### 📷 J. QR Code Buku

- Setiap buku memiliki QR Code unik yang berisi ID dan judul buku
- QR Code dihasilkan secara instan menggunakan API `api.qrserver.com` (tidak perlu install library)
- Tersedia untuk Admin maupun User — klik ikon QR Code di tabel/kartu buku
- Admin bisa klik kanan → Save Image untuk mencetak dan menempelkan di fisik buku
- Konten QR Code: `PerpustakaanKU|ID:{id}|{judul buku}`

---

### 🌙 K. Dark Mode

- Tombol toggle Dark/Light Mode tersedia di pojok kanan atas (topbar)
- Preferensi tersimpan di `localStorage` browser — tidak hilang saat refresh atau menutup tab
- Seluruh elemen UI menyesuaikan: sidebar, card, tabel, form, modal, badge, dropdown
- Menggunakan CSS Variables (`--bg-primary`, `--text-primary`, dll.) untuk konsistensi tema

---

### 📱 L. Responsif (Mobile-Friendly)

- Layout sidebar tersembunyi di mobile, bisa dibuka via tombol hamburger ☰
- Overlay gelap muncul saat sidebar terbuka di mobile
- Semua form, tabel, dan kartu menggunakan Bootstrap grid yang responsif
- Tabel menggunakan `table-responsive` agar bisa di-scroll horizontal di layar kecil

---

## 6. Struktur File Penting

```
latihan_laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # Login, Register, Logout
│   │   ├── BookController.php          # CRUD Buku + validasi stok
│   │   ├── BorrowingController.php     # Peminjaman online, offline, return, print
│   │   ├── DashboardController.php     # Dashboard admin (stats) & user
│   │   ├── GalleryController.php       # Manajemen galeri foto
│   │   ├── NotificationController.php  # Kirim & baca notifikasi
│   │   ├── ReservationController.php   # Antrian reservasi buku
│   │   └── UserController.php          # Daftar user (admin)
│   └── Models/
│       ├── Book.php                    # Model buku + relasi + helper stok
│       ├── Borrowing.php               # Model peminjaman + scope online/offline
│       ├── Notification.php            # Model notifikasi
│       ├── NotificationRead.php        # Model tanda baca notifikasi
│       ├── Reservation.php             # Model reservasi antrian
│       └── User.php                    # Model user + isAdmin()
│
├── database/migrations/
│   ├── ...create_users_table
│   ├── ...create_books_table
│   ├── ...create_borrowings_table
│   ├── ...create_notifications_table
│   ├── ...add_offline_borrowing_fields_to_borrowings_table
│   ├── ...add_notes_to_borrowings_table
│   ├── ...add_fine_to_borrowings_table
│   └── ...add_stock_category_and_reservations   # Stok, Kategori, Reservasi
│
├── resources/views/
│   ├── layout.blade.php                # Master layout (sidebar, topbar, dark mode)
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── books/
│   │   ├── index.blade.php             # Daftar buku (grid user / tabel admin)
│   │   ├── create.blade.php            # Form tambah buku
│   │   └── edit.blade.php              # Form edit buku
│   ├── borrowings/
│   │   ├── index.blade.php             # Riwayat peminjaman + filter
│   │   ├── create_offline.blade.php    # Form tambah offline
│   │   └── print.blade.php             # Template cetak PDF
│   ├── dashboard/
│   │   ├── admin.blade.php             # Dashboard admin + chart + statistik
│   │   └── user.blade.php              # Dashboard user personal
│   ├── notifications/
│   │   ├── index.blade.php             # Daftar notifikasi user
│   │   └── create.blade.php            # Form kirim notifikasi (admin)
│   └── reservations/
│       └── index.blade.php             # Daftar antrian reservasi (admin)
│
└── routes/web.php                      # Semua definisi URL/route
```

---

## 7. Daftar Rute (URL) Aplikasi

| Method | URL | Fungsi | Akses |
|---|---|---|---|
| GET | `/` | Redirect ke `/dashboard` | Semua |
| GET | `/login` | Halaman login | Guest |
| POST | `/login` | Proses login | Guest |
| GET | `/register` | Halaman registrasi | Guest |
| POST | `/register` | Proses registrasi | Guest |
| POST | `/logout` | Proses logout | Auth |
| GET | `/dashboard` | Dashboard (admin/user) | Auth |
| GET | `/books` | Daftar buku | Auth |
| GET | `/books/create` | Form tambah buku | Admin |
| POST | `/books` | Simpan buku baru | Admin |
| GET | `/books/{id}/edit` | Form edit buku | Admin |
| PUT | `/books/{id}` | Update buku | Admin |
| DELETE | `/books/{id}` | Hapus buku | Admin |
| GET | `/borrowings` | Riwayat peminjaman | Auth |
| POST | `/borrowings/{book}` | Pinjam buku online | Auth |
| PUT | `/borrowings/{id}/return` | Tandai dikembalikan | Admin |
| GET | `/offline-borrowings/create` | Form tambah offline | Admin |
| POST | `/offline-borrowings/store` | Simpan peminjaman offline | Admin |
| GET | `/borrowings/print` | Cetak laporan PDF | Admin |
| POST | `/reservations/{book}` | Booking buku ke antrian | Auth |
| DELETE | `/reservations/{id}/cancel` | Batalkan reservasi | Auth/Admin |
| GET | `/reservations` | Daftar antrian reservasi | Admin |
| GET | `/notifications` | Daftar notifikasi | Auth |
| POST | `/notifications/{id}/read` | Tandai notifikasi dibaca | Auth |
| POST | `/notifications/mark-all-read` | Tandai semua dibaca | Auth |
| GET | `/notifications/create` | Form kirim notifikasi | Admin |
| POST | `/notifications` | Kirim notifikasi | Admin |
| DELETE | `/notifications/{id}` | Hapus notifikasi | Admin |
| GET | `/users` | Daftar semua user | Admin |
| GET | `/setup-admin` | Buat akun admin pertama | Publik |

---

## 8. Alur Kerja Sistem (Flow)

### Alur Peminjaman Online
```
User login → Buka Daftar Buku → Klik "Pinjam" 
→ Sistem cek stok & duplikasi 
→ Jika tersedia: Borrowing dibuat (status: borrowed)
→ Redirect ke Riwayat Peminjaman dengan pesan sukses
```

### Alur Peminjaman Offline
```
Admin → Halaman Riwayat Peminjaman → Klik "Tambah Offline"
→ Isi form (nama, buku, tanggal, catatan)
→ Simpan → Data masuk sebagai user_id=NULL
```

### Alur Pengembalian & Denda
```
Admin → Klik "Tandai Kembali" 
→ Sistem hitung denda otomatis (jika terlambat)
→ Update status → returned, simpan nominal denda
→ Sistem cek antrian reservasi buku ini
→ Kirim notifikasi ke user pertama dalam antrian
```

### Alur Reservasi/Booking
```
User → Buku habis stok → Klik "Booking"
→ Sistem tambah ke tabel reservations (status: waiting)
→ User melihat status antrian di Dashboard
→ Saat buku dikembalikan → Notifikasi otomatis dikirim
→ User login → Lihat notifikasi → Langsung pinjam
```

---

## 9. Akun Default

Setelah menjalankan `/setup-admin`, akun berikut tersedia:

| Field | Nilai |
|---|---|
| Username | `admin` |
| Email | `admin@gmail.com` |
| Password | `password` |
| Role | `admin` |

---

## 10. Catatan Pengembang

- Semua halaman menggunakan `@extends('layout')` untuk konsistensi tampilan
- Dark mode diimplementasikan menggunakan CSS Variables dan `data-theme` attribute pada `<html>`
- Preferensi tema tersimpan di `localStorage` dan dimuat saat halaman pertama dibuka
- Model `Borrowing` memiliki helper `getBorrowerDisplayNameAttribute()` yang otomatis mengembalikan nama user (online) atau `borrower_name` (offline)
- `Book::isAvailable()` mengecek apakah `availableStock() > 0` (stok - jumlah yang sedang dipinjam)
- Notifikasi reservasi dikirim secara **synchronous** (saat return diproses), bukan menggunakan queue Laravel
- QR Code tidak memerlukan library tambahan — menggunakan API publik gratis `api.qrserver.com`
- Grafik Chart.js otomatis menyesuaikan warna teks dan grid berdasarkan tema aktif (light/dark)

---

*Dokumentasi ini dibuat untuk proyek PerpustakaanKU — Sistem Manajemen Perpustakaan Digital.*
*Versi: 2.0 | Terakhir diperbarui: Mei 2026*
