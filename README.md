# Garuda Hub

**Garuda Hub** adalah aplikasi berbasis web yang dikembangkan untuk mempertemukan klien yang membutuhkan jasa pengembangan proyek dengan developer yang menawarkan layanan mereka. Melalui aplikasi ini, klien dapat membuat proyek dan menerima penawaran dari developer, sedangkan developer dapat mencari proyek dan mengajukan penawaran sesuai kemampuan mereka.

## Fitur Utama

### 1. Authentication & Role Management
- Registrasi dan login pengguna.
- Logout dengan pengelolaan session.
- Pembagian hak akses berdasarkan role.
- Terdapat tiga role: Admin, Klien, dan Developer.

### 2. Project Management
- Klien dapat membuat proyek baru.
- Klien dapat melihat, mengubah, dan menghapus proyek miliknya.
- Developer dapat melihat daftar proyek yang tersedia.
- Detail proyek menampilkan informasi kebutuhan dan anggaran proyek.

### 3. Bidding System
- Developer dapat mengajukan penawaran pada proyek.
- Penawaran mencakup harga, durasi pengerjaan, dan proposal.
- Developer dapat melihat daftar penawaran yang pernah diajukan.
- Klien dapat melihat penawaran yang masuk dan memilih developer sebagai pemenang.

### 4. Admin Panel
- Dashboard admin untuk melihat ringkasan data aplikasi.
- Manajemen data pengguna.
- Manajemen data proyek.
- Manajemen data penawaran.
- Fitur pencarian dan filter data.

## Teknologi yang Digunakan

- **Backend:** Laravel 13
- **Programming Language:** PHP 8.3
- **Database:** MySQL 8
- **Frontend:** Blade Template, HTML, CSS, dan JavaScript
- **Development Environment:** Laragon
- **Version Control:** Git dan GitHub

## Struktur Role Pengguna

| Role | Hak Akses |
|---|---|
| Admin | Mengelola dan memantau data pengguna, proyek, dan penawaran |
| Klien | Membuat dan mengelola proyek serta memilih developer |
| Developer | Melihat proyek dan mengajukan penawaran |

## Instalasi dan Menjalankan Proyek

### 1. Clone Repository

```bash
git clone https://github.com/aeliothh/GarudahubKelompokAmbulu.git
```

### 2. Masuk ke Folder Proyek

```bash
cd GarudahubKelompokAmbulu
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`, kemudian sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=garuda_hub
DB_USERNAME=root
DB_PASSWORD=
```

Buat database dengan nama `garuda_hub` melalui phpMyAdmin atau MySQL.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini membuat tabel dan mengisi database dengan data awal yang disediakan oleh seeder.

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

## Database

Garuda Hub menggunakan MySQL sebagai sistem manajemen basis data. Struktur database terdiri dari tabel-tabel yang mendukung pengelolaan pengguna, proyek, dan penawaran.

Relasi utama:
- User dapat memiliki banyak proyek sebagai klien.
- User dapat mengajukan banyak penawaran sebagai developer.
- Project dapat memiliki banyak penawaran.
- Setiap proyek dapat memiliki satu developer pemenang.

## Pengembangan

Proyek ini dikembangkan menggunakan Laravel dengan pendekatan MVC (Model-View-Controller). Pengelolaan source code dilakukan menggunakan Git dan GitHub untuk mendukung kolaborasi serta pencatatan perubahan selama proses pengembangan.

---

**Garuda Hub — Connecting Clients and Developers.**
