# FinTrack Backend API

**Dokumentasi API:**  
[Dokumentasi API](https://documenter.getpostman.com/view/37959814/2sB2qfBzgk)

---

## Tech Stack

- **Framework:** Laravel 10
- **Language:** PHP 8.3.14
- **Authentication:** Laravel Sanctum
- **Database:** MySQL

---

## Cara Menjalankan Secara Lokal

```bash
# Clone repositori
git clone https://github.com/Projek-Praxis-Academy/praxis_be_sistem_keuangan.git
cd praxis_be_sistem_keuangan

# Install dependency
composer install

# Copy file .env dan sesuaikan konfigurasi
cp .env.example .env

# Generate key dan migrasi database
php artisan key:generate
php artisan migrate:fresh --seed

# Jalankan server lokal
php artisan serve
