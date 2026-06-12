<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomepageBestsellingController;
use App\Http\Controllers\Admin\HomepageFeaturedCategoryController;
use App\Http\Controllers\Admin\HomepageHotDealController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function (
    \App\Repositories\Contracts\HomepageBestsellingProductRepositoryInterface $productRepo,
    \App\Repositories\Contracts\HomepageFeaturedCategoryRepositoryInterface $categoryRepo,
    \App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface $hotDealRepo
) {
    $bestsellingProducts = $productRepo->getBestsellingProducts();
    $featuredCategories = $categoryRepo->getFeaturedCategories();
    $hotDealProducts = $hotDealRepo->getHotDealProducts();
    $reels = \App\Models\Reel::with('product')->where('is_active', true)->latest()->get();
    return view('pages.home', compact('bestsellingProducts', 'featuredCategories', 'hotDealProducts', 'reels'));
})->name('home');

Route::get('/shop/all', [FrontendProductController::class, 'index'])->name('products.all');

Route::get('/hot-deals', function (\App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface $hotDealRepo) {
    $hotDealProducts = $hotDealRepo->getHotDealProducts();
    return view('pages.hot-deals', compact('hotDealProducts'));
})->name('hot-deals');


Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories');

Route::get('/brands', fn () => view('pages.brands'))->name('brands');

Route::get('/blog', fn () => view('pages.blog'))->name('blog');

Route::get('/featured', fn () => view('pages.featured'))->name('featured');

Route::get('/login', fn () => view('auth.login'))->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', fn () => view('auth.register'))->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return view('pages.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/product/{id}', [FrontendProductController::class, 'show'])->name('product.detail');

Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.detail');

Route::get('/cart', fn () => view('pages.cart'))->name('cart');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
        return view('admin.dashboard');
    })->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class)->except(['show']);

    // Bestselling toggle
    Route::get('/product-management', [HomepageBestsellingController::class, 'index'])
        ->name('product-management');

    Route::post('/product-management/toggle/{product}', [HomepageBestsellingController::class, 'toggle'])
        ->name('product-management.toggle');

    // Categories (ADMIN)
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('/category-management', [HomepageFeaturedCategoryController::class, 'index'])
        ->name('category-management');

    Route::post('/category-management/toggle/{category}', [HomepageFeaturedCategoryController::class, 'toggle'])
        ->name('category-management.toggle');

    Route::patch('/products/{product}/category', [AdminProductController::class, 'updateCategory'])
        ->name('products.update-category');

    // Hot deals
    Route::get('/hot-deals', [HomepageHotDealController::class, 'index'])->name('hot-deals');
    Route::get('/hot-deal-management', [HomepageHotDealController::class, 'manage'])->name('hot-deal-management');
    Route::post('/hot-deal-management/toggle/{product}', [HomepageHotDealController::class, 'toggle'])
        ->name('hot-deal-management.toggle');

    // Admin pages
    Route::get('/store-manage', fn () => view('admin.store-manage'))->name('store-manage');
    Route::get('/orders', fn () => view('admin.orders'))->name('orders');
    Route::get('/customers', fn () => view('admin.customers'))->name('customers');
    Route::get('/reports', fn () => view('admin.reports'))->name('reports');
    Route::get('/settings', fn () => view('admin.settings'))->name('settings');

    // Reels CRUD
    Route::resource('reels', \App\Http\Controllers\Admin\ReelController::class)->except(['show']);
});