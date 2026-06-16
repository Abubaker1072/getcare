@php
    $cartItemsCount = \App\Models\CartItem::where(auth()->check() ? ['user_id' => auth()->id()] : ['session_id' => session()->getId()])->sum('quantity');
@endphp
<header class="w-full bg-white fixed top-0 left-0 z-50">
    {{-- Promotional Banner --}}
    <div class="w-full bg-amber-100 border-b py-2 md:py-3 text-center text-xs md:text-sm text-gray-700">
        <div class="flex items-center justify-center gap-2 md:gap-4 px-2">
            <button class="text-gray-500 hover:text-gray-700 flex-shrink-0">‹</button>
            <span class="font-semibold truncate">Semi-Annual Sale | Up to 20% OFF NOW</span>
            <button class="text-gray-500 hover:text-gray-700 flex-shrink-0">›</button>
        </div>
    </div>

    {{-- Top Header: Logo + Currency + Icons --}}
    <div class="w-full bg-white border-b py-3 md:py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-3 md:px-4">
            {{-- Hamburger Menu Button (Mobile Only) --}}
            <button id="mobile-menu-toggle" class="lg:hidden text-gray-700 hover:text-amber-600 transition flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') ?? '#' }}" class="text-lg md:text-2xl font-bold tracking-widest text-gray-900">
                    GetCare<br><span class="text-xs font-light">BEAUTY</span>
                </a>
            </div>

            {{-- Main Navigation Menu --}}
            <nav class="hidden lg:flex items-center gap-4 xl:gap-8 text-xs xl:text-sm font-medium">
                <a href="{{ route('home') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    Home
                </a>
                <a href="{{ route('products.all') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    PRODUCTS
                </a>
                <a href="{{ route('hot-deals') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    HOT DEALS
                </a>
                <a href="{{ route('categories') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    CATEGORIES
                </a>
                <a href="{{ route('brands') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    shop
                </a>
                
                <a href="{{ route('blog') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    contact us 
                </a>
            </nav>

            {{-- Right Icons: Currency + Account + Search + Cart --}}
            <div class="flex items-center gap-3 md:gap-6">
                {{-- Currency Selector --}}
                @php
                    $activeCurrencies = \App\Models\Currency::where('is_active', true)->get();
                    $currentCurrency = \App\Helpers\CurrencyHelper::getCurrent();
                @endphp
                <div class="hidden md:flex items-center gap-2 bg-slate-50 border border-slate-200/50 px-2.5 py-1 rounded-xl shadow-inner">
                    <select onchange="window.location.href='/currency/switch/' + this.value" class="bg-transparent border-none outline-none text-xs font-bold text-slate-700 cursor-pointer hover:text-amber-600 focus:ring-0 py-0.5 pl-1 pr-6">
                        @foreach($activeCurrencies as $curr)
                            <option value="{{ $curr->code }}" {{ $currentCurrency->code === $curr->code ? 'selected' : '' }}>
                                {{ $curr->code }} ({{ $curr->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Account Icon --}}
                {{-- Account Link --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-amber-600 transition flex items-center gap-1">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden md:inline">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-600 transition flex items-center gap-1">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden md:inline">Login</span>
                    </a>
                @endauth

                {{-- Search Icon --}}
                <a href="#" id="search-icon" class="text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </a>

                {{-- Shopping Cart Icon --}}
                <a href="#" id="cart-icon" class="relative text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span id="cart-badge-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center">{{ $cartItemsCount }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Promo Code + Countdown Banner --}}
    @php
        $countdownActive = \App\Models\StoreSetting::getValue('countdown_is_active', '1') === '1';
        $countdownEndTime = \App\Models\StoreSetting::getValue('countdown_end_time');
        $countdownText = \App\Models\StoreSetting::getValue('countdown_text', 'Up to 20% Off | Code REFRESH20');
    @endphp
    @if($countdownActive && $countdownEndTime)
    <div class="w-full bg-red-900 text-white py-2 md:py-3" id="promo-countdown-banner" data-end="{{ $countdownEndTime }}">
        <div class="max-w-7xl mx-auto px-3 md:px-4 flex flex-col md:flex-row items-center justify-center gap-3 md:gap-8 text-xs md:text-sm">
            <span class="font-semibold underline text-xs md:text-sm">{{ $countdownText }}</span>
            <div class="flex items-center gap-4 md:gap-8 font-mono text-base md:text-lg font-bold">
                <div class="text-center">
                    <div class="text-lg md:text-2xl" id="countdown-hours">00</div>
                    <div class="text-xs uppercase">Hrs</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div class="text-lg md:text-2xl" id="countdown-minutes">00</div>
                    <div class="text-xs uppercase">Min</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div class="text-lg md:text-2xl" id="countdown-seconds">00</div>
                    <div class="text-xs uppercase">Sec</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Mobile Menu Navigation (Hidden by default, toggled with hamburger) --}}
    <div id="mobile-menu" class="lg:hidden hidden w-full bg-white border-t max-h-96 overflow-y-auto">
        <ul class="main-nav nav navbar-nav flex flex-col">
            <li class="border-b"><a href="{{ route('home') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Home</a></li>
            <li class="border-b"><a href="{{ route('hot-deals') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Hot Deals</a></li>
            <li class="border-b"><a href="{{ route('categories') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Categories</a></li>
            <li class="border-b"><a href="{{ route('brands') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">All Brands</a></li>
            <li class="border-b"><a href="{{ route('featured') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Featured Products</a></li>
            <li class="border-b px-4 py-3 flex items-center justify-between text-sm text-gray-700 bg-slate-50/50">
                <span class="font-bold flex items-center gap-1.5 text-xs uppercase tracking-wider text-slate-500">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Currency
                </span>
                <select onchange="window.location.href='/currency/switch/' + this.value" class="bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-700 cursor-pointer focus:ring-0 py-1 pl-2 pr-8">
                    @foreach($activeCurrencies as $curr)
                        <option value="{{ $curr->code }}" {{ $currentCurrency->code === $curr->code ? 'selected' : '' }}>
                            {{ $curr->code }} ({{ $curr->symbol }})
                        </option>
                    @endforeach
                </select>
            </li>
            <li><a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Contact us</a></li>
        </ul>
    </div>
</header>

{{-- Spacing for fixed header --}}
<div class="h-24 md:h-32 lg:h-40"></div>

{{-- Mobile Menu Toggle Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Close menu when a link is clicked
            const menuLinks = mobileMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });
        }
    });
