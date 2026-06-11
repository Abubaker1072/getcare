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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/product/{id}', function ($id) {
    return view('pages.product-detail', compact('id'));
})->name('product.detail');

Route::get('/category/{slug}', function ($slug) {
    return view('pages.category-detail', compact('slug'));
})->name('category.detail');

Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');