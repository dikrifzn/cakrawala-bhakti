<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/galery', function () {
    return view('pages.galery.index');
});
Route::get('/article', function () {
    return view('pages.article.index');
});
Route::get('/article/detail', function () {
    return view('pages.article.detail');
});
Route::get('/booking/success', function () {
    return view('pages.order.success');
});

// Route::prefix('shop')->group(function () {
//     Route::get('/', [ShopController::class, 'index']);
//     Route::get('/{slug}', [ShopController::class, 'show']);
// });


// Route::prefix('articles')->group(function () {
//     Route::get('/', [ArticleController::class, 'index']);
//     Route::get('/{slug}', [ArticleController::class, 'show']);
// });

// Route::view('/about', 'pages.about');
// Route::view('/order/success', 'pages.order.success');
