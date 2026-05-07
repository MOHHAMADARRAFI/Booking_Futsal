# 🚀 Developer Quick Reference

## File Structure Overview

```
d:\Booking Futsal\Booking_Futsal/
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
│   ├── Models/
│   │   ├── User.php
│   │   ├── Court.php
│   │   ├── Booking.php
│   │   ├── Payment.php
│   │   └── Review.php
│   └── Providers/
│
├── database/
│   ├── migrations/
│   │   ├── 2026_05_06_170835_create_courts_table.php
│   │   ├── 2026_05_06_170842_create_bookings_table.php
│   │   ├── 2026_05_06_170842_create_payments_table.php
│   │   ├── 2026_05_06_170843_create_reviews_table.php
│   │   └── 2026_05_06_170844_add_role_to_users_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── CourtSeeder.php
│       ├── BookingSeeder.php
│       └── DatabaseSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css (custom styling)
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php (main layout)
│       ├── courts/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── bookings/
│       │   ├── create.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── payments/
│       │   └── process.blade.php
│       ├── reviews/
│       │   └── create.blade.php
│       ├── dashboard/
│       │   ├── admin.blade.php
│       │   ├── owner.blade.php
│       │   └── customer.blade.php
│       └── welcome.blade.php
│
├── routes/
│   └── web.php (all routes defined here)
│
├── config/
│   ├── app.php
│   ├── database.php
│   └── ... (other configs)
│
├── .env (database & app config)
├── DOCUMENTATION.md (full system documentation)
├── SETUP_GUIDE.md (installation guide)
├── RINGKASAN_SISTEM.md (system summary in Indonesian)
└── artisan (Laravel CLI tool)
```

---

## Key Models & Relationships

### User Model
```php
hasMany('App\Models\Court', 'owner_id')  // As owner
hasMany('App\Models\Booking')            // As customer
hasMany('App\Models\Review')             // Reviews authored
```

### Court Model
```php
belongsTo('App\Models\User', 'owner_id')
hasMany('App\Models\Booking')
```

### Booking Model
```php
belongsTo('App\Models\Court')
belongsTo('App\Models\User')
hasOne('App\Models\Payment')
hasOne('App\Models\Review')
```

### Payment Model
```php
belongsTo('App\Models\Booking')
```

### Review Model
```php
belongsTo('App\Models\Booking')
belongsTo('App\Models\User')
```

---

## Controller Methods & Routes

### DashboardController
```php
index()  // Route user to role-specific dashboard
```
Routes: `GET /dashboard`

### CourtController
```php
index()                    // List active courts
show($id)                  // Show court detail with reviews
create()                   // Show create form
store(Request $request)    // Create court
edit($id)                  // Show edit form
update($id, Request $req)  // Update court
destroy($id)               // Delete court
getAvailableSlots($id)     // JSON API for time slots
```
Routes: `resource /courts`, `GET /api/courts/{id}/available-slots`

### BookingController
```php
index()                    // User's bookings
show($id)                  // Booking detail
create()                   // Booking form
store(Request $request)    // Create booking + conflict check
edit($id)                  // Edit form (only if pending)
update($id, Request $req)  // Update booking
destroy($id)               // Cancel booking (set status=cancelled)
```
Routes: `resource /bookings`

**Key Logic in store():**
```php
// Check for time conflicts
$existing = Booking::where('court_id', $courtId)
    ->where('booking_date', $bookingDate)
    ->where(function ($query) {
        $query->whereBetween('start_time', [$start, $end])
              ->orWhereBetween('end_time', [$start, $end]);
    })->exists();

if ($existing) {
    return back()->with('error', 'Time slot unavailable');
}

// Calculate price
$hours = calculateHours($startTime, $endTime);
$totalPrice = $hours * $court->price_per_hour;
```

### PaymentController
```php
process(Booking $booking)    // Show payment form
store(Request $request)      // Process payment
```
Routes: `GET /bookings/{id}/payment`, `POST /payments/store`

### ReviewController
```php
create(Booking $booking)       // Show review form
store(Request $request)        // Create review
destroy(Review $review)        // Delete review
```
Routes: `GET /bookings/{id}/review`, `POST /reviews/store`, `DELETE /reviews/{id}`

### Admin Controllers
```php
AdminDashboardController::index()
AdminCourtController: resource methods (all courts)
AdminBookingController::index(), show(), updateStatus()
```
Routes: `/admin/*` (protected by admin middleware)

### Owner Controllers
```php
OwnerDashboardController::index()
OwnerCourtController: resource methods (only owner's courts)
```
Routes: `/owner/*` (protected by owner middleware)

---

## Middleware

### AdminOnly
```php
// app/Http/Middleware/AdminOnly.php
if (!auth()->user()->isAdmin()) {
    abort(403, 'Unauthorized. Admin access only.');
}
```

### OwnerOnly
```php
// Check if user is owner
if (!auth()->user()->isOwner()) {
    abort(403, 'Unauthorized. Owner access only.');
}
```

### CustomerOnly
```php
// Check if user is customer
if (!auth()->user()->isCustomer()) {
    abort(403, 'Unauthorized. Customer access only.');
}
```

---

## Useful Helper Methods in Models

### User Model
```php
isAdmin()     // return $this->role === 'admin'
isOwner()     // return $this->role === 'owner'
isCustomer()  // return $this->role === 'customer'
```

### Booking Model
```php
// Status can be: pending, confirmed, cancelled, completed
// Status flow: pending -> confirmed -> completed
```

