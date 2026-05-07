# Setup Guide - Sistem Penyewaan Lapangan Futsal

## 🔧 Persiapan Awal

### 1. Database Setup

Buat database baru di MySQL:
```sql
CREATE DATABASE booking_futsal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Environment Configuration

Edit file `.env` dan pastikan konfigurasi database benar:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_futsal
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Dependencies

```bash
cd "d:\Booking Futsal\Booking_Futsal"
composer install
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Run Seeders (untuk data test)

```bash
php artisan db:seed
```

### 7. Start Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

---

## 👥 Test Accounts

Setelah menjalankan seeder, gunakan akun berikut untuk login:

### Admin Account
```
Email: admin@booking.test
Password: password
```

### Owner Accounts
```
Email: owner1@booking.test
Password: password

Email: owner2@booking.test
Password: password
```

### Customer Accounts
```
Email: customer1@booking.test - customer5@booking.test
Password: password
```

---

## 🎯 Testing Alur

### Sebagai Customer:
1. Login dengan akun customer
2. Klik "Lapangan" di navbar untuk melihat daftar lapangan
3. Klik "Lihat Detail & Booking" pada salah satu lapangan
4. Klik "Booking Lapangan Ini"
5. Pilih tanggal, waktu mulai, dan waktu selesai
6. Klik "Lanjutkan ke Pembayaran"
7. Pilih metode pembayaran
8. Klik "Bayar Sekarang"

### Sebagai Owner:
1. Login dengan akun owner
2. Akses "Owner Panel" di navbar
3. Kelola lapangan milik Anda
4. Lihat pemesanan dan revenue

### Sebagai Admin:
1. Login dengan akun admin
2. Akses "Admin Panel" di navbar
3. Kelola semua data sistem
4. Lihat semua pemesanan dan payments

---

## 📊 Fitur yang Sudah Diimplementasikan

### ✅ Core Features
- [x] User authentication & authorization
- [x] Role-based access control (Admin, Owner, Customer)
- [x] Court management
- [x] Booking system
- [x] Payment processing
- [x] Review system
- [x] Conflict detection (booking time slot)
- [x] Dashboard per role
- [x] Responsive UI dengan Bootstrap 5

### ✅ Database
- [x] User management dengan roles
- [x] Court data dengan owner relationship
- [x] Booking dengan conflict detection
- [x] Payment tracking
- [x] Review & rating system

### ✅ Security
- [x] Password hashing
- [x] CSRF protection
- [x] Role-based authorization
- [x] Middleware for role protection
- [x] Validation on all inputs

---

## 🚀 Features Siap untuk Development Selanjutnya

### Untuk Enhancement:
1. **Email Notifications**
   - Konfirmasi booking via email
   - Payment confirmation
   - Reminder booking

2. **SMS Integration**
   - SMS reminder sebelum booking
   - Payment confirmation via SMS

3. **Payment Gateway Integration**
   - Midtrans / Xendit integration
   - Real payment processing
   - Automatic payment verification

4. **Advanced Reports**
   - PDF report generation
   - Excel export
   - Analytics dashboard

5. **Mobile App**
   - React Native / Flutter app
   - Push notifications

6. **Advanced Features**
   - Booking cancellation policy
   - Deposit system
   - Membership system
   - Rating/review moderation

---

## 📝 Notes

- Semua password test adalah "password"
- Database akan di-reset setiap kali menjalankan `php artisan migrate:fresh --seed`
- Untuk production, gunakan environment variables yang aman
- Setup SSL/HTTPS untuk production

---

## ❓ Troubleshooting

### Jika ada error saat migrate:
```bash
php artisan migrate:fresh --seed
```

### Jika ada error saat membuka halaman:
- Pastikan `php artisan serve` berjalan
- Clear cache: `php artisan cache:clear`
- Regenerate key jika diperlukan: `php artisan key:generate`

### Jika tidak bisa login:
- Pastikan sudah menjalankan seeder
- Clear browser cache dan cookies
- Coba incognito mode

---

## 📞 Support

Untuk bantuan lebih lanjut, refer ke DOCUMENTATION.md
