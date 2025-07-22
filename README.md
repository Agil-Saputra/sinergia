# Sinergia - Sistem Manajemen Karyawan

<p align="center">
  <img src="public/logo.png" width="200" alt="Sinergia Logo">
</p>

<p align="center">
  Aplikasi web manajemen karyawan yang komprehensif untuk mengelola absensi, tugas, dan laporan darurat.
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
<a href="#"><img src="https://img.shields.io/badge/Status-Active-brightgreen.svg" alt="Status"></a>
</p>

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Struktur Database](#struktur-database)
- [API Endpoints](#api-endpoints)
- [Screenshot](#screenshot)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)
- [Tim Pengembang](#tim-pengembang)

---

## 🚀 Tentang Aplikasi

**Sinergia** adalah sistem manajemen karyawan berbasis web yang dirancang untuk membantu perusahaan dalam mengelola aktivitas karyawan secara digital. Aplikasi ini menyediakan solusi terintegrasi untuk manajemen absensi, penugasan, dan pelaporan darurat dengan antarmuka yang user-friendly dan fitur-fitur modern.

### Tujuan Aplikasi
- Digitalisasi sistem absensi karyawan
- Manajemen tugas dan monitoring progress
- Sistem pelaporan darurat yang responsif
- Dashboard analitik untuk manajemen
- Peningkatan efisiensi operasional perusahaan

---

## ✨ Fitur Utama

### 👤 Untuk Karyawan (User)
- **Sistem Absensi Digital**
  - Check-in dan check-out dengan timestamp
  - Pencatatan lokasi kehadiran
  - Riwayat absensi lengkap
  - Kalkulasi jam kerja otomatis

- **Manajemen Tugas**
  - Melihat tugas yang ditugaskan
  - Update status tugas (assigned, in_progress, completed)
  - Upload bukti penyelesaian tugas
  - Catatan progress dan kendala

- **Laporan Darurat**
  - Lapor insiden atau masalah urgent
  - Upload foto/dokumen pendukung
  - Tracking status penanganan
  - Kategorisasi berdasarkan prioritas

- **Profil & Akun**
  - Manajemen profil personal
  - Ubah password
  - Lihat statistik personal

### 👑 Untuk Admin
- **Dashboard Komprehensif**
  - Overview statistik keseluruhan
  - Grafik dan analitik real-time
  - Quick actions dan notifications

- **Manajemen User**
  - CRUD operasi untuk karyawan
  - Sistem role-based access
  - Employee code generation
  - Bulk operations

- **Manajemen Tugas**
  - Buat dan assign tugas ke karyawan
  - Monitor progress semua tugas
  - Berikan feedback dan rating
  - Export laporan tugas

- **Monitoring Absensi**
  - Lihat kehadiran semua karyawan
  - Filter berdasarkan tanggal/karyawan
  - Laporan keterlambatan
  - Export data absensi

- **Manajemen Laporan Darurat**
  - Review dan update status laporan
  - Assign handler untuk setiap kasus
  - Archive resolved cases
  - Priority-based sorting

---

## 🛠 Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 12.x
- **PHP**: Version 8.2+
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel built-in Auth
- **File Storage**: Laravel Storage (Local/Cloud)

### Frontend
- **Template Engine**: Blade Templates
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Vanilla JS + Alpine.js
- **Icons**: Font Awesome
- **UI Components**: Custom + Tailwind UI

### Development Tools
- **Dependency Manager**: Composer
- **Build Tool**: Vite
- **Testing**: PHPUnit
- **Code Style**: Laravel Pint
- **Development Server**: Laravel Sail/Artisan

---

## 📋 Persyaratan Sistem

### Minimum Requirements
- PHP >= 8.2
- MySQL >= 8.0 atau MariaDB >= 10.3
- Composer
- Node.js >= 18.x
- NPM atau Yarn

### Recommended
- PHP 8.3+
- MySQL 8.0+
- Redis (untuk caching)
- Nginx/Apache
- SSL Certificate

---

## 🚧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Agil-Saputra/sinergia.git
cd sinergia
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE sinergia;

# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sinergia
DB_USERNAME=root
DB_PASSWORD=your_password
```

### File Upload Configuration
```env
FILESYSTEM_DISK=local
# Atau untuk cloud storage
FILESYSTEM_DISK=s3
```

### Mail Configuration (untuk notifikasi)
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Default Admin Account
Setelah seeding, gunakan akun berikut:
- **Email**: admin@sinergia.com
- **Password**: password
- **Role**: admin

---

## 📱 Penggunaan

### Login ke Sistem
1. Akses `http://localhost:8000/login`
2. Masukkan email dan password
3. Sistem akan redirect berdasarkan role:
   - Admin → `/admin/dashboard`
   - User → `/attendance`

### Untuk Karyawan
1. **Absensi Harian**:
   - Klik "Check In" saat tiba
   - Klik "Check Out" saat pulang
   - Lihat riwayat di menu "History"

2. **Mengerjakan Tugas**:
   - Buka menu "Tugas Saya"
   - Klik "Mulai" pada tugas
   - Update progress secara berkala
   - Upload bukti saat selesai

3. **Laporan Darurat**:
   - Klik "Laporkan Masalah"
   - Isi detail dan upload bukti
   - Monitor status penanganan

### Untuk Admin
1. **Membuat Tugas Baru**:
   - Buka "Kelola Tugas"
   - Klik "Buat Tugas Baru"
   - Isi detail dan assign ke karyawan

2. **Monitoring Absensi**:
   - Buka menu "Absensi"
   - Filter berdasarkan periode
   - Export laporan jika diperlukan

3. **Review Laporan Darurat**:
   - Buka "Laporan Darurat"
   - Review dan update status
   - Berikan feedback penanganan

---

## 🗄️ Struktur Database

### Tabel Utama

#### Users
```sql
- id (PK)
- name
- employee_code (unique)
- email (unique)
- password (nullable)
- role (admin/user)
- created_at, updated_at
```

#### Attendances
```sql
- id (PK)
- user_id (FK)
- date
- check_in
- check_out
- location
- notes
- status
- created_at, updated_at
```

#### Tasks
```sql
- id (PK)
- user_id (FK) - assigned to
- assigned_by (FK) - admin who assigned
- title
- description
- priority (low/medium/high)
- status (assigned/in_progress/completed)
- category
- estimated_time
- assigned_date, due_date
- started_at, completed_at
- completion_notes, proof_image
- admin_feedback, feedback_type, feedback_by, feedback_at
- created_at, updated_at
```

#### Emergency Reports
```sql
- id (PK)
- user_id (FK)
- title
- description
- status (pending/under_review/resolved/closed)
- priority (low/medium/high/critical)
- location
- attachments (JSON)
- reported_at, resolved_at
- admin_notes
- created_at, updated_at
```

---

## 🔗 API Endpoints

### Authentication
- `GET /login` - Login form
- `POST /login` - Authenticate user
- `POST /logout` - Logout user

### User Routes (Karyawan)
- `GET /attendance` - Dashboard absensi
- `POST /attendance/checkin` - Check in
- `POST /attendance/checkout` - Check out
- `GET /user/tasks` - Daftar tugas
- `POST /user/tasks/{task}/complete` - Selesaikan tugas
- `GET /user/emergency-reports` - Laporan darurat
- `POST /user/emergency-reports` - Buat laporan baru

### Admin Routes
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/users` - Manajemen user
- `GET /admin/tasks` - Kelola tugas
- `POST /admin/tasks` - Buat tugas baru
- `POST /admin/tasks/{task}/feedback` - Beri feedback
- `GET /admin/attendance` - Monitor absensi
- `GET /admin/emergency-reports` - Kelola laporan darurat

---

## 📊 Screenshot

### Dashboard Admin
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

### Sistem Absensi Karyawan
![Employee Attendance](docs/screenshots/employee-attendance.png)

### Manajemen Tugas
![Task Management](docs/screenshots/task-management.png)

### Laporan Darurat
![Emergency Reports](docs/screenshots/emergency-reports.png)

---

## 🤝 Kontribusi

Kami menerima kontribusi dari komunitas! Berikut cara berkontribusi:

### Development Setup
1. Fork repository
2. Clone fork Anda
3. Buat branch baru: `git checkout -b feature/nama-fitur`
4. Commit perubahan: `git commit -m 'Tambah fitur baru'`
5. Push ke branch: `git push origin feature/nama-fitur`
6. Buat Pull Request

### Guidelines
- Ikuti Laravel coding standards
- Tulis tests untuk fitur baru
- Update dokumentasi jika diperlukan
- Gunakan commit message yang descriptive

### Testing
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=UserTest
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

```
MIT License

Copyright (c) 2025 Sinergia Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

---

## 👥 Tim Pengembang

### Core Team
- **Agil Saputra** - Lead Developer & Project Manager
  - GitHub: [@Agil-Saputra](https://github.com/Agil-Saputra)
  - Email: agil@sinergia.com

### Contributors
Terima kasih kepada semua yang telah berkontribusi pada proyek ini!

---

## 📞 Support & Kontak

### Dukungan Teknis
- **Email**: support@sinergia.com
- **GitHub Issues**: [Create New Issue](https://github.com/Agil-Saputra/sinergia/issues)
- **Documentation**: [Wiki](https://github.com/Agil-Saputra/sinergia/wiki)

### Changelog
Lihat [CHANGELOG.md](CHANGELOG.md) untuk riwayat perubahan.

### Roadmap
Lihat [roadmap](https://github.com/Agil-Saputra/sinergia/projects) untuk fitur yang akan datang.

---

<p align="center">
  <strong>Dibuat dengan ❤️ oleh Tim Sinergia</strong>
</p>

<p align="center">
  <a href="#top">Kembali ke atas</a>
</p>

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
