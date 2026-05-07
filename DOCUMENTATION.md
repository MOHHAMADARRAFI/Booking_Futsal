# Sistem Informasi Penyewaan Lapangan Futsal Berbasis Web

Sistem informasi penyewaan lapangan futsal yang dirancang untuk memudahkan pelanggan dalam melakukan booking lapangan, menghindari bentrok jadwal, dan memberikan informasi jadwal secara real-time.

## 📋 Fitur Utama

### 1. Untuk Pelanggan (Customer)
- ✅ Melihat daftar lapangan yang tersedia
- ✅ Melihat detail lapangan (harga, lokasi, kapasitas, deskripsi)
- ✅ Melakukan booking lapangan dengan memilih tanggal dan waktu
- ✅ Melihat jadwal ketersediaan lapangan secara real-time
- ✅ Melakukan pembayaran untuk booking
- ✅ Melihat history pemesanan
- ✅ Memberikan review dan rating untuk lapangan
- ✅ Membatalkan booking jika diperlukan

### 2. Untuk Pemilik Lapangan (Owner)
- ✅ Menambahkan lapangan futsal baru
- ✅ Mengelola informasi lapangan (edit/hapus)
- ✅ Mengatur harga lapangan per jam
- ✅ Melihat semua pemesanan lapangan mereka
- ✅ Melihat laporan revenue/pendapatan
- ✅ Melihat status pembayaran booking

### 3. Untuk Administrator (Admin)
- ✅ Mengelola seluruh data lapangan
- ✅ Mengelola data user (customer, owner)
- ✅ Melihat semua pemesanan di sistem
- ✅ Mengubah status pemesanan
- ✅ Melihat laporan revenue keseluruhan
- ✅ Manage pembayaran
- ✅ Melihat statistik penggunaan

## 🏗️ Struktur Basis Data

### Tabel Users
```
- id (Primary Key)
- name (nama pengguna)
- email (email unique)
- password (password terenkripsi)
- role (admin, owner, customer)
- status (active, inactive, suspended)
- phone (nomor telepon)
- address (alamat)
- timestamps
```

### Tabel Courts
```
- id (Primary Key)
- name (nama lapangan)
- description (deskripsi lapangan)
- price_per_hour (harga per jam)
- capacity (kapasitas pemain)
- location (lokasi lapangan)
- image_url (URL gambar lapangan)
- status (active, inactive)
- owner_id (Foreign Key ke users)
- timestamps
```

### Tabel Bookings
```
- id (Primary Key)
- court_id (Foreign Key ke courts)
- user_id (Foreign Key ke users)
- booking_date (tanggal booking)
- start_time (waktu mulai)
- end_time (waktu selesai)
- total_price (harga total)
- status (pending, confirmed, cancelled, completed)
- notes (catatan)
- timestamps
```

### Tabel Payments
```
- id (Primary Key)
- booking_id (Foreign Key ke bookings)
- amount (jumlah pembayaran)
- payment_method (cash, card, bank_transfer, e_wallet)
- status (pending, completed, failed)
- transaction_id (ID transaksi)
- timestamps
```

### Tabel Reviews
```
- id (Primary Key)
- booking_id (Foreign Key ke bookings)
- user_id (Foreign Key ke users)
- rating (1-5 bintang)
- comment (komentar review)
- timestamps
```

## 🚀 Instalasi dan Setup

### Prerequisites
- PHP 8.0 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js & NPM (opsional, untuk asset compilation)

### Langkah Instalasi

1. **Clone repository atau ekstrak project**
```bash
cd "d:\Booking Futsal\Booking_Futsal"
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment file**
```bash
# Copy file contoh ke .env
copy .env.example .env

# Generate app key
php artisan key:generate
```

4. **Konfigurasi database**
Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_futsal
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan migrations dan seeders**
```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk test data
php artisan db:seed
```

6. **Setup storage**
```bash
php artisan storage:link
```

7. **Jalankan development server**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 📚 Data Test untuk Login

### Admin
- Email: `admin@booking.test`
- Password: `password`

### Owner 1
- Email: `owner1@booking.test`
- Password: `password`

### Owner 2
- Email: `owner2@booking.test`
- Password: `password`

### Customer 1-5
- Email: `customer1@booking.test` hingga `customer5@booking.test`
- Password: `password`

## 📁 Struktur Direktori

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── CourtController.php
│   │   │   ├── BookingController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── AdminCourtController.php
│   │   │   │   └── AdminBookingController.php
│   │   │   └── Owner/
│   │   │       ├── OwnerDashboardController.php
│   │   │       └── OwnerCourtController.php
│   │   ├── Middleware/
│   │   │   ├── AdminOnly.php
│   │   │   ├── OwnerOnly.php
│   │   │   └── CustomerOnly.php
│   │   └── Kernel.php
│   └── Models/
│       ├── User.php
│       ├── Court.php
│       ├── Booking.php
│       ├── Payment.php
│       └── Review.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── UserSeeder.php
│       ├── CourtSeeder.php
│       └── BookingSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── courts/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── bookings/
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       ├── admin/
│       │   └── dashboard.blade.php
│       ├── owner/
│       │   └── dashboard.blade.php
│       └── dashboard/
│           ├── customer.blade.php
│           └── admin.blade.php
└── routes/
    └── web.php
```

## 🔐 Role dan Permissions

### Admin
- Full access ke semua fitur sistem
- Dapat mengelola users, courts, bookings, dan payments
- Dapat melihat laporan keseluruhan

### Owner
- Dapat menambah/edit/hapus lapangan milik mereka
- Dapat melihat booking lapangan mereka
- Dapat melihat revenue dari lapangan mereka
- Tidak dapat mengakses data owner lain

### Customer
- Dapat melihat daftar lapangan
- Dapat membuat booking
- Dapat melakukan pembayaran
- Dapat memberikan review
- Hanya dapat melihat booking mereka sendiri

## 🛠️ Fitur Teknis

### Authentication & Authorization
- Role-based authentication dengan middleware
- Session management
- Password hashing dengan bcrypt

### Conflict Detection
- Sistem deteksi konflik waktu booking otomatis
- Validasi slot waktu yang sudah dipesan
- Real-time availability check

### Payment System
- Support multiple payment methods
- Transaction tracking
- Payment status management

### Reporting
- Revenue report per owner
- Booking statistics
- User activity tracking

## 📝 API Endpoints (Future)

Beberapa API endpoints yang dapat dikembangkan:

```
GET    /api/courts                    # Daftar lapangan
GET    /api/courts/:id                # Detail lapangan
GET    /api/courts/:id/available      # Slot tersedia
GET    /api/bookings                  # Daftar booking user
POST   /api/bookings                  # Buat booking
GET    /api/bookings/:id              # Detail booking
POST   /api/payments                  # Proses pembayaran
GET    /api/reviews                   # Daftar review
```

## 🐛 Troubleshooting

### Database Connection Error
- Pastikan MySQL server berjalan
- Verifikasi konfigurasi di .env
- Pastikan database sudah dibuat

### Migration Error
- Jalankan `php artisan migrate:refresh` untuk reset
- Periksa syntax SQL di migration files
- Pastikan tidak ada migration yang failed

### Permission Error
- Jalankan `php artisan storage:link` untuk storage
- Pastikan folder storage writable

## 📞 Support & Kontribusi

Untuk pertanyaan atau laporan bug, silakan hubungi tim development.

## 📄 Lisensi

Sistem ini dibuat untuk keperluan akademik dan bisnis.

---

**Dibuat dengan ❤️ menggunakan Laravel**
