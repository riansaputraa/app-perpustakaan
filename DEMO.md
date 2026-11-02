# Skenario Demo UAS — Aplikasi Perpustakaan Digital Kampus

Dokumen ini berisi panduan skenario demo live aplikasi **Perpustakaan Digital Kampus** untuk Evaluasi Akhir Semester (UAS) mata kuliah **Workshop Pemrograman Framework**.

**Identitas Mahasiswa:**
- **Nama:** Rian Saputra
- **NRP:** 3125500045
- **Kelas:** D3 Teknik Informatika B

---

## 🛠️ Persiapan Sebelum Demo (Pre-Demo Checklist)

Pastikan langkah-langkah berikut sudah dijalankan sebelum sesi demo dimulai:

1. **Jalankan Database Reset & Seeding:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Memastikan database terisi 3 user (admin & petugas), 5 kategori baku, 20 buku, 15 anggota mahasiswa PENS, dan 10 transaksi peminjaman awal.*

2. **Jalankan DUA Terminal Server Laravel:**
   - **Terminal 1 (Web Server / Browser):**
     ```bash
     php artisan serve --port=8000
     ```
   - **Terminal 2 (Internal API Server):**
     ```bash
     php artisan serve --port=8011
     ```
   > ⚠️ **Catatan Penting:** Server port 8011 wajib berjalan agar Dashboard dan Laporan Peminjaman dapat mengonsumsi endpoint internal (`/api/stats` dan `/api/loans`) tanpa mengalami *deadlock* pada PHP single-thread web server.

3. **Buka Aplikasi & Tool:**
   - Buka browser di `http://127.0.0.1:8000`
   - Buka aplikasi **Postman** dengan koleksi endpoint `app-perpustakaan`

---

## 📋 Urutan Langkah Demo Live

### 1. Autentikasi / Login (Pertemuan 8)
- **URL:** `http://127.0.0.1:8000/login`
- **Aksi:**
  - Masukkan kredensial Admin:
    - **Email:** `admin@pens.ac.id`
    - **Password:** `password`
  - Klik tombol **Login**.
- **Hasil yang Ditunjukkan:**
  - Pengguna dialihkan (*redirect*) otomatis ke halaman **Dashboard** (`/`).
  - Flash message sukses: `"Login berhasil, selamat datang Bambang Sutrisno."`.
  - Navbar menampilkan identitas: `Bambang Sutrisno (Admin)` serta tombol **Logout**.

---

### 2. Dashboard Statistik via API Internal (Pertemuan 10)
- **URL:** `http://127.0.0.1:8000/`
- **Aksi & Penjelasan:**
  - Tunjukkan 3 kartu statistik:
    - **Total Buku:** 20
    - **Total Anggota:** 15
    - **Peminjaman Aktif:** (sesuai status aktif di database)
  - **Penjelasan Konsep:** Angka statistik di atas tidak diambil melalui query langsung dari Blade/Eloquent di web controller, melainkan dikonsumsi oleh `DashboardController@index` melalui **Laravel HTTP Client** (`Http::get()`) memanggil endpoint internal `GET http://127.0.0.1:8011/api/stats`.
  - Dilengkapi *resilience fallback* (`try/catch ConnectionException`) sehingga jika server API mati, halaman tidak error 500 melainkan menampilkan angka 0.

---

### 3. Manajemen Kategori Buku (Pertemuan 2, 3, 5, 8)
- **URL:** `http://127.0.0.1:8000/categories`
- **Aksi:**
  - Klik menu **Kategori** (hanya bisa diakses oleh role Admin).
  - Klik tombol **Tambah Kategori**.
  - Isi form:
    - **Nama Kategori:** `Ensiklopedia`
    - **Deskripsi:** `Buku referensi lengkap seputar ilmu pengetahuan umum.`
  - Klik **Simpan**.
- **Hasil yang Ditunjukkan:**
  - Kategori baru `Ensiklopedia` berhasil tersimpan dan tampil di tabel kategori.
  - Flash message sukses tampil di bagian atas.

---

### 4. Manajemen Buku & Relasi Kategori (Pertemuan 3, 5, 7)
- **URL:** `http://127.0.0.1:8000/books`
- **Aksi:**
  - Klik menu **Buku**, lalu klik **Tambah Buku**.
  - Isi form:
    - **Judul:** `Ensiklopedia Sains dan Teknologi Dunia`
    - **Penulis:** `Prof. Dr. Suwandi`
    - **Penerbit:** `Pustaka Edukasi PENS`
    - **Tahun Terbit:** `2024`
    - **ISBN:** `978-602-0001-99-9`
    - **Stok:** `5`
    - **Kategori:** Pilih kategori yang baru dibuat: `Ensiklopedia`.
  - Klik **Simpan**.
- **Hasil yang Ditunjukkan:**
  - Buku baru muncul pada tabel buku.
  - Kolom **Kategori** menampilkan nama kategori `Ensiklopedia` (hasil relasi Eloquent `belongsTo`, bukan ID mentah).
  - Tunjukkan juga komponen **Pagination** teks bersih di bawah tabel buku.

---

