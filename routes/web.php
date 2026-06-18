<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StoreManageController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomepageBestsellingController;
use App\Http\Controllers\Admin\HomepageFeaturedCategoryController;
use App\Http\Controllers\Admin\HomepageHotDealController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\InvoiceController;


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
    $regularReels = \App\Models\Reel::with('product')->where('is_active', true)->latest()->get();
    $productReels = \App\Models\ProductReviewVideo::with('product')->where('is_active', true)->where('show_on_homepage', true)->latest()->get();
    $reels = $regularReels->concat($productReels)->sortByDesc('created_at')->values();
    $homepageReviews = \App\Models\Review::where('is_approved', true)->where('show_on_homepage', true)->latest()->get();
    return view('pages.home', compact('bestsellingProducts', 'featuredCategories', 'hotDealProducts', 'reels', 'homepageReviews'));
})->name('home');

Route::get('/shop/all', [FrontendProductController::class, 'index'])->name('products.all');

Route::get('/hot-deals', function (\App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface $hotDealRepo) {
    $ids = $hotDealRepo->getHotDealProductIds();
    
    if (empty($ids)) {
        $hotDealProducts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
    } else {
        $orderedIds = implode(',', $ids);
        $hotDealProducts = \App\Models\Product::whereIn('id', $ids)
                            ->where('is_active', true)
                            ->orderByRaw("FIELD(id, $orderedIds)")
                            ->paginate(20);
    }
    
    return view('pages.hot-deals', compact('hotDealProducts'));
})->name('hot-deals');


Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories');

Route::get('/brands', fn () => view('pages.brands'))->name('brands');

Route::get('/blog', function () {
    $reviews = \App\Models\Review::where('is_approved', true)->latest()->get();
    return view('pages.blog', compact('reviews'));
})->name('blog');

Route::post('/contact-us', [App\Http\Controllers\Frontend\CustomerActionController::class, 'storeMessage'])->name('contact.store');
Route::post('/reviews', [App\Http\Controllers\Frontend\CustomerActionController::class, 'storeReview'])->name('review.store');

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
    $orders = \App\Models\Order::where('user_id', auth()->id())
        ->with(['items.product', 'statusUpdates'])
        ->latest()
        ->get();
    $bankDetail = \App\Models\UserBankDetail::where('user_id', auth()->id())->first();
    $messages = \App\Models\CustomerMessage::where('user_id', auth()->id())
        ->orWhere('email', auth()->user()->email)
        ->latest()
        ->get();
    return view('pages.dashboard', compact('orders', 'bankDetail', 'messages'));
})->middleware(['auth'])->name('dashboard');

Route::post('/dashboard/bank-details', [App\Http\Controllers\Frontend\CustomerActionController::class, 'updateBankDetails'])
    ->middleware('auth')
    ->name('dashboard.bank-details.update');

Route::post('/dashboard/change-password', [App\Http\Controllers\Frontend\CustomerActionController::class, 'changePassword'])
    ->middleware('auth')
    ->name('dashboard.change-password');

// Password Reset Routes
Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/verify-code', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
Route::post('/verify-code', [\App\Http\Controllers\Auth\PasswordResetController::class, 'verifyCode'])->name('password.verify.submit');
Route::get('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/product/{id}', [FrontendProductController::class, 'show'])->name('product.detail');

Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/api/cart/summary', [CartController::class, 'getSummary'])->name('cart.summary');

Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->middleware('auth')->name('checkout.store');
Route::get('/orders/{order}/invoice', [InvoiceController::class, 'download'])->middleware('auth')->name('orders.invoice');
Route::get('/currency/switch/{code}', function (\Illuminate\Http\Request $request, $code) {
    $currency = \App\Models\Currency::where('code', $code)->where('is_active', true)->first();
    if ($currency) {
        session()->put('currency_code', $currency->code);
    }
    
    if ($request->has('redirect')) {
        return redirect($request->input('redirect'));
    }
    
    $referer = $request->headers->get('referer');
    if ($referer) {
        $path = parse_url($referer, PHP_URL_PATH);
        if ($path && !str_contains($path, '/api/') && !str_contains($path, '/cart/')) {
            return redirect($referer);
        }
    }
    
    $previousUrl = session()->get('_previous.url');
    if ($previousUrl) {
        $path = parse_url($previousUrl, PHP_URL_PATH);
        if ($path && !str_contains($path, '/api/') && !str_contains($path, '/cart/')) {
            return redirect($previousUrl);
        }
    }
    
    return redirect()->route('home');
})->name('currency.switch');

