# 🏡 SIP-DESA — Sistem Informasi Persuratan Desa Digital

[![Laravel](https://img.shields.io/badge/Laravel-v12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-22c55e?style=for-the-badge)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-blue?style=for-the-badge)](https://github.com/inedpb14/sadeskrawangsari)

**SIP-DESA** adalah aplikasi web administrasi persuratan desa digital yang dibangun dengan Laravel. Sistem ini mengotomatiskan proses pengajuan, verifikasi, dan penerbitan surat di tingkat desa/kelurahan, dilengkapi dengan legalitas digital berupa Tanda Tangan Elektronik (TTE) dan QR Code verifikasi.

---

## ✨ Fitur Unggulan

| Fitur | Keterangan |
|---|---|
| 📄 **13 Jenis Surat** | Kependudukan, Domisili, Pindah, SKTM, IUMK, dan lainnya |
| 🪶 **Blanko PDF Ringan** | Manipulasi Form Field PDF — cepat di server spesifikasi rendah |
| 👤 **Master Data Warga** | Pre-fill otomatis form surat dari data kependudukan |
| 🔏 **TTE & QR Code** | Legalitas digital pada setiap surat yang diterbitkan |
| 🖨️ **Dual Retrieval** | Cetak sendiri atau ambil di kantor sesuai jenis surat |
| 📊 **Dashboard Analitik** | Tren pengajuan surat dan statistik real-time untuk admin |
| 📁 **Template PDF Dinamis** | Admin bisa upload template PDF baru tanpa ubah kode |

---

## 🧩 Modul Sistem

### 👥 Modul Warga
- **Dashboard** — Riwayat dan status pengajuan surat
- **Persuratan** — Form pengajuan surat online
- **Pengaduan** — Komunikasi non-persuratan dengan pihak desa

### 🛠️ Modul Admin
- **Dashboard Analitik** — Chart dan kartu informasi real-time
- **Kelola Persuratan** — Verifikasi, persetujuan, penolakan, penerbitan
- **Template PDF** — Upload dan kelola template surat desa
- **Manajemen Akun** — Kelola akun admin dan data warga

---

## 🛠️ Persyaratan Sistem

| Perangkat | Versi Minimum |
|---|---|
| **PHP** | 8.2 atau lebih baru |
| **Composer** | 2.x |
| **Node.js** | 18.x atau lebih baru |
| **NPM** | 9.x atau lebih baru |
| **MySQL / MariaDB** | 8.0 / 10.4 |
| **Git** | Terbaru |

> 💡 **Rekomendasi**: Gunakan [Laragon](https://laragon.org/) (Windows) atau [Herd](https://herd.laravel.com/) untuk setup lokal yang mudah dan cepat.

---

## 🚀 Panduan Instalasi

### Langkah 1 — Clone Repository

```bash
git clone https://github.com/inedpb14/sadeskrawangsari.git
cd sadeskrawangsari
```

### Langkah 2 — Instalasi Dependensi PHP

```bash
composer install
```

### Langkah 3 — Setup File Environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="SIP-DESA Krawangsari"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sadeskrawangsari
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 4 — Buat Database

Buat database baru di MySQL:

```sql
CREATE DATABASE sadeskrawangsari CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 5 — Migrasi & Seeder Database

```bash
php artisan migrate --seed
```

Seeder akan membuat:
- ✅ Akun admin default
- ✅ Data jenis surat
- ✅ Pengaturan desa awal

> **Akun Admin Default:**
> - Email: `admin@desakrawangsari.com`
> - Password: `admin12345`
>
> ⚠️ **Segera ganti password** setelah login pertama kali!

### Langkah 6 — Instalasi Frontend & Build Asset

```bash
npm install
npm run build
```

### Langkah 7 — Storage Link

```bash
php artisan storage:link
```

### Langkah 8 — Jalankan Aplikasi

```bash
composer run dev
```

Perintah ini menjalankan secara bersamaan:
- 🟢 PHP Server (`php artisan serve`)
- 🟣 Queue Worker (`php artisan queue:listen`)
- 🟠 Vite Dev Server (`npm run dev`)

Akses aplikasi di: **http://127.0.0.1:8000**

---

## ⚡ Cara Cepat (One-Command Setup)

```bash
composer run setup
```

Otomatis menjalankan: `composer install` → `.env` → `key:generate` → `migrate` → `npm install` → `npm run build`.

> Setelah selesai, jalankan `php artisan db:seed` untuk data awal, lalu `composer run dev` untuk memulai server.

---

## 🧪 Menjalankan Test

```bash
php artisan test --compact
```

---

## 📁 Struktur Direktori Penting

```
sadeskrawangsari/
├── app/
│   ├── Http/Controllers/    # Controller aplikasi
│   ├── Models/              # Eloquent models
│   └── ...
├── database/
│   ├── migrations/          # Migrasi database
│   └── seeders/             # Data awal (admin, jenis surat, pengaturan)
├── public/                  # Entry point & asset publik
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Definisi route
└── storage/                 # File upload & log
```

---

## 🔧 Konfigurasi Tambahan (Opsional)

### Antrian (Queue)

```bash
php artisan queue:work
```

### Email (SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your@email.com
MAIL_FROM_NAME="SIP-DESA Krawangsari"
```

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m 'Tambah fitur X'`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE) © 2025 [Dimas Suhendra](https://github.com/inedpb14).
