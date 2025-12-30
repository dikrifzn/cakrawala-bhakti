<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;

// Auth Routes
Route::get('/login', [HomeController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/customer/logout', [AuthController::class, 'logout'])->name('customer.logout')->middleware('auth');
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


// Booking Event
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index')->middleware('auth');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/booking/success', function () {
    return view('pages.order.success');
});

// Admin review proposal event
Route::get('/admin/booking/{booking}/review', [BookingController::class, 'adminReview'])->name('booking.admin.review')->middleware('auth');
// Admin blade views for detail input and upload
Route::get('/admin/booking/{booking}/details-input', [BookingController::class, 'detailsInputView'])->name('booking.admin.detailsView')->middleware('auth');
Route::get('/admin/booking/{booking}/upload-view', [BookingController::class, 'uploadView'])->name('booking.admin.uploadView')->middleware('auth');
Route::post('/admin/booking/{booking}/approve', [BookingController::class, 'adminApprove'])->name('booking.admin.approve')->middleware('auth');
Route::post('/admin/booking/{booking}/reject', [BookingController::class, 'adminReject'])->name('booking.admin.reject')->middleware('auth');

// Admin kirim rincian jasa ke client
Route::post('/admin/booking/{booking}/send-details', [BookingController::class, 'sendDetailsToClient'])->name('booking.admin.sendDetails')->middleware('auth');

// Client review rincian jasa
Route::get('/booking/{booking}/details', [BookingController::class, 'clientViewDetails'])->name('booking.client.details')->middleware('auth');
Route::post('/booking/{booking}/approve-details', [BookingController::class, 'clientApproveDetails'])->name('booking.client.approveDetails')->middleware('auth');
Route::post('/booking/{booking}/reject-details', [BookingController::class, 'clientRejectDetails'])->name('booking.client.rejectDetails')->middleware('auth');

// Admin upload gantt chart & lembar persetujuan
Route::post('/admin/booking/{booking}/upload-gantt', [BookingController::class, 'uploadGantt'])->name('booking.admin.uploadGantt')->middleware('auth');

// Client final approval
Route::post('/booking/{booking}/final-approve', [BookingController::class, 'clientFinalApprove'])->name('booking.client.finalApprove')->middleware('auth');

// Secure download for stored files (proposal, gantt, approval)
Route::get('/booking/{booking}/download/{type}', [BookingController::class, 'downloadFile'])->name('booking.downloadFile')->middleware('auth');

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