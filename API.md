# Dokumentasi REST API — App Perpustakaan

Base URL: `http://127.0.0.1:8000/api`

> Semua request harus menyertakan header `Accept: application/json`.

---

## Ringkasan Endpoint

| No | Method | URL | Deskripsi |
|----|--------|-----|-----------|
| 1 | GET | `/api/books` | Daftar semua buku (paginasi + filter) |
| 2 | GET | `/api/books/{id}` | Detail satu buku |
| 3 | POST | `/api/books` | Tambah buku baru |
| 4 | PUT | `/api/books/{id}` | Update data buku |
| 5 | DELETE | `/api/books/{id}` | Hapus buku |
| 6 | GET | `/api/members` | Daftar semua anggota (paginasi) |
| 7 | GET | `/api/members/{id}` | Detail satu anggota |
| 8 | GET | `/api/loans` | Daftar semua peminjaman (paginasi) |
| 9 | POST | `/api/loans` | Buat transaksi peminjaman baru |
| 10 | PUT | `/api/loans/{id}/kembalikan` | Tandai peminjaman dikembalikan |
| 11 | GET | `/api/stats` | Statistik ringkasan perpustakaan |

---

## 📚 Books

### 1. GET `/api/books`
Menampilkan daftar semua buku dengan paginasi (10 per halaman). Mendukung filter opsional via query string.

**Query Parameters (opsional):**
| Parameter | Tipe | Keterangan |
|-----------|------|------------|
| `judul` | string | Filter judul buku (LIKE, sebagian cocok) |
| `category_id` | integer | Filter berdasarkan ID kategori |

**Contoh Request:**
```
GET /api/books
GET /api/books?judul=kitab
GET /api/books?category_id=3
```

**Response Sukses — `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Laskar Zaki",
      "penulis": "adafafawa",
      "penerbit": "Bentang Pustaka",
      "tahun_terbit": "2026",
      "isbn": "3125500045",
      "stok": 1,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "assalamualikum"
      },
      "created_at": "2026-09-23T05:20:56.000000Z",
      "updated_at": "2026-09-23T05:20:56.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/books?page=1",
    "last": "http://127.0.0.1:8000/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://127.0.0.1:8000/api/books",
    "per_page": 10,
    "to": 3,
    "total": 3
  }
}
```

**Response Filter `?judul=kitab` — `200 OK`:**
```json
{
  "data": [
    {
      "id": 5,
      "judul": "Kitab Java",
      "penulis": "WASHI",
      "penerbit": "Utopia",
      "tahun_terbit": "2018",
      "isbn": null,
      "stok": 1,
      "sampul": null,
      "category": { "id": 3, "nama_kategori": "Asli" },
      "created_at": "2026-09-30T05:19:11.000000Z",
      "updated_at": "2026-09-30T05:19:11.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": null },
  "meta": { "current_page": 1, "from": 1, "last_page": 1, "per_page": 10, "to": 1, "total": 1 }
}
```

---

### 2. GET `/api/books/{id}`
Menampilkan detail satu buku berdasarkan ID.

**Response Sukses — `200 OK`:**
```json
{
  "data": {
    "id": 1,
    "judul": "Laskar Zaki",
    "penulis": "adafafawa",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": "2026",
    "isbn": "3125500045",
    "stok": 1,
    "sampul": null,
    "category": { "id": 1, "nama_kategori": "assalamualikum" },
    "created_at": "2026-09-23T05:20:56.000000Z",
    "updated_at": "2026-09-23T05:20:56.000000Z"
  }
}
```

**Response Gagal — `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 3. POST `/api/books`
Menambahkan buku baru ke database.

**Request Body (JSON):**
```json
{
  "judul": "Buku Test API",
  "penulis": "John Doe",
  "penerbit": "Penerbit Test",
  "tahun_terbit": 2024,
  "isbn": "1234567890",
  "stok": 5,
  "category_id": 1
}
```

**Response Sukses — `201 Created`:**
```json
{
  "data": {
    "id": 6,
    "judul": "Buku Test API",
    "penulis": "John Doe",
    "penerbit": "Penerbit Test",
    "tahun_terbit": 2024,
    "isbn": "1234567890",
    "stok": 5,
    "sampul": null,
    "category": { "id": 1, "nama_kategori": "assalamualikum" },
    "created_at": "2026-10-24T14:59:29.000000Z",
    "updated_at": "2026-10-24T14:59:29.000000Z"
  }
}
```

**Response Gagal — `422 Unprocessable Entity` (body kosong):**
```json
{
  "message": "Judul buku wajib diisi. (and 4 more errors)",
  "errors": {
    "judul": ["Judul buku wajib diisi."],
    "penulis": ["Nama penulis wajib diisi."],
    "penerbit": ["Nama penerbit wajib diisi."],
    "tahun_terbit": ["Tahun terbit wajib diisi."],
    "stok": ["Stok wajib diisi."],
    "category_id": ["Kategori wajib dipilih."]
  }
}
```

---

### 4. PUT `/api/books/{id}`
Memperbarui data buku yang sudah ada.

**Request Body (JSON):**
```json
{
  "judul": "Buku Test API (Updated)",
  "penulis": "John Doe",
  "penerbit": "Penerbit Test",
  "tahun_terbit": 2024,
  "stok": 10,
  "category_id": 1
}
```

**Response Sukses — `200 OK`:**
```json
{
  "data": {
    "id": 6,
    "judul": "Buku Test API (Updated)",
    "penulis": "John Doe",
    "penerbit": "Penerbit Test",
    "tahun_terbit": 2024,
    "isbn": "1234567890",
    "stok": 10,
    "sampul": null,
    "category": { "id": 1, "nama_kategori": "assalamualikum" },
    "created_at": "2026-10-24T14:59:29.000000Z",
    "updated_at": "2026-10-24T14:59:30.000000Z"
  }
}
```

**Response Gagal — `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 5. DELETE `/api/books/{id}`
Menghapus buku dari database secara permanen.

