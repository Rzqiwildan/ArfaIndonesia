<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route utama menggunakan controller
Route::get('/', [BookingController::class, 'index'])->name('form-booking');
Route::post('/booking/submit', [BookingController::class, 'submitForm'])->name('booking.submit');

Route::get('/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/mobil', function () {
        return view('admin/mobil');
    })->name('mobil');
    
    Route::get('/booking', function () {
        return view('admin/booking');
    })->name('booking');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route untuk mobil (tambahkan di web.php)
Route::prefix('admin')->middleware('auth')->group(function () {
     // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('admin.dashboard.data');
    Route::get('/dashboard/live-stats', [DashboardController::class, 'getLiveStats'])->name('admin.dashboard.live-stats');
    Route::get('/dashboard/booking-stats', [DashboardController::class, 'getBookingStats'])->name('admin.dashboard.booking-stats');
    Route::get('/dashboard/car-stats', [DashboardController::class, 'getCarStats'])->name('admin.dashboard.car-stats');
    Route::get('/dashboard/recent-bookings', [DashboardController::class, 'getRecentBookings'])->name('admin.dashboard.recent-bookings');
    Route::get('/dashboard/alerts', [DashboardController::class, 'getAlerts'])->name('admin.dashboard.alerts');
    
    
    // Route untuk halaman mobil (yang sudah ada)
    Route::get('/mobil', [MobilController::class, 'index'])->name('mobil.index');
    Route::get('/mobil/api', [MobilController::class, 'getMobils'])->name('mobil.api');
    Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');
    Route::put('/mobil/{id}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    // Route untuk halaman booking admin (BARU)
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/api', [AdminBookingController::class, 'getBookings'])->name('admin.booking.api');
    Route::put('/booking/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.booking.updateStatus');
    Route::delete('/booking/{id}', [AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');
    Route::get('/booking/{id}', [AdminBookingController::class, 'show'])->name('admin.booking.show');
});

require __DIR__.'/auth.php';