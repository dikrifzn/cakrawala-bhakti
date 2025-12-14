<div align="center">

# 🎉 Cakrawala Bhakti - Event Management Platform

**Professional event organizer management platform built with Laravel 12 & Filament 4**

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament-4.0-9333EA?style=flat-square&logo=laravel)](https://filamentphp.com)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=flat-square&logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

[Features](#-fitur-utama) • [Quick Start](#-quick-start) • [Tech Stack](#-tech-stack) • [Documentation](#-dokumentasi) • [Contact](#-contact)

</div>

---

## 📋 Tentang Project

**Cakrawala Bhakti** adalah platform manajemen event organizer yang comprehensive dan user-friendly. Platform ini memungkinkan:

✅ Pelanggan untuk melakukan **pemesanan event dan layanan** secara online
✅ Admin untuk mengelola semua aspek bisnis melalui **dashboard Filament**
✅ Portfolio **showcase dengan galeri project dan artikel blog**
✅ Sistem notifikasi email otomatis untuk bookings
✅ Responsive design yang optimal di semua device

---

## 🚀 Fitur Utama

### 🏠 Public Website

-   **Homepage** dengan hero section, about, services showcase, dan CTA
-   **Article Blog** dengan category filtering dan search
-   **Project Portfolio** dengan masonry gallery dan lightbox
-   **Booking System** - customer bisa pesan event dengan live pricing
-   **Responsive Design** - optimal di mobile, tablet, desktop
-   **Smooth Animations** - AOS scroll animations di setiap section

### 🔐 Customer Features

-   **User Authentication** - register, login, password reset
-   **Booking Management** - lihat & track semua bookings
-   **Profile Management** - edit profile & password
-   **Email Notifications** - instant notifications untuk setiap update

### 👨‍💼 Admin Panel (Filament)

-   **Dashboard** dengan booking stats & quick actions
-   **Booking Management** - approve/reject dengan email notifications
-   **Service Management** - CRUD services dengan image upload
-   **Content Management** - manage articles, projects, portfolio
-   **Site Settings** - customize company info & social media
-   **Export Features** - export bookings ke PDF/Excel

---

## 🛠️ Tech Stack

| Layer            | Technology                    |
| ---------------- | ----------------------------- |
| **Backend**      | Laravel 12 (PHP 8.2+)         |
| **Admin Panel**  | Filament 4 (TALL Stack)       |
| **Frontend**     | Blade + Vite + Tailwind CSS 4 |
| **Database**     | MySQL 5.7+                    |
| **JavaScript**   | Alpine.js 3, Swiper 11        |
| **Animations**   | AOS.js 2.3.1                  |
| **Email**        | Laravel Mail + Queue          |
| **File Storage** | Local filesystem (S3 ready)   |

---

## ⚡ Quick Start

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js 16+
-   MySQL 5.7+
-   Git

### Installation

```bash
# 1. Clone repository
git clone <repository-url>
cd cakrawala-bhakti

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database di .env
DB_DATABASE=cakrawala
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seed
php artisan migrate:fresh --seed

# 6. Build assets
npm run build

# 7. Create storage symlink
php artisan storage:link

# ✅ Done! Aplikasi siap di-develop
```

### Running Development Server

```bash
# Terminal 1 - Jalankan 4 proses sekaligus
composer dev

# Atau jalankan secara terpisah:
php artisan serve              # http://localhost:8000
php artisan queue:work         # Process notifications
npm run dev                    # Compile assets
php artisan pail               # View logs
```

### Access Points

| Role                   | URL                         | Email                  | Password   |
| ---------------------- | --------------------------- | ---------------------- | ---------- |
| **Website**            | http://localhost:8000       | -                      | -          |
| **Admin Panel**        | http://localhost:8000/admin | `admin@cakrawala.com`    | `admin123` |
| **Manager Panel** | http://localhost:8000/manager       | `manager@cakrawala.com` | `manager123` |
| **Customer** (Testing) | http://localhost:8000       | `user@cakrawala.com` | `user123` |
---
<br>

> 💡 **Tip**: Jika ingin testing booking, gunakan akun user. Akun admin untuk manajemen di panel. dan Akun manager untuk Laporan di panel

---

## 📁 Project Structure

```
cakrawala-bhakti/
├── app/
│   ├── Filament/              # Admin panel components
│   ├── Http/Controllers/      # Page controllers
│   ├── Models/                # 13 Eloquent models
│   ├── Notifications/         # Email notifications
│   └── Helpers/               # ImageHelper, dll
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Tailwind styles
│   └── js/                    # Alpine.js
├── database/
│   ├── migrations/            # Database schemas
│   ├── factories/             # Test data factories
│   └── seeders/               # Initial data
├── routes/
│   └── web.php                # Public routes
└── storage/                   # File uploads

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

### Environment Variables

```env
# App
APP_NAME="Cakrawala Bhakti"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cakrawala
DB_USERNAME=root
DB_PASSWORD=

# Mail (untuk development)
MAIL_MAILER=log
# Atau gunakan mailtrap/mailgun

# Queue
QUEUE_CONNECTION=database

# Storage
FILESYSTEM_DISK=local
```

---

## 🧪 Testing

```bash
# Run all tests
composer test

# Run specific test
php artisan test tests/Feature/BookingTest.php

# With coverage
php artisan test --coverage
```

---

## 📦 Database Models

13 core models dengan relationships:

-   **User** - Admin & Customer accounts
-   **Booking** - Event orders
-   **BookingService** - Services dalam booking
-   **Service** - Available services
-   **EventType** - Tipe acara
-   **Project** - Portfolio projects
-   **Article** - Blog articles
-   **ArticleCategory** - Article categories
-   **HeroBanner** - Homepage hero section
-   **AboutSection** - About section
-   **WhyChooseUs** - Why choose us section
-   **CallToAction** - CTA section
-   **SiteSetting** - Global site configuration

---

## 🚀 Deployment

```bash
# 1. Prepare production
php artisan config:cache
php artisan route:cache
npm run build

# 2. Set environment
# .env: APP_ENV=production, APP_DEBUG=false

# 3. Run migrations
php artisan migrate --force

# 4. Setup queue worker
php artisan queue:work

# 5. Setup Laravel Horizon (optional for queue monitoring)
php artisan horizon
```

**Server Requirements:**

-   PHP 8.2+
-   Nginx/Apache
-   MySQL 5.7+
-   Composer
-   Node.js (untuk build only)

---

## 🐛 Troubleshooting

### Storage symlink error

```bash
php artisan storage:link
```

### Email not sending

```bash
# Check queue is running
php artisan queue:work

# Or use sync driver temporarily
QUEUE_CONNECTION=sync
```

### Database migration failed

```bash
# Fresh reset (development only)
php artisan migrate:fresh --seed
```

---

## 📞 Contact & Support

**PT Cakrawala Bhakti**

📧 Email: info@cakrawalabhakti.com
📱 Phone: (021) 1234-5678
📍 Address: Jl. Sudirman No. 123, Jakarta Pusat

📱 Social Media:

-   Instagram: [@cakrawalabhakti](https://instagram.com/cakrawalabhakti)
-   Facebook: [Cakrawala Bhakti](https://facebook.com/cakrawalabhakti)
-   TikTok: [@cakrawalabhakti](https://tiktok.com/@cakrawalabhakti)

---

## 📄 License

MIT License - lihat file [LICENSE](LICENSE)

---

<div align="center">

**Made with ❤️ by Kelompok 20 Kerja Praktik**

⭐ Jika project ini bermanfaat, silakan star repository ini!

[↑ Kembali ke atas](#-cakrawala-bhakti---event-management-platform)

</div>

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
