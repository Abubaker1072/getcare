<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#090d16',
                        darkCard: '#111827',
                        darkBorder: '#1f2937'
                    }
                }
            }
        }
        
        // Immediate execution to prevent flash of light theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Elegant minimalist scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-[#f8f9fc] text-slate-800 dark:bg-slate-950 dark:text-slate-100 antialiased h-screen flex overflow-hidden selection:bg-indigo-500 selection:text-white transition-colors duration-300">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="admin-sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Premium Dark Sidebar -->
    <aside id="admin-sidebar" class="w-72 bg-[#0b0f19] text-slate-400 flex flex-col h-full fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 md:relative md:flex transition-transform duration-300 ease-in-out overflow-hidden">
        
        <!-- Subtle background glow effect -->
        <div class="absolute top-0 left-0 w-full h-64 bg-indigo-500/10 blur-[80px] pointer-events-none"></div>

        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-between px-8 z-10 border-b border-white/5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl text-white flex items-center justify-center mr-3 shadow-lg shadow-indigo-500/20 text-lg font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-white font-bold text-xl tracking-tight">GetCare</span>
            </div>
            <!-- Mobile Sidebar Close Button -->
            <button onclick="toggleAdminSidebar()" class="md:hidden text-slate-400 hover:text-white focus:outline-none p-1.5 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
     <!-- Navigation Links -->
<nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 space-y-1 z-10">
    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-4 px-4">Main</div>
    
    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        <span class="font-medium text-sm">Dashboard</span>
    </a>
    
    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.categories') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
        <span class="font-medium text-sm">Categories</span>
    </a>
    
    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products.*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        <span class="font-medium text-sm">Products</span>
    </a>
    
    <a href="{{ route('admin.hot-deals') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.hot-deals*') || request()->routeIs('admin.hot-deal-management*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.hot-deals*') || request()->routeIs('admin.hot-deal-management*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
        <span class="font-medium text-sm">Hot Deals</span>
    </a>

    <a href="{{ route('admin.reels.index') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.reels.*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reels.*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        <span class="font-medium text-sm">Manage Reels</span>
    </a>

    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-4">Store Management</div>
    
    <a href="{{ route('admin.store-manage') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.store-manage') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.store-manage') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..."></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span class="font-medium text-sm">Store Manage</span>
    </a>

    <a href="{{ route('admin.payment-gateways') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.payment-gateways') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payment-gateways') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        <span class="font-medium text-sm">Payment Gateways</span>
    </a>
    
    <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.orders') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.orders') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293..."></path></svg>
        <span class="font-medium text-sm">Orders</span>
    </a>

    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-4">CRM & System</div>
    
    <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.customers') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.customers') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="font-medium text-sm">Customers</span>
    </a>

    <a href="{{ route('admin.messages') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.messages') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.messages') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <span class="font-medium text-sm">Customer Messages</span>
    </a>

    <a href="{{ route('admin.reviews') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.reviews') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reviews') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        <span class="font-medium text-sm">Testimonials</span>
    </a>
    
    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
        <span class="font-medium text-sm">Settings</span>
    </a>
