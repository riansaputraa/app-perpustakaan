# 📚 App Perpustakaan Digital Kampus

Aplikasi web untuk mengelola sistem perpustakaan digital kampus, dibangun menggunakan **Laravel 12** sebagai bagian dari mata kuliah Workshop Pemrograman Framework - Semester 3 PENS.

## 📖 Tentang Aplikasi

**App Perpustakaan** adalah sistem manajemen perpustakaan berbasis web yang digunakan oleh petugas/admin untuk mengelola:
- Data buku (judul, pengarang, stok, kategori)
- Data anggota perpustakaan
- Transaksi peminjaman dan pengembalian buku

Aplikasi ini dikembangkan secara bertahap setiap pertemuan, mulai dari setup awal hingga menjadi aplikasi utuh di akhir semester.

---

## 🚀 Cara Menjalankan Project Secara Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Git

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/riansaputraa/app-perpustakaan.git
   cd app-perpustakaan
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Salin file environment**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_perpustakaan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Buat database `db_perpustakaan`** di MySQL/phpMyAdmin

7. **Jalankan migration** *(tersedia mulai Pertemuan 5)*
   ```bash
   php artisan migrate
   ```

8. **Jalankan development server**
   ```bash
   php artisan serve
   ```

9. Buka **`http://127.0.0.1:8000`** di browser

---

## 🏗️ Arsitektur MVC

Aplikasi ini menggunakan pola arsitektur **MVC (Model - View - Controller)**:

- **Model** adalah bagian yang bertanggung jawab atas data — ia yang "tahu" struktur tabel database seperti `books` atau `members`, beserta aturan relasi antar datanya. Model adalah satu-satunya pintu masuk untuk membaca atau mengubah data di database.

- **View** adalah bagian yang bertugas menampilkan halaman kepada pengguna dalam bentuk HTML. View tidak peduli dari mana data berasal atau bagaimana cara mengambilnya — ia hanya fokus pada *tampilan*, menerima data yang sudah disiapkan, lalu merendernya menjadi halaman yang bisa dilihat di browser.

- **Controller** adalah "penghubung" antara keduanya — ia menerima request dari pengguna, memanggil Model untuk mengambil atau mengubah data, lalu meneruskan data tersebut ke View untuk ditampilkan. Controller yang menentukan alur kerja aplikasi.

---

## 📁 Struktur Branch

| Branch | Fungsi |
|--------|--------|
| `main` | Kode stabil di setiap checkpoint pertemuan |
| `dev`  | Branch aktif pengembangan harian |

---

## 🗂️ Progress Pertemuan

| Pertemuan | Topik | Status |
|-----------|-------|--------|
| P-1 | Setup project Laravel 12 & GitHub | ✅ Done |
| P-2 | Routing & Controller | 🔜 |
| P-3 | Blade Template & View | 🔜 |
| P-4 | dst... | 🔜 |

---

## 👤 Developer

**Nama:** Rian Saputra  
**Prodi:** D4 Teknik Informatika  
**Kampus:** Politeknik Elektronika Negeri Surabaya (PENS)  
**Mata Kuliah:** Workshop Pemrograman Framework  
