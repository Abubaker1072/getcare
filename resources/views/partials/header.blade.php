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
                <a href="{{ route('products.index') ?? '#' }}" class="text-lg md:text-2xl font-bold tracking-widest text-gray-900">
                    GetCare<br><span class="text-xs font-light">BEAUTY</span>
                </a>
            </div>

            {{-- Main Navigation Menu --}}
            <nav class="hidden lg:flex items-center gap-4 xl:gap-8 text-xs xl:text-sm font-medium">
                <a href="{{ route('products.index') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
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
                    BRANDS
                </a>
                <a href="#" class="text-gray-700 hover:text-amber-600 transition">
                    SHOP
                </a>
                <a href="{{ route('blog') ?? '#' }}" class="text-gray-700 hover:text-amber-600 transition">
                    contact us 
                </a>
            </nav>

            {{-- Right Icons: Currency + Account + Search + Cart --}}
            <div class="flex items-center gap-3 md:gap-6">
                {{-- Currency Selector --}}
                <div class="hidden md:flex items-center gap-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/197/197593.png" alt="PK" class="w-4 md:w-5 h-4 md:h-5 rounded-full">
                    <select class="bg-transparent border-none outline-none text-xs font-semibold cursor-pointer hover:text-amber-600 focus:ring-0">
                        <option value="PK">PKR ₨</option>
                        <option value="US">USD $</option>
                        <option value="AU">AUD $</option>
                        <option value="GB">GBP £</option>
                        <option value="EU">EUR €</option>
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
                <a href="#" class="text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </a>

                {{-- Shopping Cart Icon --}}
                <a href="#" class="relative text-gray-700 hover:text-amber-600 transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Promo Code + Countdown Banner --}}
    <div class="w-full bg-red-900 text-white py-2 md:py-3">
        <div class="max-w-7xl mx-auto px-3 md:px-4 flex flex-col md:flex-row items-center justify-center gap-3 md:gap-8 text-xs md:text-sm">
            <span class="font-semibold underline text-xs md:text-sm">Up to 20% Off | Code REFRESH20</span>
            <div class="flex items-center gap-4 md:gap-8 font-mono text-base md:text-lg font-bold">
                <div class="text-center">
                    <div class="text-lg md:text-2xl">19</div>
                    <div class="text-xs uppercase">Hrs</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div class="text-lg md:text-2xl">30</div>
                    <div class="text-xs uppercase">Min</div>
                </div>
                <span>:</span>
                <div class="text-center">
                    <div class="text-lg md:text-2xl">16</div>
                    <div class="text-xs uppercase">Sec</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Navigation (Hidden by default, toggled with hamburger) --}}
    <div id="mobile-menu" class="lg:hidden hidden w-full bg-white border-t max-h-96 overflow-y-auto">
        <ul class="main-nav nav navbar-nav flex flex-col">
            <li class="border-b"><a href="{{ route('products.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Home</a></li>
            <li class="border-b"><a href="{{ route('hot-deals') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Hot Deals</a></li>
            <li class="border-b"><a href="{{ route('categories') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Categories</a></li>
            <li class="border-b"><a href="{{ route('brands') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">All Brands</a></li>
            <li class="border-b"><a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Flash sale</a></li>
            <li class="border-b"><a href="{{ route('blog') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Blogs</a></li>
            <li class="border-b"><a href="{{ route('featured') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">Featured Products</a></li>
            <li class="border-b"><a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition touch-none active:bg-amber-100">How we Work</a></li>
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