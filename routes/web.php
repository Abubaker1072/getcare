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
        ->with('items.product')
        ->latest()
        ->get();
    return view('pages.dashboard', compact('orders'));
})->middleware(['auth'])->name('dashboard');

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
    Route::get('/store-manage', [StoreManageController::class, 'index'])->name('store-manage');
    Route::post('/store-manage', [StoreManageController::class, 'update'])->name('store-manage.update');
    Route::post('/store-manage/reset', [StoreManageController::class, 'reset'])->name('store-manage.reset');
    Route::get('/payment-gateways', [StoreManageController::class, 'paymentGateways'])->name('payment-gateways');
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
    Route::post('/settings/currencies', [App\Http\Controllers\Admin\SettingsController::class, 'storeCurrency'])->name('settings.currencies.store');
    Route::put('/settings/currencies/{currency}', [App\Http\Controllers\Admin\SettingsController::class, 'updateCurrency'])->name('settings.currencies.update');
    Route::delete('/settings/currencies/{currency}', [App\Http\Controllers\Admin\SettingsController::class, 'destroyCurrency'])->name('settings.currencies.destroy');

    // CRM Management
    Route::get('/messages', [App\Http\Controllers\Admin\CRMController::class, 'messagesIndex'])->name('messages');
    Route::post('/messages/{message}/read', [App\Http\Controllers\Admin\CRMController::class, 'toggleMessageRead'])->name('messages.read');
    Route::delete('/messages/{message}', [App\Http\Controllers\Admin\CRMController::class, 'destroyMessage'])->name('messages.destroy');

    Route::get('/reviews', [App\Http\Controllers\Admin\CRMController::class, 'reviewsIndex'])->name('reviews');
    Route::post('/reviews/{review}/approve', [App\Http\Controllers\Admin\CRMController::class, 'toggleReviewApproval'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\CRMController::class, 'destroyReview'])->name('reviews.destroy');

    // Reels CRUD
    Route::resource('reels', \App\Http\Controllers\Admin\ReelController::class)->except(['show']);
});