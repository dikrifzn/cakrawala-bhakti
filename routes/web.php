<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;

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

Route::get('/booking', function () {
    return view('pages.order.index');
});
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success', function () {
    return view('pages.order.success');
});