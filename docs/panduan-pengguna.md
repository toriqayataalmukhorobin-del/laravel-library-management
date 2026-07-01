# Panduan Pengguna - PerpustakaanKU

Selamat datang di sistem manajemen perpustakaan PerpustakaanKU. Panduan ini akan membantu Anda menggunakan semua fitur yang tersedia.

## Daftar Isi

1. [Registrasi & Login](#registrasi--login)
2. [Dashboard](#dashboard)
3. [Mencari & Melihat Buku](#mencar--melihat-buku)
4. [Meminjam Buku](#meminjam-buku)
5. [Reservasi Buku](#reservasi-buku)
6. [Riwayat Peminjaman](#riwayat-peminjaman)
7. [Notifikasi](#notifikasi)
8. [Galeri](#galeri)

---

## Registrasi & Login

### Registrasi Akun Baru

1. Buka halaman login di `http://domain-anda/login`
2. Klik link "Daftar disini" di bagian bawah
3. Isi formulir pendaftaran:
   - **Nama Lengkap**: Nama lengkap Anda
   - **Username**: Username unik untuk login (hanya huruf, angka, underscore, dan strip)
   - **Email**: Alamat email aktif
   - **Password**: Minimal 6 karakter
   - **Konfirmasi Password**: Ulangi password Anda
4. Klik tombol "Daftar Sekarang"
5. Akun Anda berhasil dibuat!

### Login

1. Buka halaman login di `http://domain-anda/login`
2. Masukkan **Username** dan **Password**
3. Klik tombol "Masuk"
4. Anda akan diarahkan ke dashboard

---

## Dashboard

Dashboard menampilkan ringkasan aktivitas perpustakaan:

- **Total Buku**: Jumlah seluruh buku yang tersedia di perpustakaan
- **Sedang Dipinjam**: Jumlah buku yang sedang dipinjam oleh anggota
- **Total Anggota**: Jumlah seluruh anggota terdaftar

---

## Mencari & Melihat Buku

### Melihat Daftar Buku

1. Klik menu **"Daftar Buku"** di sidebar
2. Anda akan melihat daftar seluruh buku yang tersedia
3. Setiap buku menampilkan:
   - Judul buku
   - Penulis
   - Penerbit
   - Tahun terbit
   - Kategori
   - Stok tersedia

### Informasi Stok

- **Stok Tersedia**: Buku dapat langsung dipinjam
- **Stok Habis**: Buku tidak tersedia, Anda bisa melakukan reservasi

---

## Meminjam Buku

### Meminjam Buku Secara Online

1. Buka halaman **"Daftar Buku"**
2. Cari buku yang ingin dipinjam
3. Pastikan stok buku masih tersedia
4. Klik tombol **"Pinjam"** pada buku tersebut
5. Sistem akan otomatis:
   - Mencatat tanggal peminjaman (hari ini)
   - Mengatur batas pengembalian (7 hari)
   - Mengurangi stok buku

### Aturan Peminjaman

- Masa peminjaman: **7 hari**
- Satu user hanya bisa meminjam **1 eksemplar** buku yang sama secara bersamaan
- Jika stok habis, gunakan fitur **Reservasi**

### Denda Keterlambatan

- Denda: **Rp 1.000 per hari** keterlambatan
- Denda dihitung dari batas pengembalian

---

## Reservasi Buku

### Kapan Perlu Reservasi?

Gunakan fitur reservasi ketika:
- Stok buku habis
- Buku sedang dipinjam oleh anggota lain

### Cara Melakukan Reservasi

1. Buka halaman **"Daftar Buku"**
2. Cari buku yang ingin direservasi
3. Pastikan stok buku **habis**
4. Klik tombol **"Reservasi"**
5. Anda akan masuk ke antrian
6. Sistem akan menampilkan posisi antrian Anda

### Notifikasi Reservasi

- Anda akan menerima notifikasi saat buku tersedia
- Notifikasi akan muncul di menu **"Notifikasi"**
- Setelah menerima notifikasi, segera pinjam buku sebelum antrian berlanjut

### Membatalkan Reservasi

1. Buka halaman **"Daftar Buku"**
2. Cari buku yang sedang Anda reservasi
3. Klik tombol **"Batalkan Reservasi"**
4. Reservasi Anda akan dibatalkan

---

## Riwayat Peminjaman

### Melihat Riwayat Peminjaman

1. Klik menu **"Peminjaman"** di sidebar
2. Anda akan melihat daftar seluruh peminjaman Anda:
   - Judul buku
   - Tanggal pinjam
   - Batas kembali
   - Status (Dipinjam/Dikembalikan)

### Status Peminjaman

- **Dipinjam**: Buku masih dalam peminjaman Anda
- **Dikembalikan**: Buku sudah dikembalikan

---

## Notifikasi

### Melihat Notifikasi

1. Klik menu **"Notifikasi"** di sidebar
2. Anda akan melihat daftar notifikasi:
   - Buku tersedia untuk reservasi
   - Pengumuman dari admin
   - Informasi penting lainnya

### Menandai Notifikasi sebagai Dibaca

- Notifikasi yang belum dibaca akan ditandai dengan badge
- Klik notifikasi untuk menandainya sebagai dibaca

---

## Galeri

### Melihat Galeri

1. Klik menu **"Galeri"** di sidebar
2. Anda akan melihat foto-foto kegiatan perpustakaan
3. Galeri berisi dokumentasi aktivitas perpustakaan

---

## Tips & Best Practices

1. **Pinjam Buku dengan Bijak**
   - Pinjam hanya buku yang benar-benar Anda butuhkan
   - Kembalikan tepat waktu untuk menghindari denda

2. **Reservasi Cerdas**
   - Reservasi hanya jika Anda benar-benar ingin membaca buku tersebut
   - Segera pinjam setelah menerima notifikasi ketersediaan

3. **Cek Notifikasi Secara Rutin**
   - Cek notifikasi secara berkala untuk informasi penting
   - Jangan lewatkan kesempatan untuk meminjam buku yang Anda reservasi

---

## Troubleshooting

### Tidak Bisa Meminjam Buku

**Masalah**: Tombol pinjam tidak berfungsi

**Solusi**:
- Pastikan Anda sudah login
- Pastikan stok buku masih tersedia
- Cek apakah Anda sudah meminjam buku yang sama

### Tidak Bisa Reservasi

**Masalah**: Tombol reservasi tidak berfungsi

**Solusi**:
- Pastikan stok buku benar-benar habis
- Cek apakah Anda sudah ada di antrian untuk buku tersebut
- Pastikan Anda tidak sedang meminjam buku tersebut

### Lupa Password

**Solusi**:
- Hubungi admin untuk reset password
- Admin akan membantu Anda membuat password baru

---

## Hubungi Admin

Jika Anda mengalami masalah atau memiliki pertanyaan:

- Hubungi admin perpustakaan secara langsung
- Kirim email ke admin perpustakaan
- Kunjungi perpustakaan untuk bantuan langsung

---

**Terima kasih telah menggunakan PerpustakaanKU!**
