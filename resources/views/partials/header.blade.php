@php
    $cartItemsCount = \App\Models\CartItem::where(auth()->check() ? ['user_id' => auth()->id()] : ['session_id' => session()->getId()])->sum('quantity');
    $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
    $isTheme2 = ($homepageTheme === 'theme_2');
    $popularSearches = \App\Models\PopularSearch::orderBy('sort_order')->orderBy('created_at', 'desc')->take(12)->get();
    $isHome = request()->is('/');
@endphp

<style>
    /* Smooth page scrolling */
    html { scroll-behavior: smooth; }

    /* Header Scroll Transitions */
    #main-header {
        transition: background-color 0.4s ease, box-shadow 0.4s ease, backdrop-filter 0.4s ease;
    }
    
    /* Classes applied via JS when scrolled past 50px */
    #main-header.is-scrolled {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Change text/icon colors to dark when scrolled */
    #main-header.is-scrolled .dynamic-color {
        color: #111827 !important; /* Tailwind gray-900 */
    }

    /* Theme 2 custom styles */
    .theme-2-header#main-header.is-scrolled {
        background-color: rgba(12, 12, 14, 0.93) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .theme-2-header#main-header.is-scrolled .dynamic-color {
        color: #ffffff !important;
    }
    .theme-2-header .nav-link:hover,
    .theme-2-header .dynamic-color:hover {
        color: #fbbf24 !important; /* amber-400 */
    }
    .theme-2-promo {
        background-color: #08080a !important;
        color: #fbbf24 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .theme-2-dark {
        background-color: #0c0c0e !important;
        color: #f3e8ff !important;
    }
    .theme-2-dark-border {
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    /* Elegant Nav Link Hover/Click Animation */
    .nav-link {
        position: relative;
        display: inline-block;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 1.5px;
        bottom: -4px;
        left: 0;
        background-color: currentColor;
        transform-origin: bottom right;
        transition: transform 0.3s cubic-bezier(0.65, 0, 0.35, 1);
    }
    .nav-link:hover::after, 
    .nav-link:active::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    
    /* Hide scrollbars for Category menu */
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<header id="main-header" class="w-full fixed top-0 left-0 z-50 flex flex-col {{ !$isHome ? 'is-scrolled' : '' }} {{ $isTheme2 ? 'theme-2-header' : '' }}">

    {{-- Promotional Banner (Continuous Text) --}}
    <div class="w-full {{ $isTheme2 ? 'theme-2-promo' : 'bg-[#dce0da]' }} py-2 overflow-hidden flex whitespace-nowrap text-[13px] text-gray-800 font-medium">
        <div class="flex items-center justify-start gap-12 px-4 animate-marquee w-full">
            <span class="flex items-center gap-2">Free Shipping Over $50! Returns are always on us. <span class="text-gray-500 text-lg leading-none">›</span></span>
            <span class="flex items-center gap-2 hidden md:flex">Free Shipping Over $50! Returns are always on us. <span class="text-gray-500 text-lg leading-none">›</span></span>
            <span class="flex items-center gap-2 hidden lg:flex">Free Shipping Over $50! Returns are always on us. <span class="text-gray-500 text-lg leading-none">›</span></span>
        </div>
    </div>

    {{-- Top Header: Navigation + Icons --}}
    <div class="w-full py-4 md:py-5">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between px-6 md:px-8 relative">
            
            {{-- Left Side: Hamburger & Navigation --}}
            <div class="flex-1 flex items-center gap-8">
                {{-- Hamburger Menu Button (Mobile) --}}
                <button id="mobile-menu-toggle" class="dynamic-color text-white hover:opacity-70 transition-opacity flex-shrink-0 lg:hidden">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                {{-- Main Navigation Menu (Desktop) --}}
                <nav class="hidden lg:flex items-center gap-3.5 xl:gap-6 text-[10px] xl:text-xs font-bold tracking-wide uppercase">
                    <a href="{{ route('home') ?? '#' }}" class="dynamic-color text-white nav-link">Home</a>
                    <a href="{{ route('products.all') ?? '#' }}" class="dynamic-color text-white nav-link">Products</a>
                    <a href="{{ route('hot-deals') ?? '#' }}" class="dynamic-color text-white nav-link">Hot Deals</a>
                    
                    {{-- Categories Dropdown --}}
                    @php
                        $headerCategories = \App\Models\Category::with(['products' => function($query) {
                            $query->where('is_active', true)->latest()->take(10);
                        }])->where('status', true)->take(12)->get();
                    @endphp
                    <div class="group/cat relative py-4">
                        <a href="{{ route('categories') ?? '#' }}" class="dynamic-color text-white nav-link transition-all duration-300 select-none">
                            Categories
                        </a>
                        
                        {{-- Small Triangle Arrow --}}
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[6px] {{ $isTheme2 ? 'border-b-[#0c0c0e]' : 'border-b-white' }} opacity-0 invisible group-hover/cat:opacity-100 group-hover/cat:visible transition-all duration-300 z-50"></div>
                        
                        {{-- Dropdown Menu --}}
                        <div class="absolute top-full left-0 pt-2 opacity-0 invisible group-hover/cat:opacity-100 group-hover/cat:visible transition-all duration-300 z-50 transform translate-y-2 group-hover/cat:translate-y-0 w-[750px] xl:w-[950px]">
                            <div class="{{ $isTheme2 ? 'bg-[#0c0c0e]/95 border-white/5 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] text-slate-100' : 'bg-white border-slate-200 shadow-2xl text-slate-800' }} backdrop-blur-2xl border rounded-3xl overflow-hidden flex h-[480px]">
                                <!-- Left column: Category tabs (Temu Style) -->
                                <div class="w-[240px] xl:w-[260px] {{ $isTheme2 ? 'bg-[#08080a] border-white/5' : 'bg-[#f5f5f5] border-slate-100' }} border-r flex flex-col py-4 overflow-y-auto scrollbar-none flex-shrink-0">
                                    @foreach($headerCategories as $index => $cat)
                                        <div class="category-tab px-6 py-3.5 flex items-center justify-between cursor-pointer transition-colors duration-150 {{ $index === 0 ? ($isTheme2 ? 'bg-[#0c0c0e] font-bold text-amber-400' : 'bg-white font-bold text-slate-900') : ($isTheme2 ? 'text-slate-400 font-medium hover:bg-slate-900/50' : 'text-slate-600 font-medium hover:bg-white/50') }}" 
                                             data-category-id="{{ $cat->id }}">
                                            <span class="text-xs xl:text-[13px] tracking-wide truncate">{{ $cat->name }}</span>
                                            <svg class="w-3.5 h-3.5 {{ $index === 0 ? ($isTheme2 ? 'text-amber-400' : 'text-slate-800') : 'text-slate-400' }} chevron-icon transition-colors duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Right column: Products panels -->
                                <div class="flex-1 {{ $isTheme2 ? 'bg-[#0c0c0e]' : 'bg-white' }} p-6 xl:p-8 overflow-y-auto relative">
                                    @foreach($headerCategories as $index => $cat)
                                        <div id="category-panel-{{ $cat->id }}" class="category-panel {{ $index === 0 ? 'block' : 'hidden' }} transition-all duration-300">
                                            <!-- Panel Header -->
                                            <div class="flex items-center justify-between mb-6 pb-4 {{ $isTheme2 ? 'border-white/5' : 'border-slate-100' }} border-b">
                                                <h3 class="{{ $isTheme2 ? 'text-white' : 'text-slate-800' }} font-bold text-xs tracking-widest uppercase">Featured in {{ $cat->name }}</h3>
                                                <a href="{{ route('category.detail', $cat->slug) }}" class="{{ $isTheme2 ? 'text-amber-400 hover:text-amber-300' : 'text-amber-600 hover:text-amber-700' }} text-xs font-bold tracking-wider uppercase flex items-center gap-1 group/link">
                                                    View All
                                                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                </a>
                                            </div>

                                            <!-- Products Grid (Temu circular items style) -->
                                            @if($cat->products->isEmpty())
                                                <div class="flex flex-col items-center justify-center h-[280px] {{ $isTheme2 ? 'text-slate-500' : 'text-slate-400' }}">
                                                    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                    <p class="text-sm font-medium">No products found in this category.</p>
                                                </div>
                                            @else
                                                <div class="grid grid-cols-3 xl:grid-cols-4 gap-x-8 xl:gap-x-10 gap-y-8">
                                                    @foreach($cat->products as $prod)
                                                        <a href="{{ route('product.detail', $prod->id) }}" class="flex flex-col items-center group/prod text-center relative">
                                                            <!-- Round Image Container (Temu Style) -->
                                                            <div class="w-16 h-16 xl:w-20 xl:h-20 rounded-full overflow-hidden {{ $isTheme2 ? 'bg-slate-900/60 border-white/5' : 'bg-slate-100 border-slate-200' }} border flex items-center justify-center mb-2 relative transition-all duration-300 group-hover/prod:scale-105 group-hover/prod:shadow-md p-0">
                                                                <img src="{{ asset('storage/' . $prod->image) }}" 
                                                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&q=80';" 
                                                                     alt="{{ $prod->name }}" 
                                                                     class="w-full h-full object-cover">
                                                                
                                                                <!-- HOT Badge -->
                                                                @if($prod->is_on_sale || ($prod->purchased_count ?? 0) > 10)
                                                                    <div class="absolute -top-0.5 -right-0.5 bg-[#ff470b] text-white text-[8px] font-extrabold px-1.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm z-10">
                                                                        HOT
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <!-- Title -->
                                                            <span class="text-[10px] xl:text-[11px] font-bold uppercase tracking-wider {{ $isTheme2 ? 'text-slate-400 group-hover/prod:text-amber-400' : 'text-slate-500 group-hover/prod:text-slate-800' }} transition-colors line-clamp-2 w-full px-1 leading-snug mt-2 text-center">
                                                                {{ $prod->name }}
                                                            </span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ route('brands') ?? '#' }}" class="dynamic-color text-white nav-link">Shop</a> --}}
                    <a href="{{ route('blog') ?? '#' }}" class="dynamic-color text-white nav-link">Contact Us</a>
                </nav>
            </div>

            {{-- Center Logo: Absolute positioned to stay perfectly centered --}}
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex-shrink-0 text-center">
                <a href="{{ route('home') ?? '#' }}" class="dynamic-color text-2xl font-bold tracking-widest text-white hover:opacity-80 transition-opacity duration-300">
                    GetCare<br><span class="text-[10px] font-light tracking-[0.3em] block mt-[-4px]">BEAUTY</span>
                </a>
            </div>

            {{-- Right Side: Currency + Account + Search + Cart --}}
            <div class="flex-1 flex items-center justify-end gap-3 sm:gap-4 md:gap-7 relative">
                
                {{-- Currency Selector --}}
                @php
                    $activeCurrencies = \App\Models\Currency::where('is_active', true)->get();
                    $currentCurrency = \App\Helpers\CurrencyHelper::getCurrent();
                @endphp
                <div id="currency-selector-container" class="absolute right-0 top-full mt-4 md:static md:mt-0 flex items-center gap-1 md:gap-2 dynamic-color text-white transition-opacity duration-300">
                    <span class="text-lg leading-none hidden md:inline-block" id="currency-active-flag">{{ \App\Helpers\CurrencyHelper::getFlag($currentCurrency->code) }}</span>
                    <div class="relative flex items-center">
                        <select onchange="window.location.href='/currency/switch/' + this.value" class="bg-transparent border-none outline-none text-sm font-semibold cursor-pointer focus:ring-0 py-1 pl-1 pr-5 appearance-none z-10 dynamic-color text-white">
                            @foreach($activeCurrencies as $curr)
                                <option value="{{ $curr->code }}" {{ $currentCurrency->code === $curr->code ? 'selected' : '' }} class="text-black">
                                    {{ \App\Helpers\CurrencyHelper::getFlag($curr->code) }} {{ $curr->code }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-3.5 h-3.5 absolute right-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                        </svg>
                    </div>
                </div>

                {{-- Search Icon --}}
                <a href="#" id="search-icon" class="dynamic-color text-white hover:opacity-70 transition-opacity transform hover:scale-105 duration-200 ml-2 sm:ml-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                    </svg>
                </a>

                {{-- Account/User Dropdown Logic --}}
                <div class="relative">
                    @auth
                        {{-- Logged In User Menu Toggle --}}
                        <button id="user-menu-btn" class="dynamic-color text-white hover:opacity-70 transition-opacity transform hover:scale-105 duration-200 flex items-center focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                            </svg>
                        </button>
                        
                        {{-- Dropdown Content --}}
                        <div id="user-dropdown-menu" class="hidden absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Logged Out Login Link --}}
                        <a href="{{ route('login') }}" class="dynamic-color text-white hover:opacity-70 transition-opacity transform hover:scale-105 duration-200 flex items-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                            </svg>
                        </a>
                    @endauth
                </div>

                {{-- Shopping Bag Cart Icon --}}
                <a href="#" id="cart-icon" onclick="event.preventDefault(); window.openSideCart();" class="relative dynamic-color text-white hover:opacity-70 transition-opacity transform hover:scale-105 duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5h.008v.008h-.008v-.008zm5.625 0h.008v.008h-.008v-.008z"></path>
                    </svg>
                    <span id="cart-badge-count" class="{{ $cartItemsCount > 0 ? '' : 'hidden' }} absolute -top-1.5 -right-2 bg-amber-600 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white">{{ $cartItemsCount }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Navigation --}}
    <div id="mobile-menu" class="lg:hidden hidden w-full {{ $isTheme2 ? 'theme-2-dark border-t border-white/5' : 'bg-white border-t' }} max-h-96 overflow-y-auto absolute top-full left-0 shadow-lg {{ $isTheme2 ? 'text-slate-100' : 'text-gray-900' }} uppercase">
        <ul class="main-nav nav flex flex-col">
            <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('home') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Home</a></li>
            <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('products.all') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Products</a></li>
            <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('hot-deals') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Hot Deals</a></li>
            <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('categories') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Categories</a></li>
            {{-- <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('brands') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Shop</a></li> --}}
            <li class="{{ $isTheme2 ? 'border-b border-white/5' : 'border-b' }}"><a href="{{ route('blog') ?? '#' }}" class="block px-6 py-4 text-sm font-semibold {{ $isTheme2 ? 'hover:bg-slate-900 hover:text-amber-400' : 'hover:bg-gray-50' }} transition">Contact Us</a></li>
        </ul>
    </div>