**Response Sukses — `200 OK`:**
```json
{
  "message": "Buku berhasil dihapus."
}
```

**Response Gagal — `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

## 👤 Members

### 6. GET `/api/members`
Menampilkan daftar semua anggota dengan paginasi (10 per halaman).

**Response Sukses — `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Rio Maulana Wijaya",
      "nim": "3125500031",
      "email": "rio.maulana@student.pens.ac.id",
      "nomor_telepon": "081234567801",
      "alamat": "Jl. Sukolilo No. 1, Surabaya",
      "status": "aktif",
      "created_at": "2026-09-23T12:45:00.000000Z",
      "updated_at": "2026-09-23T12:45:00.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/members?page=1",
    "last": "http://127.0.0.1:8000/api/members?page=4",
    "prev": null,
    "next": "http://127.0.0.1:8000/api/members?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 4,
    "path": "http://127.0.0.1:8000/api/members",
    "per_page": 10,
    "to": 10,
    "total": 31
  }
}
```

---

### 7. GET `/api/members/{id}`
Menampilkan detail satu anggota berdasarkan ID.

**Response Sukses — `200 OK`:**
```json
{
  "data": {
    "id": 1,
    "nama": "Rio Maulana Wijaya",
    "nim": "3125500031",
    "email": "rio.maulana@student.pens.ac.id",
    "nomor_telepon": "081234567801",
    "alamat": "Jl. Sukolilo No. 1, Surabaya",
    "status": "aktif",
    "created_at": "2026-09-23T12:45:00.000000Z",
    "updated_at": "2026-09-23T12:45:00.000000Z"
  }
}
```

**Response Gagal — `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

## 📋 Loans

### 8. GET `/api/loans`
Menampilkan semua transaksi peminjaman. Setiap item menyertakan nested `member`, `petugas`, dan array `books`.

**Response Sukses — `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "member": { "id": 1, "nama": "Rio Maulana Wijaya" },
      "petugas": { "id": 1, "name": "Admin Perpustakaan" },
      "tanggal_pinjam": "2026-10-24",
      "tanggal_kembali": "2026-10-31",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        { "id": 1, "judul": "Laskar Zaki" },
        { "id": 4, "judul": "Mau makan apa aja" }
      ]
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": null },
  "meta": { "current_page": 1, "from": 1, "last_page": 1, "per_page": 10, "to": 1, "total": 1 }
}
```

---

### 9. POST `/api/loans`
Membuat transaksi peminjaman baru. Satu transaksi bisa mencakup lebih dari satu buku.

> **Catatan:** `user_id` wajib dikirim eksplisit karena endpoint ini tidak menggunakan session autentikasi.

**Request Body (JSON):**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-10-24",
  "tanggal_kembali": "2026-10-31",
  "book_ids": [1, 4]
}
```

**Response Sukses — `201 Created`:**
```json
{
  "data": {
    "id": 1,
    "member": { "id": 1, "nama": "Rio Maulana Wijaya" },
    "petugas": { "id": 1, "name": "Admin Perpustakaan" },
    "tanggal_pinjam": "2026-10-24",
    "tanggal_kembali": "2026-10-31",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      { "id": 1, "judul": "Laskar Zaki" },
      { "id": 4, "judul": "Mau makan apa aja" }
    ]
  }
}
```

**Response Gagal — `422 Unprocessable Entity`:**
```json
{
  "message": "Anggota wajib dipilih. (and 3 more errors)",
  "errors": {
    "member_id": ["Anggota wajib dipilih."],
    "user_id": ["Petugas (user_id) wajib diisi."],
    "tanggal_pinjam": ["Tanggal pinjam wajib diisi."],
    "book_ids": ["Pilih minimal satu buku."]
  }
}
```

---

### 10. PUT `/api/loans/{id}/kembalikan`
Menandai peminjaman sebagai dikembalikan. Otomatis mengisi `tanggal_dikembalikan` dengan tanggal hari ini.

**Response Sukses — `200 OK`:**
```json
{
  "data": {
    "id": 1,
    "member": { "id": 1, "nama": "Rio Maulana Wijaya" },
    "petugas": { "id": 1, "name": "Admin Perpustakaan" },
    "tanggal_pinjam": "2026-10-24",
    "tanggal_kembali": "2026-10-31",
    "tanggal_dikembalikan": "2026-10-24",
    "status": "dikembalikan",
    "books": [
      { "id": 1, "judul": "Laskar Zaki" },
      { "id": 4, "judul": "Mau makan apa aja" }
    ]
  }
}
```

**Response Gagal — `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Loan] 999"
}
```

---

## 📊 Stats

### 11. GET `/api/stats`
Mengembalikan ringkasan statistik perpustakaan.

**Response Sukses — `200 OK`:**
```json
{
  "total_buku": 3,
  "total_anggota": 31,
  "peminjaman_aktif": 0
}
```

---

## HTTP Status Code Referensi

| Kode | Nama | Kapan Dikembalikan |
|------|------|--------------------|
| `200` | OK | Request berhasil (GET, PUT, DELETE) |
| `201` | Created | Resource baru berhasil dibuat (POST) |
| `404` | Not Found | ID resource yang diminta tidak ada di database |
| `422` | Unprocessable Entity | Data request gagal validasi (field wajib kosong, format salah, dll.) |
| `500` | Internal Server Error | Terjadi error tak terduga di sisi server |