</nav>

        <!-- User Profile Card -->
        <div class="p-5 z-10">
            <div class="flex items-center p-3 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm cursor-pointer hover:bg-white/10 transition-colors">
                <img class="h-10 w-10 rounded-xl object-cover" src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" alt="Admin Avatar">
                <div class="ml-3 flex-1">
                    <p class="text-sm font-bold text-white tracking-tight">Admin User</p>
                    <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Administrator</p>
                </div>
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Glassmorphism Top Navbar -->
        <header class="h-20 bg-white/70 dark:bg-slate-900/80 backdrop-blur-lg border-b border-slate-200/60 dark:border-slate-800/80 flex items-center justify-between px-4 md:px-8 z-20 sticky top-0 transition-colors duration-300">
            <!-- Breadcrumbs -->
            <div class="flex items-center text-sm font-medium text-slate-500">
                <button onclick="toggleAdminSidebar()" class="md:hidden mr-3 text-slate-600 dark:text-slate-400 focus:outline-none bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center px-4 py-2 bg-slate-100/80 dark:bg-slate-800/80 rounded-xl">
                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="mx-2.5 text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-indigo-600 dark:text-indigo-400 font-bold tracking-wide">Dashboard</span>
                </div>
            </div>

            <!-- Elegant Search -->
            @php
                $searchAction = route('admin.products.index');
                $searchPlaceholder = 'Search products...';
                if (request()->is('admin/orders*')) {
                    $searchAction = route('admin.orders');
                    $searchPlaceholder = 'Search orders...';
                } elseif (request()->is('admin/customers*')) {
                    $searchAction = route('admin.customers');
                    $searchPlaceholder = 'Search customers by name/email...';
                }
            @endphp
            <form action="{{ $searchAction }}" method="GET" class="flex-1 max-w-lg px-12 hidden md:block m-0">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 transition-colors group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="w-full bg-slate-100/50 dark:bg-slate-800 border-transparent rounded-2xl pl-12 pr-4 py-2.5 text-sm font-medium transition-all focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-500 outline-none shadow-sm dark:shadow-none placeholder-slate-400 dark:placeholder-slate-500 dark:text-slate-200">
                </div>
            </form>

            <!-- Right side (Actions) -->
            <div class="flex items-center space-x-3">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="w-10 h-10 flex items-center justify-center bg-slate-100/80 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-xl transition-colors">
                    <svg id="theme-sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                    <svg id="theme-moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <!-- Currency Switcher -->
                @php
                    $activeCurrencies = \App\Models\Currency::where('is_active', true)->get();
                    $currentCurrency = \App\Helpers\CurrencyHelper::getCurrent();
                @endphp
                <div class="flex items-center gap-1 bg-slate-100 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 px-2 sm:px-3 py-1.5 rounded-xl mr-1 sm:mr-2">
                    <span class="text-sm leading-none mr-0.5" id="admin-currency-active-flag">{{ \App\Helpers\CurrencyHelper::getFlag($currentCurrency->code) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider hidden sm:inline">Currency</span>
                    <select onchange="window.location.href='/currency/switch/' + this.value" class="bg-transparent border-none outline-none text-xs font-bold text-slate-700 dark:text-slate-300 cursor-pointer focus:ring-0 py-0 pl-1 pr-6 focus:outline-none">
                        @foreach($activeCurrencies as $curr)
                            <option value="{{ $curr->code }}" {{ $currentCurrency->code === $curr->code ? 'selected' : '' }} class="dark:bg-slate-900 dark:text-slate-100">
                                {{ \App\Helpers\CurrencyHelper::getFlag($curr->code) }} {{ $curr->code }} ({{ $curr->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Go to Website Button -->
                <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-950/60 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Go to Website
                </a>

                <!-- Notifications -->
                @php
                    $pendingMessages = \App\Models\CustomerMessage::where('is_read', false)->latest()->take(5)->get();
                    $pendingReviews = \App\Models\Review::where('is_approved', false)->latest()->take(5)->get();
                    $pendingOrders = \App\Models\Order::where('status', 'pending')->latest()->take(5)->get();
                    $totalNotifications = $pendingMessages->count() + $pendingReviews->count() + $pendingOrders->count();
                @endphp
                <div class="relative" id="notifications-dropdown-container">
                    <button onclick="toggleNotifications()" class="w-10 h-10 flex items-center justify-center bg-slate-100/80 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 hover:text-indigo-655 dark:text-slate-400 rounded-xl transition-colors relative">
                        @if($totalNotifications > 0)
                            <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                        @endif
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <!-- Floating Dropdown list -->
                    <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-800 rounded-2xl shadow-2xl z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
                            <span class="font-extrabold text-sm text-slate-950 dark:text-white">Notifications</span>
                            <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-bold">{{ $totalNotifications }} Pending</span>
                        </div>
                        
                        <div class="max-h-72 overflow-y-auto divide-y divide-slate-50 dark:divide-slate-800/60">
                            @if($pendingOrders->isNotEmpty())
                                @foreach($pendingOrders as $order)
                                    <a href="{{ route('admin.orders') }}" class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                        <div class="flex gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-500 flex items-center justify-center text-sm font-bold flex-shrink-0">📦</span>
                                            <div>
                                                <p class="text-xs font-bold text-slate-900 dark:text-white">New Order #{{ $order->order_number }}</p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Awaiting approval • {{ $order->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            @if($pendingMessages->isNotEmpty())
                                @foreach($pendingMessages as $msg)
                                    <a href="{{ route('admin.messages') }}" class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                        <div class="flex gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 text-indigo-500 flex items-center justify-center text-sm font-bold flex-shrink-0">✉️</span>
                                            <div>
                                                <p class="text-xs font-bold text-slate-900 dark:text-white">Message from {{ $msg->first_name }}</p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Unread inquiry • {{ $msg->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            @if($pendingReviews->isNotEmpty())
                                @foreach($pendingReviews as $rev)
                                    <a href="{{ route('admin.reviews') }}" class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                        <div class="flex gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center text-sm font-bold flex-shrink-0">★</span>
                                            <div>
                                                <p class="text-xs font-bold text-slate-900 dark:text-white">Review pending approval</p>
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">By {{ $rev->name }} • {{ $rev->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            @if($totalNotifications === 0)
                                <div class="p-6 text-center text-slate-400 dark:text-slate-500 text-xs italic">
                                    No pending notifications.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" title="Logout" class="w-10 h-10 flex items-center justify-center bg-rose-50 dark:bg-rose-950/20 hover:bg-rose-100 dark:hover:bg-rose-950/40 text-rose-500 dark:text-rose-455 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        <script>
            function toggleNotifications() {
                const dropdown = document.getElementById('notifications-dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            }

            // Close notifications dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('notifications-dropdown');
                const container = document.getElementById('notifications-dropdown-container');
                if (dropdown && container && !container.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            function toggleTheme() {
                const isDark = document.documentElement.classList.contains('dark');
                if (isDark) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    document.getElementById('theme-sun-icon')?.classList.add('hidden');
                    document.getElementById('theme-moon-icon')?.classList.remove('hidden');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    document.getElementById('theme-sun-icon')?.classList.remove('hidden');
                    document.getElementById('theme-moon-icon')?.classList.add('hidden');
                }
                window.dispatchEvent(new Event('theme-changed'));
            }

            // Initialize toggle icon states
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                if (isDark) {
                    document.getElementById('theme-sun-icon')?.classList.remove('hidden');
                    document.getElementById('theme-moon-icon')?.classList.add('hidden');
                } else {
                    document.getElementById('theme-sun-icon')?.classList.add('hidden');
                    document.getElementById('theme-moon-icon')?.classList.remove('hidden');
                }
            });

            // Toggle admin responsive sidebar
            function toggleAdminSidebar() {
                const sidebar = document.getElementById('admin-sidebar');
                const backdrop = document.getElementById('admin-sidebar-backdrop');
                if (!sidebar || !backdrop) return;
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    backdrop.classList.remove('hidden');
                    setTimeout(() => {
                        backdrop.classList.remove('opacity-0');
                        backdrop.classList.add('opacity-100');
                    }, 50);
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                    setTimeout(() => {
                        backdrop.classList.add('hidden');
                    }, 300);
                }
            }
        </script>

        <!-- Dynamic Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 z-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
        
    </div>

    {{-- Premium Toasts --}}
    @include('partials.toasts')

</body>
</html>