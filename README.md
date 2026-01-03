<div align="center">

# 🎉 Cakrawala Bhakti - Event Management Platform

**Professional event organizer management platform built with Laravel 12 & Filament 4**

[![Laravel](https://img.shields.io/badge/Laravel-12.41-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament-4.2-9333EA?style=flat-square&logo=laravel)](https://filamentphp.com)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=flat-square&logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

[Features](#-fitur-utama) • [Quick Start](#-quick-start) • [Tech Stack](#-tech-stack) • [Documentation](#-dokumentasi) • [Contact](#-contact)

</div>

---

## 📋 Tentang Project

**Cakrawala Bhakti** adalah platform manajemen event organizer yang komprehensif dan user-friendly. Program ini dikembangkan sebagai bagian dari pemenuhan Kerja Praktik Fakultas Ilmu Komputer Universitas Kuningan, dengan tujuan membantu pengelolaan event secara lebih efektif, terstruktur, dan terintegrasi.

Platform ini menyediakan solusi lengkap untuk:

✅ **Pelanggan** - Pemesanan event online dengan workflow approval bertahap  
✅ **Admin & Manager** - Dashboard komprehensif dengan role-based access  
✅ **Portfolio** - Showcase project dan artikel blog dengan SEO-friendly design  
✅ **Automasi** - Notifikasi email real-time & PDF generation untuk dokumen  
✅ **Responsif** - Optimal di semua device (mobile, tablet, desktop)

---

## 🚀 Fitur Utama

### 🏠 Public Website

-   **Homepage** dengan hero section, about, why-choose-us, services, dan CTA
-   **Blog System** - artikel dengan kategori, search, dan filtering
-   **Project Portfolio** - galeri project dengan masonry layout
-   **Booking System** - customer bisa pesan event dengan live pricing calculation
-   **Responsive Design** - mobile-first approach, optimal di semua ukuran
-   **Smooth Animations** - AOS scroll animations & CSS transitions

### 👥 Customer Features

-   **Autentikasi** - register, login, password reset, email verification
-   **Booking Workflow** - Multi-stage approval process:
    1. Submit booking dengan detail event & services
    2. Admin review & kirim detail approval
    3. Customer approve & upload signature offline atau online
    4. Admin verify & generate approval document
    5. Tracking pengerjaan event dengan timeline tasks
-   **Manajemen Booking** - lihat, track, dan download dokumen
-   **Profile Management** - edit profile, password, dan informasi contact

### 👨‍💼 Admin Panel (Filament)

-   **Dashboard** dengan statistik booking & quick actions
-   **Booking Management**
    -   Review & approve/reject bookings
    -   Edit detail, tasks, dan approval document
    -   Upload offline signatures
    -   Download PDF approvals
    -   Export ke PDF/Excel dengan filtering
-   **Service Management** - CRUD services dengan image upload & pricing
-   **Content Management** - manage articles, projects, portfolio images
-   **Site Settings** - customize company info, social media, branding
-   **Export Features** - export bookings ke PDF dan CSV format
-   **Role-Based Access** - Admin (full) & Manager (reporting & export)

### 🔐 Security & Authorization

-   **BookingPolicy** - komprehensif authorization checks untuk semua operasi
-   **Role-Based Access Control** - Admin, Manager, dan Customer roles
-   **Middleware Protection** - EnsureAdminRole, EnsureManagerRole untuk routes
-   **File Access Control** - Download files hanya untuk authorized users

---

## 🛠️ Tech Stack

| Layer              | Technology                            |
| ------------------ | ------------------------------------- |
| **Backend**        | Laravel 12 (PHP 8.3+)                 |
| **Admin Panel**    | Filament 4.2 (TALL Stack)             |
| **Frontend**       | Blade + Vite + Tailwind CSS 4         |
| **Database**       | MySQL 5.7+ / MariaDB                  |
| **JavaScript**     | Alpine.js 3, ApexCharts 3             |
| **Animations**     | AOS.js 2.3.1, CSS Transitions         |
| **PDF Generation** | barryvdh/laravel-dompdf 3.0           |
| **Excel Export**   | maatwebsite/excel 3.1                 |
| **Email**          | Laravel Mail + Queue (database/async) |
| **Authentication** | Laravel Fortify (customized)          |
| **File Storage**   | Local filesystem (S3 ready)           |

---

## ⚡ Quick Start

### Prerequisites

-   PHP 8.3+ (tested on 8.3.11)
-   Composer 2.0+
-   Node.js 18+ (for Vite)
-   MySQL 5.7+ atau MariaDB
-   Git

### Installation

```bash
# 1. Clone repository
git clone https://github.com/yourusername/cakrawala-bhakti.git
cd cakrawala-bhakti

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cakrawala_bhakti
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seed test data
php artisan migrate:fresh --seed

# 6. Build frontend assets
npm run build

# 7. Create storage symlink untuk uploads
php artisan storage:link

# 8. (Optional) Cache Filament icons
php artisan icons:cache

# ✅ Setup selesai!
```

### Running Development Server

```bash
# Option 1: Run semua proses sekaligus (recommended)
composer run dev

# Option 2: Run terpisah di terminal berbeda
# Terminal 1
php artisan serve              # http://localhost:8000

# Terminal 2
npm run dev                    # Vite dev server (hot reload)

# Terminal 3
php artisan queue:listen       # Process notifications & async jobs

# Terminal 4 (Optional)
php artisan pail               # Real-time log viewer
```

### Access Points

| Role                   | URL                           | Email                   | Password     |
| ---------------------- | ----------------------------- | ----------------------- | ------------ |
| **Website**            | http://localhost:8000         | -                       | -            |
| **Admin Panel**        | http://localhost:8000/admin   | `admin@cakrawala.com`   | `admin123`   |
| **Manager Panel**      | http://localhost:8000/manager | `manager@cakrawala.com` | `manager123` |
| **Customer** (Testing) | http://localhost:8000         | `user@cakrawala.com`    | `user123`    |

---

## 📁 Project Structure

```
cakrawala-bhakti/
├── app/
│   ├── Filament/
│   │   ├── Resources/       # Filament CRUD resources
│   │   ├── Pages/           # Custom admin pages
│   │   └── Widgets/         # Dashboard widgets
│   ├── Http/
│   │   ├── Controllers/     # Page & API controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # 16+ Eloquent models
│   ├── Notifications/       # Email notifications
│   ├── Services/            # Business logic (ApprovalService, etc)
│   ├── Policies/            # Authorization policies
│   └── Helpers/             # Helper functions (ImageHelper, etc)
├── resources/
│   ├── views/
│   │   ├── pages/           # Public pages
│   │   ├── components/      # Blade components
│   │   ├── emails/          # Email templates
│   │   ├── filament/        # Filament custom views
│   │   └── layouts/         # Layout templates
│   ├── css/                 # Tailwind CSS
│   └── js/                  # Alpine.js & custom JS
├── database/
│   ├── migrations/          # 23+ database migrations
│   ├── factories/           # Model factories for testing
│   └── seeders/             # Database seeders
├── routes/
│   ├── web.php              # Public & auth routes
│   └── console.php          # Artisan commands
├── storage/
│   ├── app/public/          # File uploads (symlinked to public/)
│   ├── logs/                # Application logs
│   └── framework/           # Laravel framework files
└── tests/                   # Feature & Unit tests
```

## 🎯 Main Routes

### Public Pages

```
GET  /                    # Homepage
GET  /about               # About page
GET  /article             # Articles list
GET  /article/{article}   # Article detail
GET  /project             # Projects list
GET  /project/{project}   # Project detail
```

### Booking (Protected)

```
GET  /booking             # Booking form
POST /booking             # Submit booking
GET  /booking/success     # Success page
```

### Profile (Protected)

```
GET  /profile             # Edit profile
PUT  /profile             # Update profile
GET  /profile/bookings    # My bookings
GET  /profile/bookings/{id} # Booking detail
```

### Admin Panel

```
GET  /admin               # Dashboard
GET  /admin/bookings      # Manage bookings
GET  /admin/layanan       # Manage services
GET  /admin/articles      # Manage articles
GET  /admin/projects      # Manage projects
... dan resource lainnya
```

---

## 🔧 Configuration

### Environment Variables (.env)

```env
# Application
APP_NAME="Cakrawala-Bhakti"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cakrawala
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls

# Queue (untuk async jobs & notifications)
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=local
```

### Gmail Setup untuk Email

1. Enable 2-Factor Authentication
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Copy app password ke MAIL_PASSWORD di .env
4. Pastikan queue:listen running

---

---

## 📈 Booking Workflow

```
Customer                     Admin                      System
   |                           |                           |
   |-- 1. Submit Booking ----->|                           |
   |    (event + services)     |                           |
   |                           |-- 2. Review Detail ------>|
   |                           |   (edit jika perlu)       |
   |                           |-- 3. Send to Customer --->|
   |                           |   + Email notif           |
   |<-- Email notification ----|                           |
   |                           |                           |
   |-- 4. Approve/Reject ----->|                           |
   |   + View details          |-- 5. Generate PDF ------->|
   |   + Sign online/offline   |   (approval document)     |
   |                           |                           |
   |<-- Email confirmation ----|                           |
   |                           |                           |
   |-- 6. Upload Signature --->| (optional for offline)    |
   |                           |                           |
   |-- 7. Track Progress ----->|                           |
   |   (timeline gantt)        |-- 8. Update Timeline ---->|
   |                           |   (tasks & progress)      |
   |                           |                           |
   |<-- Final notification ----|-- 9. Mark Done ---------->|
   |                           |                           |
```

---


## 🚀 Deployment

### Pre-Deployment Checklist

```bash
# 1. Optimize aplikasi
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
php artisan icon:cache

# 2. Build frontend
npm run build

# 3. Migrate production database
php artisan migrate --force

# 4. Seed (hanya jika fresh install)
php artisan db:seed --class=DatabaseSeeder
```

### Server Requirements

-   PHP 8.3+
-   Nginx atau Apache
-   MySQL 5.7+ atau MariaDB
-   Node.js (untuk build only, bukan production)
-   SSL Certificate (HTTPS recommended)

### Running Queue on Production

```bash
# Supervisor configuration untuk queue worker
[program:cakrawala-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/cakrawala-bhakti/artisan queue:work database --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/path/to/worker.log
```

---

## 🐛 Troubleshooting

### Storage Symlink Error

```bash
php artisan storage:link
```

### Email Not Sending

```bash
# 1. Check queue is running
php artisan queue:work

# 2. Check mail configuration in .env
# 3. Test email dengan artisan
php artisan tinker
Mail::raw('test', fn($m) => $m->to('test@example.com'));
```

### Database Migration Failed

```bash
# Development: Fresh reset
php artisan migrate:fresh --seed

# Production: Rollback & retry
php artisan migrate:rollback
php artisan migrate
```

### File Upload Permission Denied

```bash
# Fix storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Make sure symlink exists
php artisan storage:link
```

### ApexCharts Not Rendering

```bash
# Clear browser cache
# Rebuild frontend
npm run build

# Check CDN is accessible
# https://cdn.jsdelivr.net/npm/apexcharts@latest
```

---

## 📚 Documentation

### File Structure

-   **Routes**: [routes/web.php](routes/web.php)
-   **Models**: [app/Models](app/Models)
-   **Controllers**: [app/Http/Controllers](app/Http/Controllers)
-   **Filament Resources**: [app/Filament/Resources](app/Filament/Resources)
-   **Policies**: [app/Policies](app/Policies)
-   **Migrations**: [database/migrations](database/migrations)
-   **Seeders**: [database/seeders](database/seeders)

### Key Classes

-   **Booking Model**: [app/Models/Booking.php](app/Models/Booking.php)
-   **BookingPolicy**: [app/Policies/BookingPolicy.php](app/Policies/BookingPolicy.php)
-   **ApprovalService**: [app/Services/ApprovalService.php](app/Services/ApprovalService.php)
-   **BookingController**: [app/Http/Controllers/BookingController.php](app/Http/Controllers/BookingController.php)

---

## 📞 Contact & Support

**PT Cakrawala Bhakti**

📧 Email: info@cakrawalabhakti.com  
📱 Phone: +62 821-1816-2013  
📍 Address: Perumahan Pesona Ancaran Blok C No.61, Desa Ancaran, Kec. Kuningan, Kab. Kuningan, Prov. Jawa Barat, 45514. Indonesia.

**Social Media**

-   Instagram: [@cakrawalabhakti](https://instagram.com/cakrawalabhakti)

---

## 📄 License

MIT License - lihat file [LICENSE](LICENSE)

---

## 👥 Contributors

Developed by **Kelompok 20** - Kerja Praktik Fakultas Ilmu Komputer, Universitas Kuningan

---

<div align="center">

**Made with ❤️ by Kelompok 20 Kerja Praktik**

⭐ Jika project ini bermanfaat, silakan star repository ini!

[↑ Kembali ke atas](#-cakrawala-bhakti---event-management-platform)

</div>