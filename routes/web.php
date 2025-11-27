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
Route::get('/booking', function () {
    return view('pages.order.index');
});
Route::get('/booking/success', function () {
    return view('pages.order.success');
});