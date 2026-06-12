<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-[#f8f9fc] text-slate-800 antialiased h-screen flex overflow-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Premium Dark Sidebar -->
    <aside class="w-72 bg-[#0b0f19] text-slate-400 flex flex-col h-full hidden md:flex transition-all duration-300 relative overflow-hidden">
        
        <!-- Subtle background glow effect -->
        <div class="absolute top-0 left-0 w-full h-64 bg-indigo-500/10 blur-[80px] pointer-events-none"></div>

        <!-- Logo Area -->
        <div class="h-20 flex items-center px-8 z-10 border-b border-white/5">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl text-white flex items-center justify-center mr-3 shadow-lg shadow-indigo-500/20 text-lg font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-white font-bold text-xl tracking-tight">GetCare</span>
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

    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-8 px-4">Store Management</div>
    
    <a href="{{ route('admin.store-manage') }}" class="flex items-center px-4 py-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.store-manage') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'hover:bg-white/5 hover:text-white text-slate-400' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.store-manage') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..."></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span class="font-medium text-sm">Store Manage</span>
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
        <header class="h-20 bg-white/70 backdrop-blur-lg border-b border-slate-200/60 flex items-center justify-between px-8 z-20 sticky top-0">
            <!-- Breadcrumbs -->
            <div class="flex items-center text-sm font-medium text-slate-500">
                <button class="md:hidden mr-4 text-slate-600 focus:outline-none bg-slate-100 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center px-4 py-2 bg-slate-100/80 rounded-xl">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="mx-2.5 text-slate-300">/</span>
                    <span class="text-indigo-600 font-bold tracking-wide">Dashboard</span>
                </div>
            </div>

            <!-- Elegant Search -->
            <div class="flex-1 max-w-lg px-12 hidden md:block">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 transition-colors group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search for products, orders..." class="w-full bg-slate-100/50 border-transparent rounded-2xl pl-12 pr-4 py-2.5 text-sm font-medium transition-all focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none shadow-sm shadow-slate-200/50 placeholder-slate-400">
                </div>
            </div>

            <!-- Right side (Actions) -->
            <div class="flex items-center space-x-3">
                <!-- Go to Website Button -->
                <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl text-sm font-bold transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Go to Website
                </a>

                <!-- Notifications -->
                <button class="w-10 h-10 flex items-center justify-center bg-slate-100/80 hover:bg-slate-200 text-slate-500 hover:text-indigo-600 rounded-xl transition-colors relative">
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-slate-100"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" title="Logout" class="w-10 h-10 flex items-center justify-center bg-rose-50 hover:bg-rose-100 text-rose-500 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Dynamic Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 z-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
        
    </div>

</body>
</html>