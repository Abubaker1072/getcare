<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('products.index');

Route::get('/shop/all', function () {
    return view('pages.shop');
})->name('products.all');

Route::get('/hot-deals', function () {
    return view('pages.hot-deals');
})->name('hot-deals');

Route::get('/categories', function () {
    return view('pages.categories');
})->name('categories');

Route::get('/brands', function () {
    return view('pages.brands');
})->name('brands');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/featured', function () {
    return view('pages.featured');
})->name('featured');
