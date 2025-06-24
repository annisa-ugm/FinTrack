# FinTrack Backend API

**Deploy URL:**  
[Backend FinTrack](https://fitrack-production.up.railway.app/api/test)

**Dokumentasi API:**  
[Dokumentasi API](https://documenter.getpostman.com/view/37959814/2sB2qfBzgk#1223a049-2799-4675-a323-2cc5eb806bf8)

---

## Tech Stack

- **Framework:** Laravel 10
- **Bahasa:** PHP 8.3.14
- **Authentication:** Laravel Sanctum
- **Database:** MySQL
- **Deployment:** Railway.app

---

## 🔧 Cara Menjalankan Secara Lokal

```bash
# Clone repositori
git clone https://github.com/annisa-ugm/FiTrack.git
cd FiTrack

# Install dependency
composer install

# Copy file .env dan sesuaikan konfigurasi
cp .env.example .env

# Generate key dan migrasi database
php artisan key:generate
php artisan migrate:fresh --seed

# Jalankan server lokal
php artisan serve
````

---

## Autentikasi

Autentikasi menggunakan **Laravel Sanctum**.

### Login

```http
POST /api/auth/login
{
  "email": "bendahara@example.com",
  "password": "password123"
}
```

### Logout

```http
POST /api/auth/logout
Authorization: Bearer <token>
```
---

## Endpoint API Utama

### Dashboard

* `GET /api/dashboard` — Data ringkasan dashboard

### Siswa & Kontrak

* `GET /api/cari-siswa` — Cari siswa berdasarkan keyword
* `POST /api/kontrak` — Buat kontrak baru

### Pembayaran & Monitoring Umum

* `POST /api/pembayaran` — Tambah pembayaran umum
* `GET /api/monitoring-praxis` — Monitoring siswa program *Praxis*
* `GET /api/monitoring-techno` — Monitoring siswa program *Techno*
* `GET /api/monitoring-praxis/detail-kontrak/{id}` — Detail kontrak
* `GET /api/monitoring-praxis/pembayaran-siswa/{id}` — Detail pembayaran siswa

### Boarding & Konsumsi

* `GET /api/monitoring-bk` — List siswa boarding konsumsi
* `POST /api/monitoring-bk/pembayaran` — Buat pembayaran BK
* `POST /api/monitoring-bk/create-siswa/boarding` — Tambah siswa boarding
* `POST /api/monitoring-bk/create-siswa/konsumsi` — Tambah siswa konsumsi

### Uang Saku

* `GET /api/monitoring-uang-saku` — Monitoring uang saku
* `POST /api/monitoring-uang-saku/topup` — Top-up uang saku
* `POST /api/monitoring-uang-saku/pengeluaran` — Input pengeluaran siswa
* `GET /api/monitoring-uang-saku/detail/{id}` — Riwayat uang saku

### Ekstra

* `GET /api/monitoring-ekstra` — Monitoring kegiatan ekstra
* `POST /api/monitoring-ekstra/create-siswa` — Tambah siswa ekstra
* `POST /api/monitoring-ekstra/pembayaran` — Buat pembayaran ekstra
* `GET /api/ekstra/list` — List master ekstra
* `POST /api/monitoring-ekstra/ekstra/create` — Tambah kegiatan ekstra

### Pengeluaran

* `GET /api/monitoring-pengeluaran` — Monitoring pengeluaran
* `POST /api/monitoring-pengeluaran/create` — Tambah pengeluaran
* `GET /api/monitoring-pengeluaran/kategori-pengeluaran` — List kategori
* `POST /api/monitoring-pengeluaran/kategori-pengeluaran/create` — Tambah kategori
* `PUT /api/monitoring-pengeluaran/pengeluaran/update/{id}` — Edit pengeluaran
* `POST /api/monitoring-pengeluaran/sub-pengeluaran/update/{id}` — Update sub
* `DELETE /api/monitoring-pengeluaran/sub-pengeluaran/delete/{id}` — Hapus sub

### Tagihan

* `GET /api/tagihan` — Semua tagihan
* `GET /api/tagihan/{nisn}` — Tagihan berdasarkan NISN
* `POST /api/tagihan/create` — Buat tagihan baru

---

## 📬 Kontak

**Annisa Mutia Rahman**
[WhatsApp: 0857-1394-6691]  

---

