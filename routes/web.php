<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/customer/logout', [AuthController::class, 'logout'])->name('customer.logout')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('pages.about');
});

// Projects
Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');

// Article
Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('/article/category/{slug}', [ArticleController::class, 'byCategory'])->name('article.category');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show');

Route::get('/booking', [BookingController::class, 'index'])->name('booking.index')->middleware('auth');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/booking/success', function () {
    return view('pages.order.success');
});

Route::get('/emailnotification/status', function () {
    $booking = \App\Models\Booking::with(['eventType', 'services'])->first();
    return view('emails.booking.status-updated', ['booking' => $booking]);
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/bookings', [ProfileController::class, 'bookings'])->name('profile.bookings');
    Route::get('/profile/bookings/{id}', [ProfileController::class, 'showBooking'])->name('profile.booking-detail');
});