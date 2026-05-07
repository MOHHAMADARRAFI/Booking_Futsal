# 🎯 Sistem Penyewaan Lapangan Futsal - Web Information System

![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)

---

## 📌 Deskripsi Proyek

**Sistem Informasi Penyewaan Lapangan Futsal Berbasis Web** adalah aplikasi manajemen booking lapangan futsal yang dirancang untuk memfasilitasi tiga stakeholder utama:

- 👨‍💼 **Admin** - Mengelola seluruh sistem
- 👨‍🏢 **Pemilik (Owner)** - Mengelola lapangan mereka
- 👤 **Penyewa (Customer)** - Melakukan booking lapangan

### Tujuan Utama
1. ✅ Mempermudah pelanggan dalam melakukan booking lapangan
2. ✅ Menghindari bentrok jadwal penyewaan
3. ✅ Mempermudah admin dalam mengelola data penyewaan
4. ✅ Menyediakan informasi jadwal lapangan secara real-time

---

## 🚀 Quick Start

### Prerequisites
```bash
- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
```

### Installation

1. **Navigate to Project**
```bash
cd "d:\Booking Futsal\Booking_Futsal"
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
php artisan key:generate
```

4. **Configure Database in .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=booking_futsal
DB_USERNAME=root
DB_PASSWORD=
```

5. **Create Database**
```sql
CREATE DATABASE booking_futsal;
```

6. **Run Migrations & Seeders**
```bash
php artisan migrate --seed
```

7. **Start Server**
```bash
php artisan serve
```

Access: **http://localhost:8000**

---

## 👥 Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@booking.test | password |
| Owner 1 | owner1@booking.test | password |
| Owner 2 | owner2@booking.test | password |
| Customer | customer1@booking.test | password |

---

## 📊 Key Features

### For Customers
✅ Browse lapangan
✅ Book lapangan dengan deteksi konflik
✅ Proses pembayaran
✅ Beri review & rating

### For Owners
✅ Kelola lapangan
✅ Monitor booking
✅ Lihat revenue

### For Admin
✅ Dashboard admin
✅ Manage semua data
✅ Lihat laporan

---

## 📚 Documentation

- [DOCUMENTATION.md](DOCUMENTATION.md) - Full documentation
- [SETUP_GUIDE.md](SETUP_GUIDE.md) - Setup guide
- [RINGKASAN_SISTEM.md](RINGKASAN_SISTEM.md) - System summary (Indonesian)
- [DEVELOPER_QUICK_REFERENCE.md](DEVELOPER_QUICK_REFERENCE.md) - Code reference
- [DEPLOYMENT_TESTING_CHECKLIST.md](DEPLOYMENT_TESTING_CHECKLIST.md) - Testing checklist

---

## 🛠️ Technology Stack

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | Laravel 11, PHP 8.0+ |
| **Database** | MySQL 5.7+ |
| **Frontend** | Blade, Bootstrap 5 |
| **ORM** | Eloquent |

---

## ✨ System Status

✅ **PRODUCTION READY**

- 11 Controllers
- 5 Models
- 5 Migrations
- 15+ Views
- 3 Middleware
- 3 Seeders
- 20+ Routes

---

**Sistem siap untuk dijalankan! 🚀**

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Booking_Futsal