</header>


{{-- Search Modal HTML --}}
<div id="search-modal" class="absolute md:fixed inset-x-0 top-0 min-h-screen md:inset-0 {{ $isTheme2 ? 'bg-[#0c0c0e]/95 backdrop-blur-md text-[#f3e8ff]' : 'bg-white/95 backdrop-blur-sm' }} z-[80] hidden opacity-0 transition-opacity duration-300 flex-col">
    <div class="max-w-3xl mx-auto w-full px-4 pt-4 sm:pt-20 relative flex-1">
        <!-- Close Button Top Right -->
        <button id="close-search" class="absolute top-3 right-4 sm:top-8 sm:right-8 {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-gray-500 hover:text-red-500' }} transition transform hover:rotate-90 duration-300 hidden sm:block">
            <svg class="w-6 h-6 sm:w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="mb-8 transform -translate-y-4 opacity-0 transition-all duration-500" id="search-content">
            <!-- Search bar row -->
            <div class="flex items-center gap-2 sm:gap-4 mb-5 sm:mb-8">
                <!-- Back button (<) -->
                <button type="button" onclick="window.closeSearch()" class="text-gray-900 {{ $isTheme2 ? 'text-white hover:text-amber-400' : 'text-gray-800 hover:text-gray-600' }} transition flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
                    </svg>
                </button>
                
                <!-- Form with round black border and solid circle search button -->
                <form action="{{ route('products.all') }}" method="GET" class="relative flex-1 m-0">
                    <input type="text" name="q" placeholder="Search GetCare..." class="w-full text-xs sm:text-base pl-4 pr-10 py-1.5 sm:pl-6 sm:pr-14 sm:py-3 border {{ $isTheme2 ? 'border-amber-400 bg-slate-900 text-white placeholder:text-slate-500' : 'border-gray-300 focus:border-black bg-gray-50/70 text-black placeholder:text-gray-400' }} rounded-full outline-none focus:ring-0" autofocus>
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-6 h-6 sm:w-9 sm:h-9 {{ $isTheme2 ? 'bg-amber-500 text-slate-950 hover:bg-amber-400' : 'bg-black text-white hover:bg-gray-800' }} rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-3 h-3 sm:w-4.5 sm:h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Popular right now section -->
            <div class="mt-4 sm:mt-8 text-left">
                <h3 class="text-sm sm:text-lg font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} mb-3 sm:mb-4 font-sans tracking-tight">Popular right now</h3>
                <div class="flex flex-wrap gap-1.5 sm:gap-2.5">
                    @forelse($popularSearches as $search)
                        <a href="{{ route('products.all') }}?q={{ urlencode($search->name) }}" class="flex items-center gap-1.5 sm:gap-2 {{ $isTheme2 ? 'bg-[#1c1c1e] text-slate-200 hover:bg-slate-800 hover:text-white' : 'bg-slate-100 text-slate-800 hover:bg-slate-200 hover:text-black' }} rounded-full p-1 pr-3 sm:p-1.5 sm:pr-4 transition-all max-w-full">
                            <!-- Small round image -->
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full overflow-hidden flex-shrink-0 bg-white">
                                @if($search->image)
                                    <img src="{{ asset('storage/' . $search->image) }}" alt="{{ $search->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-amber-100 flex items-center justify-center text-amber-600 text-[10px] sm:text-[11px] font-bold font-sans">
                                        {{ strtoupper(substr($search->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Fire emoji + Text -->
                            <span class="text-[12px] sm:text-[14px] font-medium truncate flex items-center gap-1">
                                @if($search->is_hot)
                                    <span>🔥</span>
                                @endif
                                {{ $search->name }}
                            </span>
                        </a>
                    @empty
                        <span class="text-sm text-slate-400 italic">No popular searches set.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 0. Re-added Scroll Animation Logic (Header is transparent on homepage top scroll) ---
        const mainHeader = document.getElementById('main-header');
        const isHome = {{ $isHome ? 'true' : 'false' }};
        
        if (isHome && mainHeader) {
            function handleScroll() {
                if (window.scrollY > 30) {
                    mainHeader.classList.add('is-scrolled');
                } else {
                    mainHeader.classList.remove('is-scrolled');
                }
            }
            window.addEventListener('scroll', handleScroll);
            handleScroll(); // initial state check
        }

        // --- Categories Megamenu Tab Switch Logic ---
        const categoryTabs = document.querySelectorAll('.category-tab');
        const isTheme2 = {{ $isTheme2 ? 'true' : 'false' }};
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('mouseenter', function() {
                const categoryId = this.getAttribute('data-category-id');
                
                // 1. Reset all tabs
                categoryTabs.forEach(t => {
                    t.classList.remove('bg-white', 'font-bold', 'text-slate-900', 'bg-[#0c0c0e]', 'text-amber-400');
                    if (isTheme2) {
                        t.classList.add('text-slate-400', 'font-medium');
                    } else {
                        t.classList.add('text-slate-600', 'font-medium');
                    }
                    const chev = t.querySelector('.chevron-icon');
                    if (chev) {
                        if (isTheme2) {
                            chev.classList.remove('text-amber-400');
                            chev.classList.add('text-slate-400');
                        } else {
                            chev.classList.remove('text-slate-800');
                            chev.classList.add('text-slate-400');
                        }
                    }
                });
                
                // 2. Set active tab
                this.classList.remove('text-slate-400', 'text-slate-600', 'font-medium');
                if (isTheme2) {
                    this.classList.add('bg-[#0c0c0e]', 'font-bold', 'text-amber-400');
                } else {
                    this.classList.add('bg-white', 'font-bold', 'text-slate-900');
                }
                const activeChev = this.querySelector('.chevron-icon');
                if (activeChev) {
                    if (isTheme2) {
                        activeChev.classList.remove('text-slate-400');
                        activeChev.classList.add('text-amber-400');
                    } else {
                        activeChev.classList.remove('text-slate-400');
                        activeChev.classList.add('text-slate-800');
                    }
                }
                
                // 3. Toggle panels
                const panels = document.querySelectorAll('.category-panel');
                panels.forEach(p => {
                    p.classList.add('hidden');
                    p.classList.remove('block');
                });
                
                const targetPanel = document.getElementById('category-panel-' + categoryId);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('block');
                }
            });
        });

        // --- 1. Mobile Menu Logic ---
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileMenu.classList.toggle('hidden');
            });
            const menuLinks = mobileMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });
        }

        // --- 2. User Dropdown Menu Logic ---
        const userMenuBtn = document.getElementById('user-menu-btn');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        
        if (userMenuBtn && userDropdownMenu) {
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking anywhere else on the page
            document.addEventListener('click', function(e) {
                if (!userMenuBtn.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.add('hidden');
                }
            });
        }



        // --- 4. Search Modal Logic ---
        const searchIcon = document.getElementById('search-icon');
        const searchModal = document.getElementById('search-modal');
        const closeSearchBtn = document.getElementById('close-search');
        const searchContent = document.getElementById('search-content');
        const searchInput = searchModal?.querySelector('input[name="q"]');

        window.openSearch = function(e) {
            if(e) e.preventDefault();
            if(!searchModal || !searchContent) return;
            searchModal.classList.remove('hidden');
            searchModal.classList.add('flex');
            setTimeout(() => {
                searchModal.classList.remove('opacity-0');
                searchContent.classList.remove('-translate-y-4', 'opacity-0');
                if(searchInput) searchInput.focus();
            }, 10);
            if (window.innerWidth >= 768) {
                document.body.classList.add('overflow-hidden');
            }
        };

        window.closeSearch = function() {
            if(!searchModal || !searchContent) return;
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

        // --- 6. Mobile Layout & Currency Selector Offset Logic ---
        function adjustHeaderOffset() {
            const header = document.getElementById('main-header');
            const mainContent = document.querySelector('main');
            const isHome = {{ $isHome ? 'true' : 'false' }};
            if (header && mainContent) {
                if (isHome) {
                    mainContent.style.paddingTop = '0px';
                } else {
                    const height = header.offsetHeight;
                    mainContent.style.paddingTop = height + 'px';
                }
            }
        }

        // Run on load and resize
        adjustHeaderOffset();
        window.addEventListener('resize', adjustHeaderOffset);
        window.adjustHeaderOffset = adjustHeaderOffset;

        // Hide currency selector on scroll (both mobile and desktop)
        const currencyContainer = document.getElementById('currency-selector-container');
        if (currencyContainer) {
            function checkCurrencyVisibility() {
                if (window.scrollY > 20) {
                    currencyContainer.style.opacity = '0';
                    currencyContainer.style.pointerEvents = 'none';
                } else {
                    currencyContainer.style.opacity = '1';
                    currencyContainer.style.pointerEvents = 'auto';
                }
            }
            window.addEventListener('scroll', checkCurrencyVisibility);
            window.addEventListener('resize', checkCurrencyVisibility);
            checkCurrencyVisibility();
        }
    });
</script>