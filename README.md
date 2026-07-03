
# 📚 Sistem Manajemen Perpustakaan (Laravel)

<p align="center">
  <img src="https://readme-typing-svg.herokuapp.com?font=Fira+Code&weight=600&size=24&pause=1000&color=36BCF7&center=true&vCenter=true&width=700&lines=Aplikasi+Perpustakaan+Berbasis+Web;Dibuat+dengan+Laravel+Framework;Sistem+Peminjaman+Buku+Digital" alt="Typing SVG" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Framework-Laravel-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel" />
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Status-Development-orange?style=for-the-badge" alt="Status" />
</p>

---

### 📝 Tentang Proyek

Aplikasi ini adalah **Sistem Informasi Manajemen Perpustakaan** yang dirancang untuk mendigitalisasi proses administrasi pada perpustakaan sekolah atau umum. Sistem ini mempermudah pengelolaan data buku, pencatatan anggota, hingga transaksi peminjaman secara *real-time*.

---

### 🚀 Fitur Utama Aplikasi

- 🔐 **Sistem Autentikasi:** Login dan registrasi yang aman untuk Admin dan Anggota Perpustakaan.
- 📖 **Manajemen Buku (CRUD):** Mengelola data buku, kategori, penerbit, dan penulis secara terstruktur.
- 🔄 **Transaksi Peminjaman:** Pencatatan otomatis untuk buku yang dipinjam, batas waktu pengembalian, dan riwayat sanksi/denda.
- 📊 **Dashboard Statistik:** Halaman ringkasan informasi jumlah total buku, anggota aktif, dan grafik peminjaman.

---

### 🛠️ Kebutuhan Sistem (Tech Stack)

<p align="left">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=php,laravel,mysql,html,css,js,bootstrap,vscode&theme=dark" />
  </a>
</p>

| Komponen | Versi / Kebutuhan |
| :--- | :--- |
| **Bahasa Pemrograman** | PHP >= 8.1 |
| **Framework** | Laravel >= 10.x |
| **Database Server** | MySQL / MariaDB |
| **Package Manager** | Composer |
| **Local Server** | XAMPP / Laragon |

---

## 💻 Panduan Cara Pemasangan (Lokal)

Ikuti langkah-langkah di bawah ini secara urut untuk menjalankan aplikasi ini di komputer kamu:

### 1. Unduh (Clone) Repositori
Buka terminal, Git Bash, atau Command Prompt (CMD), lalu jalankan perintah berikut:
```bash
git clone [https://github.com/toriqayataalmukhorobin-del/laravel-library-management.git](https://github.com/toriqayataalmukhorobin-del/laravel-library-management.git)
cd laravel-library-management

```
### 2. Pasang Package Dependency
Unduh semua pustaka (*library*) PHP yang dibutuhkan oleh Laravel menggunakan Composer:
```bash
composer install

```
### 3. Konfigurasi Environment File
Salin file template konfigurasi bawaan untuk membuat file .env baru:
```bash
cp .env.example .env

```
Buka file .env tersebut menggunakan code editor (seperti VS Code) lalu sesuaikan bagian konfigurasi database berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=

```
> ⚠️ **PENTING:** Buka aplikasi **XAMPP**, aktifkan Apache dan MySQL, lalu masuk ke localhost/phpmyadmin. Buatlah sebuah database baru yang kosong dengan nama db_perpustakaan.
> 
### 4. Buat Application Security Key
Jalankan perintah ini untuk membuat kunci keamanan enkripsi aplikasi:
```bash
php artisan key:generate

```
### 5. Migrasi dan Pengisian Database
Buat semua tabel perpustakaan secara otomatis ke dalam database beserta data awal/sampelnya (*seeding*):
```bash
php artisan migrate --seed

```
### 6. Hubungkan Folder Penyimpanan (Opsional)
Jika aplikasi kamu memiliki fitur unggah gambar (seperti foto sampul buku atau foto profil), jalankan perintah tautan ini:
```bash
php artisan storage:link

```
### 7. Jalankan Server Lokal
Nyalakan server development internal Laravel:
```bash
php artisan serve

```
Aplikasi sekarang sudah aktif! Buka browser kamu dan akses tautan berikut:
👉 **http://127.0.0.1:8000**
## 📁 Struktur Dokumen Utama
 * app/Http/Controllers — Berisi logika utama aplikasi untuk mengatur sirkulasi buku dan user.
 * database/migrations — Cetak biru (*blueprint*) pembuatan tabel database perpustakaan.
 * resources/views — Tampilan antarmuka (*user interface*) menggunakan Blade template Laravel.
 * routes/web.php — Berisi pengaturan rute URL untuk menghubungkan halaman web.
```

```


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

