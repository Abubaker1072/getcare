@php
    $cartItemsCount = \App\Models\CartItem::where(auth()->check() ? ['user_id' => auth()->id()] : ['session_id' => session()->getId()])->sum('quantity');
    $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
    $isTheme2 = ($homepageTheme === 'theme_2');
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
</style>

<header id="main-header" class="w-full fixed top-0 left-0 z-50 flex flex-col bg-transparent {{ $isTheme2 ? 'theme-2-header' : '' }}">
    @php
        $countdownActive = \App\Models\StoreSetting::getValue('countdown_is_active', '0') === '1';
        $countdownEndTime = \App\Models\StoreSetting::getValue('countdown_end_time');
        $countdownText = \App\Models\StoreSetting::getValue('countdown_text', 'Up to 20% Off | Code REFRESH20');
    @endphp

    @if($countdownActive && $countdownEndTime)
        <div id="store-countdown-timer" data-target-time="{{ $countdownEndTime }}" class="w-full bg-gradient-to-r {{ $isTheme2 ? 'from-amber-600 to-orange-600 text-slate-950 font-bold' : 'from-[#c45a49] to-[#b04b3a] text-white' }} py-2.5 px-4 flex items-center justify-between text-xs tracking-wider uppercase relative z-[60] shadow-md transition-all duration-300">
            <div class="flex-1 flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-6 text-center">
                <span class="font-extrabold flex items-center gap-1.5">
                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $countdownText }}
                </span>
                <div class="flex items-center gap-3 font-mono font-bold text-[13px] bg-black/10 px-3 py-1 rounded-md">
                    <div class="flex flex-col items-center">
                        <span id="countdown-days">00</span>
                        <span class="text-[8px] opacity-75 font-sans -mt-0.5">DAYS</span>
                    </div>
                    <span>:</span>
                    <div class="flex flex-col items-center">
                        <span id="countdown-hours">00</span>
                        <span class="text-[8px] opacity-75 font-sans -mt-0.5">HRS</span>
                    </div>
                    <span>:</span>
                    <div class="flex flex-col items-center">
                        <span id="countdown-mins">00</span>
                        <span class="text-[8px] opacity-75 font-sans -mt-0.5">MINS</span>
                    </div>
                    <span>:</span>
                    <div class="flex flex-col items-center">
                        <span id="countdown-secs">00</span>
                        <span class="text-[8px] opacity-75 font-sans -mt-0.5">SECS</span>
                    </div>
                </div>
            </div>
            <button onclick="dismissCountdown()" class="text-current opacity-70 hover:opacity-100 transition p-1 hover:rotate-90 duration-200" title="Dismiss">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
    
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
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-xs xl:text-sm font-semibold tracking-wide uppercase">
                    <a href="{{ route('home') ?? '#' }}" class="dynamic-color text-white nav-link">Home</a>
                    <a href="{{ route('products.all') ?? '#' }}" class="dynamic-color text-white nav-link">Products</a>
                    <a href="{{ route('hot-deals') ?? '#' }}" class="dynamic-color text-white nav-link">Hot Deals</a>
                    
                    {{-- Categories Dropdown --}}
                    @php
                        $headerCategories = \App\Models\Category::where('status', true)->take(10)->get();
                    @endphp
                    <div class="group/cat relative py-4">
                        <a href="{{ route('categories') ?? '#' }}" class="dynamic-color text-white nav-link">
                            Categories
                        </a>
                        
                        {{-- Dropdown Menu --}}
                        <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 opacity-0 invisible group-hover/cat:opacity-100 group-hover/cat:visible transition-all duration-300 z-50 transform translate-y-2 group-hover/cat:translate-y-0 w-[600px]">
                            <div class="bg-white/80 backdrop-blur-2xl border border-white/40 shadow-[0_20px_40px_rgba(0,0,0,0.1)] rounded-3xl p-8">
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200/50">
                                    <h3 class="text-slate-800 font-bold text-sm tracking-widest uppercase">Explore Collections</h3>
                                    <a href="{{ route('categories') }}" class="text-amber-600 hover:text-amber-700 text-xs font-bold tracking-wider uppercase flex items-center gap-1 group/link">
                                        View All
                                        <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                                <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                                    @foreach($headerCategories as $cat)
                                        <a href="{{ route('category.detail', $cat->slug) }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/60 transition-colors group/item">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 group-hover/item:bg-amber-100 group-hover/item:text-amber-600 text-slate-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-slate-800 font-bold text-xs tracking-wider uppercase group-hover/item:text-amber-600 transition-colors">{{ $cat->name }}</div>
                                            </div>
                                        </a>
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
<div id="search-modal" class="fixed inset-0 {{ $isTheme2 ? 'bg-[#0c0c0e]/95 backdrop-blur-md text-[#f3e8ff]' : 'bg-white/95 backdrop-blur-sm' }} z-[80] hidden opacity-0 transition-opacity duration-300 flex-col">
    <div class="max-w-4xl mx-auto w-full px-4 pt-16 sm:pt-24 relative flex-1">
        <button id="close-search" class="absolute top-4 right-4 sm:top-8 sm:right-8 {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-gray-500 hover:text-red-500' }} transition transform hover:rotate-90 duration-300">
            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="text-center mb-8 transform -translate-y-4 opacity-0 transition-all duration-500" id="search-content">
            <h2 class="text-3xl sm:text-5xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-800' }} mb-6 font-serif">What are you looking for?</h2>
            <form action="{{ route('products.all') }}" method="GET" class="relative max-w-2xl mx-auto">
                <input type="text" name="q" placeholder="Search products, brands, categories..." class="w-full text-lg sm:text-2xl px-0 py-4 {{ $isTheme2 ? 'border-b-2 border-slate-800 focus:border-amber-400 text-white placeholder:text-slate-600' : 'border-b-2 border-gray-300 focus:border-amber-500 text-gray-800 placeholder:text-gray-400' }} bg-transparent outline-none transition-colors" autofocus>
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 {{ $isTheme2 ? 'text-slate-500 hover:text-amber-400' : 'text-gray-400 hover:text-amber-500' }} transition transform hover:scale-110">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
            
            <div class="mt-10 flex flex-wrap justify-center gap-2 sm:gap-4 text-sm">
                <span class="text-gray-500">Popular:</span>
                <a href="#" class="text-amber-500 hover:underline">Skincare</a>
                <a href="#" class="text-amber-500 hover:underline">Gifts</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 0. Scroll Animation Logic ---
        const mainHeader = document.getElementById('main-header');
        const currencyContainer = document.getElementById('currency-selector-container');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                mainHeader.classList.add('is-scrolled');
                if (currencyContainer && window.innerWidth < 768) {
                    currencyContainer.style.opacity = '0';
                    currencyContainer.style.pointerEvents = 'none';
                }
            } else {
                mainHeader.classList.remove('is-scrolled');
                if (currencyContainer) {
                    currencyContainer.style.opacity = '1';
                    currencyContainer.style.pointerEvents = 'auto';
                }
            }
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
            document.body.classList.add('overflow-hidden');
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

        // --- 5. Countdown Banner Logic ---
        const countdownEl = document.getElementById('store-countdown-timer');
        if (countdownEl) {
            const targetDateStr = countdownEl.getAttribute('data-target-time');
            const dismissedDate = localStorage.getItem('countdown_dismissed_date');
            
            if (dismissedDate === targetDateStr) {
                countdownEl.style.display = 'none';
            } else if (targetDateStr) {
                const targetDate = new Date(targetDateStr).getTime();
                if (!isNaN(targetDate)) {
                    const daysVal = document.getElementById('countdown-days');
                    const hoursVal = document.getElementById('countdown-hours');
                    const minsVal = document.getElementById('countdown-mins');
                    const secsVal = document.getElementById('countdown-secs');

                    function updateTimer() {
                        const now = new Date().getTime();
                        const difference = targetDate - now;

                        if (difference <= 0) {
                            countdownEl.style.display = 'none';
                            return;
                        }

                        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                        if (daysVal) daysVal.innerText = String(days).padStart(2, '0');
                        if (hoursVal) hoursVal.innerText = String(hours).padStart(2, '0');
                        if (minsVal) minsVal.innerText = String(minutes).padStart(2, '0');
                        if (secsVal) secsVal.innerText = String(seconds).padStart(2, '0');
                    }

                    updateTimer();
                    setInterval(updateTimer, 1000);
                }
            }
        }

        window.dismissCountdown = function() {
            const el = document.getElementById('store-countdown-timer');
            if (el) {
                el.style.display = 'none';
                const targetDateStr = el.getAttribute('data-target-time');
                if (targetDateStr) {
                    localStorage.setItem('countdown_dismissed_date', targetDateStr);
                }
            }
        };
    });
</script>