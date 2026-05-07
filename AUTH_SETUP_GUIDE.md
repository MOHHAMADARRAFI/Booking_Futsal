# Panduan Sistem Authentication - Booking Futsal

## 📋 Ringkasan
Sistem authentication untuk Booking Futsal telah diimplementasikan dengan support untuk 3 tipe role:
- **Customer**: Pelanggan yang menyewa lapangan
- **Owner**: Pemilik lapangan yang menyediakan lapangan
- **Admin**: Administrator sistem

## 📁 File-File yang Telah Dibuat

### 1. Views (Blade Templates)
```
resources/views/auth/
├── login.blade.php          # Halaman login
├── register.blade.php       # Halaman registrasi dengan pilihan role
└── forgot-password.blade.php # Halaman reset password (optional)
```

### 2. Controller
```
app/Http/Controllers/Auth/
└── AuthController.php       # Menangani semua logika authentication
```

### 3. Routes
```
routes/web.php             # Updated dengan routes authentication yang benar
```

## 🔐 Fitur-Fitur Authentication

### Login Page
- ✅ Form login dengan email & password
- ✅ Remember me checkbox
- ✅ Link "Lupa Password?"
- ✅ Redirect otomatis berdasarkan role (Admin/Owner/Customer)
- ✅ Error handling dan validation
- ✅ Modern UI dengan Bootstrap 5.3

### Register Page
- ✅ Form registrasi dengan field: name, email, phone, address
- ✅ Pilihan role: Customer atau Owner
- ✅ Password confirmation
- ✅ Terms & conditions checkbox
- ✅ Validasi email unique
- ✅ Password strength requirements
- ✅ Modern responsive design

### Forgot Password
- ✅ Form reset password dengan email
- ✅ Responsive design
- ✅ Back to login link

## 🚀 Cara Menggunakan

### 1. Testing Login
**Akses:** http://localhost/booking_futsalAPT/Booking_Futsal/login

**Test User yang Bisa Dibuat:**
```
Customer:
- Email: customer@example.com
- Password: (password yang sesuai requirement)
- Role: customer

Owner:
- Email: owner@example.com
- Password: (password yang sesuai requirement)
- Role: owner

Admin (harus dibuat via database/seeder):
- Email: admin@example.com
- Role: admin
```

### 2. Testing Register
**Akses:** http://localhost/booking_futsalAPT/Booking_Futsal/register

- Isi semua field yang diperlukan
- Pilih tipe akun (Customer atau Owner)
- Buat password sesuai requirements
- Klik "Daftar"

### 3. Post-Login Flow
Setelah login, user akan di-redirect ke:
- **Admin** → `/admin/dashboard`
- **Owner** → `/owner/dashboard`
- **Customer** → `/dashboard`

## ⚙️ Konfigurasi yang Diperlukan

### 1. Update Middleware (jika belum ada)
Pastikan file berikut sudah ada:
```
app/Http/Middleware/RedirectIfAuthenticated.php
app/Http/Middleware/AdminOnly.php
app/Http/Middleware/OwnerOnly.php
app/Http/Middleware/CustomerOnly.php
```

### 2. Update Kernel.php
Tambahkan middleware di `app/Http/Middleware/Kernel.php`:

```php
protected $middlewareAliases = [
    // ... existing middlewares
    'admin' => \App\Http\Middleware\AdminOnly::class,
    'owner' => \App\Http\Middleware\OwnerOnly::class,
    'customer' => \App\Http\Middleware\CustomerOnly::class,
];
```

### 3. AppServiceProvider (Optional)
Jika perlu customize password rules, update `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Validation\Rules\Password;

public function boot()
{
    Password::defaults(function () {
        return Password::min(8)
            ->mixedCase()
            ->numbers()
            ->symbols();
    });
}
```

## 🛡️ Security Features

✅ **CSRF Protection** - Semua form protected dengan CSRF token
✅ **Password Hashing** - Password di-hash menggunakan bcrypt
✅ **Email Validation** - Email harus unique di database
✅ **Session Management** - Session regenerate setelah login/logout
✅ **Role-Based Access** - Middleware untuk protect routes berdasarkan role
✅ **Input Validation** - Semua input di-validate server-side
✅ **Error Messages** - User-friendly error messages

## 📝 Database Setup

User table sudah punya fields:
- `id` (primary key)
- `name` (string)
- `email` (string, unique)
- `email_verified_at` (timestamp, nullable)
- `password` (string, hashed)
- `role` (string: customer, owner, admin)
- `status` (string: active, inactive)
- `phone` (string)
- `address` (text)
- `remember_token` (string, nullable)
- `created_at` & `updated_at` (timestamps)

## 🧪 Testing Checklist

### Login Flow
- [ ] Buka `/login`
- [ ] Input email & password yang benar
- [ ] Verify redirect ke dashboard yang sesuai dengan role
- [ ] Cek "Remember me" functionality
- [ ] Test invalid credentials → error message

### Register Flow
- [ ] Buka `/register`
- [ ] Isi semua required fields
- [ ] Pilih role Customer
- [ ] Verify email validation
- [ ] Verify password confirmation
- [ ] Submit & verify auto-login

### Logout
- [ ] Dari dashboard, click Logout
- [ ] Verify redirect ke home page
- [ ] Verify session cleared

## 📞 Support & Notes

- **Password Requirements**: Min 8 chars, uppercase, lowercase, numbers
- **Email**: Harus unique di database
- **Role Change**: Hanya bisa diubah oleh admin (manual database update)
- **Avatar**: Bisa ditambahkan di future updates

## 🔄 Next Steps (Optional Enhancements)

- [ ] Email verification untuk signup
- [ ] Social login (Google, Facebook)
- [ ] Two-factor authentication
- [ ] User profile edit page
- [ ] Password change functionality
- [ ] Account recovery via phone
- [ ] Activity logs

---
**Last Updated:** May 7, 2026
**Status:** ✅ Ready for Testing