---

## Database Queries Reference

### Find bookings for a date
```php
$bookings = Booking::whereDate('booking_date', $date)->get();
```

### Find revenue for a court
```php
$revenue = Booking::where('court_id', $courtId)
    ->where('status', 'completed')
    ->sum('total_price');
```

### Find revenue for owner
```php
$revenue = Booking::whereIn('court_id', $owner->courts->pluck('id'))
    ->where('status', 'completed')
    ->sum('total_price');
```

### Find time conflicts
```php
$conflicts = Booking::where('court_id', $courtId)
    ->where('booking_date', $date)
    ->where(function ($query) use ($startTime, $endTime) {
        $query->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime]);
    })->exists();
```

---

## Views Variables Passed from Controllers

### Courts Index
```php
view('courts.index', [
    'courts' => $courts  // Paginated courts
])
```

### Courts Show
```php
view('courts.show', [
    'court' => $court,           // Court model
    'reviews' => $reviews        // Paginated reviews
])
```

### Bookings Create
```php
view('bookings.create', [
    'courts' => $courts  // Active courts for dropdown
])
```

### Bookings Index
```php
view('bookings.index', [
    'bookings' => $bookings  // User's bookings paginated
])
```

### Bookings Show
```php
view('bookings.show', [
    'booking' => $booking  // Booking with relationships
])
```

### Payments Process
```php
view('payments.process', [
    'booking' => $booking  // Booking to be paid
])
```

### Reviews Create
```php
view('reviews.create', [
    'booking' => $booking  // Booking to review
])
```

---

## Common Artisan Commands

```bash
# Create model with migration
php artisan make:model ModelName -m

# Create controller
php artisan make:controller ControllerName

# Create middleware
php artisan make:middleware MiddlewareName

# Create seeder
php artisan make:seeder SeederName

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Migrate + Seed (fresh)
php artisan migrate:fresh --seed

# Create migration
php artisan make:migration create_table_name

# Start dev server
php artisan serve

# Cache clear
php artisan cache:clear

# View routes
php artisan route:list
```

---

## Common Blade Syntax Used

```blade
{{ $variable }}              {{-- Echo variable --}}
@foreach($items as $item)   {{-- Loop --}}
@endforeach
@if($condition)             {{-- Conditional --}}
@endif
@auth                        {{-- If authenticated --}}
@endauth
@guest                       {{-- If not authenticated --}}
@endguest
{{ auth()->user() }}         {{-- Get current user --}}
@csrf                        {{-- CSRF token --}}
@method('PUT')               {{-- Spoof HTTP method --}}
route('route.name', $param)  {{-- Generate URL --}}
old('field')                 {{-- Get old input --}}
$errors->has('field')        {{-- Check validation error --}}
```

---

## Environment Variables (.env)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_futsal
DB_USERNAME=root
DB_PASSWORD=

APP_NAME="Booking Futsal"
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
```

---

## URL Routes Summary

| Method | Route | Controller | Purpose |
|--------|-------|-----------|---------|
| GET | / | - | Homepage |
| GET | /courts | CourtController@index | List courts |
| GET | /courts/{id} | CourtController@show | Court detail |
| GET | /dashboard | DashboardController@index | Role dashboard |
| POST | /bookings | BookingController@store | Create booking |
| GET | /bookings | BookingController@index | My bookings |
| GET | /bookings/{id} | BookingController@show | Booking detail |
| GET | /bookings/{id}/payment | PaymentController@process | Payment form |
| POST | /payments/store | PaymentController@store | Process payment |
| POST | /reviews/store | ReviewController@store | Create review |
| GET | /admin/dashboard | AdminDashboardController | Admin dash |
| GET | /owner/dashboard | OwnerDashboardController | Owner dash |

---

## Testing Flow

### Test as Customer
1. Go to http://localhost:8000
2. Login: customer1@booking.test / password
3. Browse courts
4. Book a court
5. Make payment
6. Add review

### Test as Owner
1. Login: owner1@booking.test / password
2. Go to /owner/dashboard
3. Manage your courts
4. See bookings for your courts

### Test as Admin
1. Login: admin@booking.test / password
2. Go to /admin/dashboard
3. View all system data
4. Manage users, courts, bookings

---

## Performance Tips

1. Use eager loading in controllers:
```php
$bookings = Booking::with(['court', 'payment', 'user'])->get();
```

2. Use select() to load specific columns:
```php
$courts = Court::select('id', 'name', 'price_per_hour')->get();
```

3. Use pagination for large datasets:
```php
$bookings = Booking::paginate(15);
```

4. Cache frequently accessed data:
```php
$courts = Cache::remember('courts', 3600, function () {
    return Court::where('status', 'active')->get();
});
```

---

## Debug Tips

### Check current user
```php
dd(auth()->user());
```

### Check if user is admin
```php
dd(auth()->user()->isAdmin());
```

### Debug query
```php
dd(Booking::query()->toSql());
```

### Log message
```php
\Log::info('Message here');
```

### Check routes
```bash
php artisan route:list
```

---

## Security Checklist

- [x] CSRF protection on forms
- [x] Password hashing
- [x] SQL injection prevention (Eloquent)
- [x] Authorization checks
- [x] Input validation
- [x] XSS protection (Blade escaping)
- [ ] Rate limiting (for production)
- [ ] HTTPS (for production)
- [ ] API authentication (if adding API)

---

**Happy coding! 🚀**
