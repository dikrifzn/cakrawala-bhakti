<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('pages.home');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/project', function () {
    return view('pages.project.index');
});
Route::get('/project/detail', function () {
    return view('pages.project.detail');
});

// Article
Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('/article/category/{slug}', [ArticleController::class, 'byCategory'])->name('article.category');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show');

Route::get('/booking', function () {
    return view('pages.order.index');
});
Route::get('/booking/success', function () {
    return view('pages.order.success');
});