</script>

{{-- Cart Drawer Overlay --}}
<div id="cart-drawer-backdrop" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
<div id="cart-drawer" class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
    {{-- Drawer Header --}}
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800">Your Cart</h2>
        <button id="close-cart" class="text-gray-500 hover:text-red-500 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    {{-- Drawer Body --}}
    <div id="cart-drawer-items" class="flex-1 overflow-y-auto p-6 flex flex-col gap-4">
        {{-- Items will be loaded dynamically --}}
    </div>
    
    {{-- Drawer Footer --}}
    <div class="border-t p-6 bg-gray-50">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 font-medium">Subtotal</span>
            <span id="cart-drawer-subtotal" class="text-xl font-bold text-gray-900">₨ 0</span>
        </div>
        <p class="text-xs text-gray-500 mb-4 text-center">Shipping and taxes calculated at checkout.</p>
        <div class="space-y-3">
            <a href="{{ route('cart') }}" class="block w-full py-3 px-4 bg-gray-900 text-white text-center rounded-md font-semibold hover:bg-gray-800 transition">View Cart</a>
            <a href="/checkout" class="block w-full py-3 px-4 bg-amber-500 text-white text-center rounded-md font-semibold hover:bg-amber-600 transition shadow-md shadow-amber-200">Checkout</a>
        </div>
    </div>
</div>

