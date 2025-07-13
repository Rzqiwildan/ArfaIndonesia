<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route utama menggunakan controller
Route::get('/', [BookingController::class, 'index'])->name('home');

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

Route::post('/form-booking', [BookingController::class, 'submitForm'])->name('form.submit');
require __DIR__.'/auth.php';