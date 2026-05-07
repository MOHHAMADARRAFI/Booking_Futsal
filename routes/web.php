<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCourtController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\OwnerCourtController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/courts', [CourtController::class, 'index'])->name('courts.index');
Route::get('/courts/{id}', [CourtController::class, 'show'])->name('courts.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking routes
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'destroy'])->name('bookings.cancel');

    // Payment routes
    Route::get('/bookings/{booking}/payment', [PaymentController::class, 'process'])->name('payments.process');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');

    // Review routes
    Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Owner routes
Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('courts', OwnerCourtController::class);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('courts', AdminCourtController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::post('/bookings/{booking}/update-status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

// Owner court routes
Route::middleware(['auth', 'owner'])->get('/courts/create', [CourtController::class, 'create'])->name('courts.create');
Route::middleware(['auth', 'owner'])->post('/courts', [CourtController::class, 'store'])->name('courts.store');
Route::middleware(['auth', 'owner'])->get('/courts/{id}/edit', [CourtController::class, 'edit'])->name('courts.edit');
Route::middleware(['auth', 'owner'])->put('/courts/{id}', [CourtController::class, 'update'])->name('courts.update');
Route::middleware(['auth', 'owner'])->delete('/courts/{id}', [CourtController::class, 'destroy'])->name('courts.destroy');

// API routes for AJAX
Route::get('/api/courts/{id}/available-slots', [CourtController::class, 'getAvailableSlots'])->name('api.courts.available-slots');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Password reset routes (optional - for future implementation)
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');