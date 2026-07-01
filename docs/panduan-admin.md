# Panduan Admin - PerpustakaanKU

Selamat datang di panduan administrator sistem manajemen perpustakaan PerpustakaanKU. Panduan ini akan membantu Anda mengelola seluruh fitur admin.

## Daftar Isi

1. [Login Admin](#login-admin)
2. [Dashboard Admin](#dashboard-admin)
3. [Manajemen Buku](#manajemen-buku)
4. [Manajemen User](#manajemen-user)
5. [Manajemen Peminjaman](#manajemen-peminjaman)
6. [Manajemen Reservasi](#manajemen-reservasi)
7. [Notifikasi](#notifikasi)
8. [Galeri](#galeri)
9. [Laporan & Statistik](#laporan--statistik)

---

## Login Admin

### Login sebagai Administrator

1. Buka halaman login di `http://domain-anda/login`
2. Masukkan kredensial admin:
   - **Username**: `admin`
   - **Password**: `password` (default, silakan ganti setelah login pertama)
3. Klik tombol "Masuk"
4. Anda akan diarahkan ke dashboard admin

### Keamanan

- **PENTING**: Ganti password default setelah login pertama
- Jangan bagikan kredensial admin kepada pihak yang tidak berwenang
- Logout setelah selesai bekerja

---

## Dashboard Admin

Dashboard admin menampilkan statistik penting:

- **Total Buku**: Jumlah seluruh buku di database
- **Sedang Dipinjam**: Jumlah buku yang sedang dalam status dipinjam
- **Total Anggota**: Jumlah seluruh user terdaftar

### Informasi Tambahan

- Statistik real-time yang diperbarui otomatis
- Data mencakup peminjaman online dan offline
- Membantu monitoring aktivitas perpustakaan

---

## Manajemen Buku

### Menambah Buku Baru

1. Klik menu **"Daftar Buku"** di sidebar
2. Klik tombol **"+ Tambah Buku"**
3. Isi formulir:
   - **Judul**: Judul lengkap buku
   - **Penulis**: Nama penulis
   - **Penerbit**: Nama penerbit
   - **Tahun**: Tahun terbit
   - **Kategori**: Kategori buku (fiksi, non-fiksi, dll)
   - **Deskripsi**: Deskripsi singkat buku
   - **Stok**: Jumlah stok tersedia
4. Klik tombol "Simpan"
5. Buku berhasil ditambahkan

### Mengedit Buku

1. Klik menu **"Daftar Buku"**
2. Cari buku yang ingin diedit
3. Klik tombol **"Edit"** pada buku tersebut
4. Ubah informasi yang diperlukan
5. Klik tombol "Update"
6. Perubahan berhasil disimpan

### Menghapus Buku

1. Klik menu **"Daftar Buku"**
2. Cari buku yang ingin dihapus
3. Klik tombol **"Hapus"**
4. Konfirmasi penghapusan
5. **PERHATIAN**: Buku yang dihapus tidak dapat dikembalikan

### Mengelola Stok

- Stok menentukan berapa banyak user bisa meminjam buku secara bersamaan
- Jika stok = 0, user harus melakukan reservasi
- Update stok saat:
  - Buku baru masuk (tambah stok)
  - Buku rusak/hilang (kurangi stok)

---

## Manajemen User

### Melihat Daftar User

1. Klik menu **"Data User"** di sidebar
2. Anda akan melihat daftar seluruh user terdaftar:
   - Nama
   - Username
   - Email
   - Role (admin/user)
   - Tanggal bergabung

### Role User

- **Admin**: Memiliki akses penuh ke seluruh fitur admin
- **User**: Hanya bisa mengakses fitur user biasa

### Menambah Admin Baru

Untuk menambah admin baru, Anda perlu:
1. Edit database langsung atau
2. Hubungi developer untuk membuat fitur tambah admin

### Menghapus User

- User yang dihapus akan kehilangan akses ke sistem
- Data peminjaman user akan tetap ada di database
- Pertimbangkan untuk menonaktifkan user alih-alih menghapus

---

## Manajemen Peminjaman

### Melihat Semua Peminjaman

1. Klik menu **"Peminjaman"** di sidebar
2. Anda akan melihat daftar seluruh peminjaman:
   - Peminjam (nama user atau nama peminjam offline)
   - Judul buku
   - Tanggal pinjam
   - Batas kembali
   - Tipe (Online/Offline)
   - Status (Dipinjam/Dikembalikan)

### Filter Peminjaman

Gunakan tab filter untuk melihat:
- **Semua**: Seluruh peminjaman
- **Online**: Peminjaman oleh user terdaftar
- **Offline**: Peminjaman manual oleh admin

### Menambah Peminjaman Offline

Untuk mencatat peminjaman secara manual (orang tanpa akun):

1. Klik tombol **"+ Tambah Offline"** di halaman peminjaman
2. Isi formulir:
   - **Nama Peminjam**: Nama lengkap peminjam
   - **Buku**: Pilih buku dari dropdown
   - **Tanggal Pinjam**: Tanggal peminjaman
   - **Batas Kembali**: Tanggal harus dikembalikan
   - **Catatan**: Catatan tambahan (opsional)
3. Klik "Simpan Peminjaman"
4. Peminjaman offline berhasil dicatat

### Menandai Buku Dikembalikan

1. Buka halaman **"Peminjaman"**
2. Cari peminjaman dengan status "Dipinjam"
3. Klik tombol **"Tandai Kembali"**
4. Sistem akan:
   - Mengubah status menjadi "Dikembalikan"
   - Menghitung denda jika terlambat
   - Menambah stok buku kembali
   - Memberitahu user berikutnya di antrian reservasi

### Denda Keterlambatan

- Denda otomatis dihitung: **Rp 1.000 per hari**
- Denda dihitung dari batas pengembalian
- Admin tidak perlu menghitung manual

### Perbedaan Peminjaman Online vs Offline

| Fitur | Online | Offline |
|-------|--------|---------|
| Peminjam | User terdaftar | Orang tanpa akun |
| Proses | User pinjam sendiri | Admin input manual |
| Tanggal | Otomatis hari ini | Manual |
| Batas Kembali | Otomatis 7 hari | Manual |
| Catatan | Tidak ada | Bisa ditambah |

---

## Manajemen Reservasi

### Melihat Daftar Reservasi

1. Klik menu **"Reservasi"** di sidebar (hanya admin)
2. Anda akan melihat daftar seluruh reservasi aktif:
   - Nama user
   - Judul buku
   - Status (Waiting/Notified)
   - Tanggal reservasi
   - Waktu notifikasi (jika sudah dinotifikasi)

### Status Reservasi

- **Waiting**: User masih menunggu antrian
- **Notified**: User sudah dinotifikasi bahwa buku tersedia
- **Cancelled**: Reservasi dibatalkan oleh user atau admin

### Proses Notifikasi Otomatis

Sistem akan otomatis:
1. Mendeteksi saat buku dikembalikan
2. Mencari user pertama di antrian (status Waiting)
3. Mengirim notifikasi ke user tersebut
4. Mengubah status menjadi "Notified"
5. Mencatat waktu notifikasi

### Membatalkan Reservasi

1. Buka halaman **"Reservasi"**
2. Cari reservasi yang ingin dibatalkan
3. Klik tombol **"Batalkan"**
4. Reservasi akan dibatalkan
5. Antrian akan bergeser

### Best Practices

- Monitor reservasi secara rutin
- Pastikan notifikasi berfungsi dengan baik
- Batalkan reservasi yang sudah lama tidak aktif

---

## Notifikasi

### Mengirim Notifikasi Broadcast

1. Klik menu **"Kirim Notifikasi"** di sidebar
2. Isi formulir:
   - **Judul**: Judul notifikasi
   - **Pesan**: Isi pesan notifikasi
3. Pilih penerima:
   - **Broadcast**: Kirim ke seluruh user
   - **Individual**: Kirim ke user tertentu
4. Klik "Kirim"
5. Notifikasi berhasil dikirim

### Melihat Riwayat Notifikasi

1. Klik menu **"Riwayat Notif"** di sidebar
2. Anda akan melihat daftar notifikasi yang pernah dikirim:
   - Judul
   - Pesan
   - Tanggal kirim
   - Jumlah penerima
   - Tipe (Broadcast/Individual)

### Menghapus Notifikasi

1. Buka halaman **"Riwayat Notif"**
2. Cari notifikasi yang ingin dihapus
3. Klik tombol **"Hapus"**
4. Notifikasi akan dihapus dari sistem

---

## Galeri

### Menambah Foto Galeri

1. Klik menu **"Galeri"** di sidebar
2. Klik tombol **"+ Tambah Foto"**
3. Upload foto kegiatan perpustakaan
4. Beri deskripsi jika diperlukan
5. Klik "Simpan"

### Mengelola Galeri

- Galeri untuk dokumentasi kegiatan perpustakaan
- Bisa menambah foto acara, workshop, dll
- User dapat melihat galeri di menu Galeri

### Menghapus Foto

1. Buka halaman **"Galeri"**
2. Cari foto yang ingin dihapus
3. Klik tombol **"Hapus"**
4. Foto akan dihapus dari sistem

---

## Laporan & Statistik

### Mencetak Laporan Peminjaman

1. Buka halaman **"Peminjaman"**
2. Pilih filter yang diinginkan (Semua/Online/Offline)
3. Klik tombol **"Cetak Laporan"**
4. Laporan akan di-generate dalam format PDF
5. Simpan atau print laporan

### Informasi dalam Laporan

- Daftar seluruh peminjaman sesuai filter
- Informasi peminjam
- Detail buku
- Tanggal peminjaman
- Status peminjaman
- Tanggal cetak laporan

### Monitoring Rutin

Sebaiknya lakukan monitoring:
- **Harian**: Cek peminjaman baru dan pengembalian
- **Mingguan**: Review statistik dan tren
- **Bulanan**: Generate laporan lengkap

---

## Troubleshooting

### User Tidak Bisa Meminjam Buku

**Masalah**: User melaporkan tidak bisa meminjam buku

**Solusi**:
- Cek stok buku di database
- Pastikan stok > 0
- Cek apakah user sudah meminjam buku yang sama
- Cek apakah user sudah ada di antrian reservasi

### Notifikasi Tidak Terkirim

**Masalah**: User tidak menerima notifikasi

**Solusi**:
- Cek konfigurasi notifikasi
- Pastikan user masih aktif
- Cek log error sistem
- Restart server jika perlu

### Stok Tidak Sesuai

**Masalah**: Stok di sistem tidak sesuai dengan fisik

**Solusi**:
- Lakukan stock opname fisik
- Update stok di database sesuai fisik
- Catat perbedaan untuk audit

### User Lupa Password

**Solusi**:
- Reset password user melalui database
- Berikan password sementara
- Minta user ganti password setelah login

---

## Best Practices untuk Admin

### Keamanan

1. **Ganti Password Default**
   - Ganti password admin segera setelah setup
   - Gunakan password yang kuat (minimal 8 karakter, kombinasi huruf, angka, simbol)

2. **Logout Rutin**
   - Selalu logout setelah selesai bekerja
   - Jangan biarkan session admin terbuka

3. **Backup Data**
   - Lakukan backup database secara rutin
   - Simpan backup di lokasi aman

### Manajemen Data

1. **Validasi Input**
   - Selalu validasi data sebelum disimpan
   - Cek duplikasi data

2. **Audit Trail**
   - Catat perubahan penting
   - Monitor aktivitas mencurigakan

3. **Konsistensi Data**
   - Pastikan stok selalu akurat
   - Update data secara real-time

### Layanan ke User

1. **Respon Cepat**
   - Tangani keluhan user dengan cepat
   - Berikan solusi yang jelas

2. **Komunikasi**
   - Berikan notifikasi untuk perubahan penting
   - Jelaskan aturan dengan jelas

3. **Transparansi**
   - Berikan informasi yang akurat
   - Jelaskan proses dengan jelas

---

## Maintenance Rutin

### Harian

- Cek peminjaman baru
- Proses pengembalian buku
- Monitor notifikasi
- Cek stok buku kritis

### Mingguan

- Review statistik peminjaman
- Cek reservasi yang lama
- Update data jika perlu
- Backup database

### Bulanan

- Generate laporan lengkap
- Review performa sistem
- Evaluasi kebutuhan buku baru
- Planning untuk improvement

---

## Hubungi Developer

Jika mengalami masalah teknis:

- Cek dokumentasi Laravel
- Review log error di `storage/logs`
- Hubungi tim developer untuk support teknis

---

**Terima kasih telah mengelola PerpustakaanKU!**
