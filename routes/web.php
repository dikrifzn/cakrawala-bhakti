<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/{slug}', [ShopController::class, 'show']);
});

Route::get('/gallery', [GalleryController::class, 'index']);

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{slug}', [ArticleController::class, 'show']);
});

Route::view('/about', 'pages.about');
Route::view('/order/success', 'pages.order.success');
