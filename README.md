# 📚 App Perpustakaan Digital Kampus

Aplikasi web untuk mengelola sistem perpustakaan digital kampus, dibangun menggunakan **Laravel 12** sebagai bagian dari mata kuliah Workshop Pemrograman Framework - Semester 3 PENS.

---

## 📖 Tentang Aplikasi

**App Perpustakaan** adalah sistem manajemen perpustakaan modern berbasis web yang digunakan oleh petugas dan admin untuk mengelola:
- **Kategori Buku:** Pengelompokan buku (Novel, Komik, Sains, Teknologi, Sejarah, dll.) khusus role Admin.
- **Data Buku:** Katalog buku lengkap dengan relasi kategori, stok, penerbit, dan ISBN.
- **Data Anggota:** Registrasi mahasiswa/anggota perpustakaan kampus.
- **Transaksi Peminjaman & Pengembalian:** Peminjaman multi-buku, pencatatan otomatis petugas bertugas, dan pelacakan status (`dipinjam`, `dikembalikan`, `terlambat`).
- **Dashboard Statistik:** Ringkasan statistik (total buku, total anggota, peminjaman aktif) yang dikonsumsi langsung dari endpoint REST API internal via Laravel HTTP Client.
- **Laporan Peminjaman:** Rekap transaksi yang disajikan via konsumsi endpoint REST API internal.
- **REST API Lengkap:** Endpoint `/api/books`, `/api/members`, `/api/loans`, dan `/api/stats` dengan API Resource terstandar JSON.
- **Seeder & Factory Realistis:** Data dummy kurasi bergaya Indonesia (locale `id_ID`, nama penerbit asli, dan email kampus `@pens.ac.id`).

---

## 🚀 Cara Menjalankan Project Secara Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB (e.g. XAMPP)
- Git

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/riansaputraa/app-perpustakaan.git
   cd app-perpustakaan
   ```

2. **Install Dependency PHP**
   ```bash
   composer install
   ```

3. **Salin File Environment**
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database & API Internal di `.env`**
   Sesuaikan konfigurasi koneksi database dan URL API internal di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_perpustakaan
   DB_USERNAME=root
   DB_PASSWORD=

   # Base URL instance kedua untuk panggilan API internal (Wajib port berbeda)
   INTERNAL_API_URL=http://127.0.0.1:8011
   APP_FAKER_LOCALE=id_ID
   ```

6. **Buat Database `db_perpustakaan`** di MySQL / phpMyAdmin.

7. **Migrasi Database & Seeding Data Dummy**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Perintah ini akan membuat struktur tabel dan mengisi data dummy realistis (3 akun pengguna, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi).*

8. **Jalankan DUA Server (Wajib)**
   Karena `php artisan serve` (PHP built-in server) bersifat *single-threaded*, pemanggilan API internal dari dalam Blade membutuhkan **dua instance server** di port berbeda agar tidak terjadi *deadlock*:

   - **Buka Terminal 1 (Server Utama untuk Browser):**
     ```bash
     php artisan serve --port=8000
     ```

   - **Buka Terminal 2 (Server Kedua khusus API Internal):**
     ```bash
     php artisan serve --port=8011
     ```

9. Buka **`http://127.0.0.1:8000`** di browser.

---

## 🔑 Akun Demo (Seeder)

Gunakan kredensial berikut untuk login di halaman `/login`:

| Role | Nama | Email | Password |
|---|---|---|---|
| **Admin** | Bambang Sutrisno | `admin@pens.ac.id` | `password` |
| **Petugas 1** | Siti Rahmawati | `petugas1@pens.ac.id` | `password` |
| **Petugas 2** | Ahmad Fauzi | `petugas2@pens.ac.id` | `password` |

*Catatan: Fitur manajemen kategori hanya dapat diakses oleh user dengan role **Admin**.*

---

## 📡 Dokumentasi REST API

Semua endpoint API mengembalikan respons JSON dengan header `Accept: application/json`:

| Method | Endpoint | Keterangan |
|---|---|---|
| `GET` | `/api/stats` | Statistik ringkas (total buku, anggota, peminjaman aktif) |
| `GET` | `/api/books` | Daftar buku (paginated, dengan relasi kategori) |
| `POST` | `/api/books` | Tambah buku baru |
| `GET` | `/api/books/{id}` | Detail buku |
| `PUT` | `/api/books/{id}` | Update buku |
| `DELETE` | `/api/books/{id}` | Hapus buku |
| `GET` | `/api/members` | Daftar anggota |
| `POST` | `/api/members` | Tambah anggota baru |
| `GET` | `/api/members/{id}` | Detail anggota |
| `GET` | `/api/loans` | Daftar transaksi peminjaman (paginated) |
| `POST` | `/api/loans` | Buat transaksi peminjaman baru |
| `PUT` | `/api/loans/{id}/kembalikan` | Proses pengembalian buku |

---

## 🏗️ Arsitektur MVC & Pola Desain

Aplikasi ini mengimplementasikan pola arsitektur **MVC (Model - View - Controller)** dengan pemisahan tanggung jawab yang jelas:

- **Model:** Mengelola entitas basis data, validasi relasi (`hasMany`, `belongsTo`), serta pencegahan *N+1 Query Problem* via Eager Loading.
- **View:** Menggunakan Blade Templating dengan layout inheritance (`layouts/app.blade.php`), komponen navigasi modular, dan pagination custom ramah styling tanpa dependensi CSS eksternal.
- **Controller:** Mengatur alur logika bisnis, validasi request melalui Form Request, otentikasi session, otorisasi berbasis role, serta konsumsi REST API internal via `Illuminate\Support\Facades\Http`.

---

## 📋 Skenario Demo UAS

Panduan langkah demi langkah demonstrasi live aplikasi untuk pengujian UAS dapat dilihat pada file:
👉 **[`DEMO.md`](./DEMO.md)**

---

## 👤 Mahasiswa

- **Nama:** Rian Saputra
- **NRP:** 3125500045
- **Kelas:** D3 Teknik Informatika B
- **Mata Kuliah:** Workshop Pemrograman Framework
- **Institusi:** Politeknik Elektronika Negeri Surabaya (PENS)