{{-- Search Modal Overlay --}}
<div id="search-modal" class="fixed inset-0 bg-white/95 backdrop-blur-sm z-[80] hidden opacity-0 transition-opacity duration-300 flex-col">
    <div class="max-w-4xl mx-auto w-full px-4 pt-16 sm:pt-24 relative flex-1">
        <button id="close-search" class="absolute top-4 right-4 sm:top-8 sm:right-8 text-gray-500 hover:text-red-500 transition">
            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="text-center mb-8 transform -translate-y-4 opacity-0 transition-all duration-500" id="search-content">
            <h2 class="text-3xl sm:text-5xl font-bold text-gray-800 mb-6 font-serif">What are you looking for?</h2>
            
            <form action="#" method="GET" class="relative max-w-2xl mx-auto">
                <input type="text" name="q" placeholder="Search products, brands, categories..." class="w-full text-lg sm:text-2xl px-0 py-4 border-b-2 border-gray-300 focus:border-amber-500 bg-transparent outline-none placeholder:text-gray-400 transition-colors" autofocus>
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
            
            <div class="mt-10 flex flex-wrap justify-center gap-2 sm:gap-4 text-sm">
                <span class="text-gray-500">Popular:</span>
                <a href="#" class="text-amber-600 hover:underline">Massage Mat</a>
                <a href="#" class="text-amber-600 hover:underline">Back Brace</a>
                <a href="#" class="text-amber-600 hover:underline">Skincare</a>
                <a href="#" class="text-amber-600 hover:underline">Gifts</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cart Drawer Logic
        const cartIcon = document.getElementById('cart-icon');
        const cartDrawer = document.getElementById('cart-drawer');
        const cartBackdrop = document.getElementById('cart-drawer-backdrop');
        const closeCartBtn = document.getElementById('close-cart');

        window.openCart = function(e) {
            if(e) e.preventDefault();
            cartBackdrop.classList.remove('hidden');
            setTimeout(() => {
                cartBackdrop.classList.remove('opacity-0');
                cartDrawer.classList.remove('translate-x-full');
            }, 10);
            document.body.classList.add('overflow-hidden');
            window.updateCartDrawer();
        };

        window.closeCart = function() {
            cartBackdrop.classList.add('opacity-0');
            cartDrawer.classList.add('translate-x-full');
            setTimeout(() => {
                cartBackdrop.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        };

        if (cartIcon) cartIcon.addEventListener('click', window.openCart);
        if (closeCartBtn) closeCartBtn.addEventListener('click', window.closeCart);
        if (cartBackdrop) cartBackdrop.addEventListener('click', window.closeCart);

        // Fetch Cart Summary dynamically
        window.updateCartDrawer = function() {
            fetch('/api/cart/summary', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    // Update badge count
                    const badges = document.querySelectorAll('#cart-badge-count');
                    badges.forEach(badge => {
                        badge.innerText = data.cart_count;
                        if (data.cart_count > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    });
                    
                    // Update Drawer items
                    const itemsContainer = document.getElementById('cart-drawer-items');
                    if (!itemsContainer) return;
                    
                    if (data.items.length === 0) {
                        itemsContainer.innerHTML = `
                            <div class="flex flex-col items-center justify-center h-full text-gray-400 py-12">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-sm font-medium">Your cart is empty</p>
                            </div>
                        `;
                        document.getElementById('cart-drawer-subtotal').innerText = data.formatted_subtotal || '₨ 0';
                        return;
                    }
                    
                    let html = '';
                    data.items.forEach(item => {
                        html += `
                        <div class="flex items-center gap-4 pb-4 border-b">
                            <div class="w-20 h-20 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                <img src="${item.image_url}" alt="${item.name}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2">${item.name}</h3>
                                <p class="text-xs text-gray-500 mt-1">Quantity: ${item.quantity}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-sm font-bold text-amber-600">${item.formatted_price}</span>
                                    <button onclick="window.removeCartItem(${item.id})" class="text-xs text-red-500 hover:underline">Remove</button>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    itemsContainer.innerHTML = html;
                    document.getElementById('cart-drawer-subtotal').innerText = data.formatted_subtotal;
                });
        };

        // Remove item AJAX
        window.removeCartItem = function(id) {
            fetch(`/cart/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                window.updateCartDrawer();
                // If we are on the cart details page, reload to update the main page
                if (window.location.pathname === '/cart') {
                    window.location.reload();
                }
            });
        };

        // Add item AJAX
        window.addToCart = function(productId, quantity = 1) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw new Error(err.error || 'Failed to add item to cart'); });
                }
                return res.json();
            })
            .then(data => {
                window.updateCartDrawer();
                window.openCart();
            })
            .catch(err => {
                alert(err.message);
            });
        };

        // Initial fetch on page load
        window.updateCartDrawer();

        // Search Modal Logic
        const searchIcon = document.getElementById('search-icon');
        const searchModal = document.getElementById('search-modal');
        const closeSearchBtn = document.getElementById('close-search');
        const searchContent = document.getElementById('search-content');
        const searchInput = searchModal?.querySelector('input[name="q"]');

        window.openSearch = function(e) {
            if(e) e.preventDefault();
            searchModal.classList.remove('hidden');
            searchModal.classList.add('flex');
            setTimeout(() => {
                searchModal.classList.remove('opacity-0');
                searchContent.classList.remove('-translate-y-4', 'opacity-0');
                if(searchInput) searchInput.focus();
            }, 10);
            document.body.classList.add('overflow-hidden');
        };

        window.closeSearch = function() {
            searchModal.classList.add('opacity-0');
            searchContent.classList.add('-translate-y-4', 'opacity-0');
            setTimeout(() => {
                searchModal.classList.add('hidden');
                searchModal.classList.remove('flex');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        };

        if (searchIcon) searchIcon.addEventListener('click', window.openSearch);
        if (closeSearchBtn) closeSearchBtn.addEventListener('click', window.closeSearch);

        // Countdown Timer Logic
        const banner = document.getElementById('promo-countdown-banner');
        if (banner) {
            const endTimeStr = banner.getAttribute('data-end');
            if (endTimeStr) {
                const endTime = new Date(endTimeStr).getTime();
                
                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = endTime - now;
                    
                    if (distance < 0) {
                        banner.classList.add('hidden');
                        clearInterval(timerInterval);
                        return;
                    }
                    
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    const hrsEl = document.getElementById('countdown-hours');
                    const minsEl = document.getElementById('countdown-minutes');
                    const secsEl = document.getElementById('countdown-seconds');
                    
                    if(hrsEl) hrsEl.innerText = hours.toString().padStart(2, '0');
                    if(minsEl) minsEl.innerText = minutes.toString().padStart(2, '0');
                    if(secsEl) secsEl.innerText = seconds.toString().padStart(2, '0');
                }
                
                updateTimer();
                const timerInterval = setInterval(updateTimer, 1000);
            }
        }
    });
</script>