### 5. Manajemen Anggota & Validasi (Pertemuan 3, 5)
- **URL:** `http://127.0.0.1:8000/members`
- **Aksi:**
  - Klik menu **Anggota**, lalu klik **Tambah Anggota**.
  - Uji validasi input (misalnya masukkan email tidak valid atau kosong) untuk menunjukkan *server-side validation*.
  - Isi data valid:
    - **Nama:** `Budi Santoso`
    - **NIM:** `3125500099`
    - **Email:** `budi.santoso@pens.ac.id`
    - **Nomor Telepon:** `081234567899`
    - **Alamat:** `Jl. Raya ITS Kampus PENS Sukolilo, Surabaya`
    - **Status:** `aktif`
  - Klik **Simpan**.
- **Hasil yang Ditunjukkan:**
  - Anggota baru tersimpan dengan status aktif.

---

### 6. Transaksi Peminjaman Buku (Pertemuan 7)
- **URL:** `http://127.0.0.1:8000/loans/create`
- **Aksi:**
  - Klik menu **Peminjaman**, lalu klik **Tambah Peminjaman**.
  - Isi form peminjaman:
    - **Anggota:** Pilih `Budi Santoso`.
    - **Tanggal Pinjam:** (Tanggal hari ini).
    - **Tanggal Kembali:** (7 hari ke depan).
    - **Buku:** Centang buku `Ensiklopedia Sains dan Teknologi Dunia` (dan buku lainnya jika multi-buku).
  - Klik **Simpan Transaksi**.
- **Hasil yang Ditunjukkan:**
  - Transaksi berhasil dicatat ke tabel `loans` dan item buku ke `loan_items`.
  - Petugas tercatat otomatis mengambil `Auth::id()` dari sesi login admin/petugas saat ini tanpa perlu dipilih manual di form.

---

### 7. Daftar Peminjaman Aktif & Eager Loading (Pertemuan 7)
- **URL:** `http://127.0.0.1:8000/loans`
- **Aksi & Penjelasan:**
  - Tunjukkan data transaksi yang baru dibuat di daftar peminjaman.
  - Status peminjaman adalah `dipinjam` dengan badge warna kuning.
  - Tunjukkan bahwa data peminjam (`member`), petugas (`user`), dan judul-judul buku (`loanItems.book`) dimuat menggunakan **Eager Loading** (`with([...])`) untuk mencegah masalah *N+1 Query Problem*.

---

### 8. Proses Pengembalian Buku
- **Aksi:**
  - Klik tombol **Kembalikan** pada baris transaksi peminjaman yang baru dibuat.
  - Konfirmasi pengembalian buku.
- **Hasil yang Ditunjukkan:**
  - Status transaksi berubah dari `dipinjam` menjadi `dikembalikan` dengan badge hijau.
  - `tanggal_dikembalikan` tercatat otomatis pada database.
  - *(Opsi cadangan Postman)*: Jika diuji lewat API, jalankan request `PUT http://127.0.0.1:8000/api/loans/{id}/kembalikan`.

---

### 9. Laporan Peminjaman via API Internal (Pertemuan 10)
- **URL:** `http://127.0.0.1:8000/loans/report`
- **Aksi & Penjelasan:**
  - Klik menu **Laporan** pada navbar.
  - Tunjukkan tabel laporan transaksi peminjaman lengkap.
  - **Penjelasan Konsep:** Data pada tabel laporan ini diambil secara terpisah melalui `LoanController@report` dengan memanggil internal API `GET http://127.0.0.1:8011/api/loans?page=...`.
  - Data di-parse dari format JSON array API Resource dan pagination dinavigasikan berdasarkan metadata API (`meta.current_page` dan `meta.last_page`).

---

### 10. Pengujian REST API di Postman (Pertemuan 9)
Buka aplikasi **Postman** dan jalankan endpoint berikut:

1. **`GET http://127.0.0.1:8000/api/stats`**
   - Header: `Accept: application/json`
   - Response: Status `200 OK`
   - Menampilkan total buku, total anggota, dan peminjaman aktif terkini dalam format JSON.

2. **`GET http://127.0.0.1:8000/api/books`**
   - Header: `Accept: application/json`
   - Response: Status `200 OK`
   - Menunjukkan data buku terstruktur rapi hasil transformasi `BookResource`, lengkap dengan pagination `links` dan `meta`.

3. **`GET http://127.0.0.1:8000/api/loans`**
   - Header: `Accept: application/json`
   - Response: Status `200 OK`
   - Menunjukkan relasi transaksi `LoanResource` (member, petugas, dan array books).

4. **`POST http://127.0.0.1:8000/api/books` (Pengujian Validasi JSON)**
   - Body JSON kosong `{}`
   - Response: Status `422 Unprocessable Content` dengan pesan error validasi per field dalam format JSON terstandar.

---

### 11. Tanya Jawab Konseptual (Pertemuan 11)
Siap menjawab pertanyaan seputar:
- Arsitektur MVC & Siklus Request Laravel
- Peran Middleware & Route Protection
- Eloquent ORM vs Query Builder, serta N+1 Problem & solusinya (Eager Loading)
- Perbedaan Web Response vs REST API JSON Response & API Resource
- Mengapa konsumsi API internal butuh dua instance server saat pengembangan lokal (Deadlock single-thread server).