if (config('app.env') === 'local') {
    Route::post('/local/promote-me', function () {
        if (auth()->check()) {
            auth()->user()->update(['is_admin' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Your account has been promoted to Admin!');
        }
        return redirect()->route('login')->with('error', 'Please login first.');
    })->name('local.promote-me');

    Route::post('/local/login-admin', function () {
        $admin = \App\Models\User::where('email', 'admin123@gmail.com')->first();
        if ($admin) {
            auth()->login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Logged in as Admin successfully.');
        }
        return redirect()->route('login')->with('error', 'Admin user not found. Please seed the database.');
    })->name('local.login-admin');
}


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {

        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();

        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();

        $lowStockProducts = \App\Models\Product::where('is_active', true)
            ->where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $topSellingProducts = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->with('product')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Workable Revenue Graph Data (Monthly for Current Year)
        $monthlyRevenue = \App\Models\Order::select(
                \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as month'),
                \Illuminate\Support\Facades\DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $pkrAmount = (float)($monthlyRevenue[$m] ?? 0.0);
            $revenueData[] = \App\Helpers\CurrencyHelper::convert($pkrAmount);
        }

        $currentCurrencySymbol = \App\Helpers\CurrencyHelper::getCurrent()->symbol;

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'recentOrders',
            'lowStockProducts',
            'topSellingProducts',
            'revenueData',
            'currentCurrencySymbol'
        ));
    })->name('dashboard');

    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\RevenueAnalyticsController::class, 'index'])->name('analytics.index');
    Route::post('/analytics/sync', [\App\Http\Controllers\Admin\RevenueAnalyticsController::class, 'sync'])->name('analytics.sync');

    // Products
    Route::resource('products', AdminProductController::class)->except(['show']);
    
    // Product Testimonials
    Route::post('/products/{product}/testimonials', [AdminProductController::class, 'storeTestimonial'])->name('products.testimonials.store');
    Route::delete('/products/{product}/testimonials/{testimonial}', [AdminProductController::class, 'destroyTestimonial'])->name('products.testimonials.destroy');
    
    // Product Review Videos
    Route::post('/products/{product}/review-videos', [AdminProductController::class, 'storeReviewVideo'])->name('products.review_videos.store');
    Route::delete('/products/{product}/review-videos/{video}', [AdminProductController::class, 'destroyReviewVideo'])->name('products.review_videos.destroy');
    
    // Product Reviews
    Route::post('/products/{product}/reviews/{review}/approve', [AdminProductController::class, 'approveReview'])->name('products.reviews.approve');
    Route::delete('/products/{product}/reviews/{review}', [AdminProductController::class, 'destroyReview'])->name('products.reviews.destroy');

    // Customer Box / Messages
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [\App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');

    // Bestselling toggle
    Route::get('/product-management', [HomepageBestsellingController::class, 'index'])
        ->name('product-management');

    Route::post('/product-management/toggle/{product}', [HomepageBestsellingController::class, 'toggle'])
        ->name('product-management.toggle');

    // Categories (ADMIN)
    Route::post('/categories/page-settings', [CategoryController::class, 'updatePageSettings'])->name('categories.page-settings');
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
    Route::get('/store-manage', [StoreManageController::class, 'index'])->name('store-manage');
    Route::post('/store-manage', [StoreManageController::class, 'update'])->name('store-manage.update');
    Route::post('/store-manage/reset', [StoreManageController::class, 'reset'])->name('store-manage.reset');
    Route::get('/payment-gateways', [StoreManageController::class, 'paymentGateways'])->name('payment-gateways');
    Route::get('/payment-gateways/download', [StoreManageController::class, 'downloadTransactions'])->name('payment-gateways.download');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/customers', function (\Illuminate\Http\Request $request) {
        $search = $request->input('search');
        $query = \App\Models\User::where('is_admin', false)
            ->withCount('orders')
            ->withSum('orders', 'total_amount');
            
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();
        return view('admin.customers', compact('customers', 'search'));
    })->name('customers');

    Route::post('/customers', function (\Illuminate\Http\Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => false,
        ]);

        return back()->with('success', 'Customer account created successfully.');
    })->name('customers.store');

    Route::get('/reports', fn () => view('admin.reports'))->name('reports');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/homepage', [App\Http\Controllers\Admin\SettingsController::class, 'updateHomepage'])->name('settings.homepage');
    Route::post('/settings/footer', [App\Http\Controllers\Admin\SettingsController::class, 'updateFooter'])->name('settings.footer');
    Route::post('/settings/currencies', [App\Http\Controllers\Admin\SettingsController::class, 'storeCurrency'])->name('settings.currencies.store');
    Route::put('/settings/currencies/{currency}', [App\Http\Controllers\Admin\SettingsController::class, 'updateCurrency'])->name('settings.currencies.update');
    Route::delete('/settings/currencies/{currency}', [App\Http\Controllers\Admin\SettingsController::class, 'destroyCurrency'])->name('settings.currencies.destroy');

    // CRM Management (Messages handled by Admin\MessageController)

    Route::get('/reviews', [App\Http\Controllers\Admin\CRMController::class, 'reviewsIndex'])->name('reviews');
    Route::post('/reviews/{review}/approve', [App\Http\Controllers\Admin\CRMController::class, 'toggleReviewApproval'])->name('reviews.approve');
    Route::post('/reviews/{review}/toggle-homepage', [App\Http\Controllers\Admin\CRMController::class, 'toggleReviewHomepage'])->name('reviews.toggle_homepage');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\CRMController::class, 'destroyReview'])->name('reviews.destroy');

    // Reels CRUD
    Route::resource('reels', \App\Http\Controllers\Admin\ReelController::class)->except(['show']);
});