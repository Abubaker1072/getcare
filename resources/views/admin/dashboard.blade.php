@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Welcome back, <span class="text-slate-700 font-semibold">Admin</span> — here's your store's performance today.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <div class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm font-bold shadow-sm">
                <span class="relative flex h-2.5 w-2.5 mr-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                Live Server
            </div>
            <button class="flex items-center px-5 py-2 bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-slate-900/20 hover:-translate-y-0.5 transition-all duration-200">
                <span>View Orders</span>
                <svg class="w-4 h-4 ml-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(6,81,237,0.1)] transition-all duration-300 relative overflow-hidden group">
            <svg class="absolute -top-4 -right-4 w-28 h-28 text-indigo-500 opacity-5 group-hover:scale-110 transition-transform duration-500 pointer-events-none transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner shadow-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-100">+5.2%</span>
            </div>
            <div class="relative z-10">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Total Revenue</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">$12,243.00</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(6,81,237,0.1)] transition-all duration-300 relative overflow-hidden group">
            <svg class="absolute -top-4 -right-4 w-28 h-28 text-emerald-500 opacity-5 group-hover:scale-110 transition-transform duration-500 pointer-events-none transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner shadow-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-100">+12%</span>
            </div>
            <div class="relative z-10">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Total Orders</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">1,407</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(6,81,237,0.1)] transition-all duration-300 relative overflow-hidden group">
            <svg class="absolute -top-4 -right-4 w-28 h-28 text-sky-500 opacity-5 group-hover:scale-110 transition-transform duration-500 pointer-events-none transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>

            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center shadow-inner shadow-sky-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-100">+8.4%</span>
            </div>
            <div class="relative z-10">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Site Visitors</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">24,709</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(6,81,237,0.1)] transition-all duration-300 relative overflow-hidden group">
            <svg class="absolute -top-4 -right-4 w-28 h-28 text-amber-500 opacity-5 group-hover:scale-110 transition-transform duration-500 pointer-events-none transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>

            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner shadow-amber-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-rose-500 bg-rose-50 px-2.5 py-1 rounded-full text-xs font-bold border border-rose-100">-2.1%</span>
            </div>
            <div class="relative z-10">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Products</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">5,406</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] lg:col-span-2 flex flex-col overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Revenue Analytics</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1">Current fiscal year performance</p>
                </div>
                <select class="text-sm font-semibold border-slate-200 rounded-xl text-slate-600 bg-white py-2 pl-4 pr-8 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none shadow-sm shadow-slate-100">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div class="p-6 flex-1 w-full relative min-h-[320px] bg-gradient-to-b from-white to-slate-50/50">
                <div class="absolute inset-6 rounded-2xl border-2 border-dashed border-slate-200 bg-white/50 flex flex-col items-center justify-center text-slate-400">
                    <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3v18h18M9 15l3-3 4 4 5-5"></path></svg>
                    <span class="font-medium text-sm text-slate-400">Chart.js / ApexCharts Canvas Here</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] flex flex-col">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-lg font-extrabold text-slate-900">Customer Retention</h3>
            </div>
            <div class="p-6 flex-1 flex flex-col items-center justify-center">
                
                <div class="relative w-48 h-48 mb-8 drop-shadow-xl">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-orange-500" stroke-width="4" stroke-dasharray="70, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Retention</span>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">70%</span>
                    </div>
                </div>
                
                <div class="w-full flex justify-between bg-slate-50 rounded-2xl p-4 border border-slate-100">
                    <div class="text-center w-1/2 border-r border-slate-200/60">
                        <span class="block text-xl font-extrabold text-slate-900">2,104</span>
                        <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">New</span>
                    </div>
                    <div class="text-center w-1/2">
                        <span class="block text-xl font-extrabold text-slate-900">7,021</span>
                        <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-sm font-extrabold text-slate-900 flex items-center">
                    <span class="bg-orange-100 text-orange-600 w-7 h-7 rounded-full flex items-center justify-center mr-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                    </span> 
                    Top Selling
                </h3>
                <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-bold hover:underline underline-offset-2">View all</a>
            </div>
            <div class="p-3">
                <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-2xl transition-colors cursor-pointer group">
                    <div class="flex items-center">
                        <span class="text-slate-300 text-sm font-bold w-4">1</span>
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mx-3 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Premium T-Shirt</p>
                            <p class="text-xs text-slate-500 font-medium">842 units sold</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">↑ 25%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-sm font-extrabold text-slate-900 flex items-center">
                    <span class="bg-rose-100 text-rose-600 w-7 h-7 rounded-full flex items-center justify-center mr-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </span> 
                    Low Stock
                </h3>
                <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-bold hover:underline underline-offset-2">View all</a>
            </div>
            <div class="p-3">
                <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-2xl transition-colors cursor-pointer group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mr-3 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-rose-600 transition-colors">Augusta Sportswear</p>
                            <p class="text-xs text-slate-500 font-medium">Bottoms • SKU-6869</p>
                        </div>
                    </div>
                    <div class="text-right bg-rose-50 px-3 py-1.5 rounded-xl border border-rose-100">
                        <span class="block text-sm font-extrabold text-rose-600 leading-none">0</span>
                        <span class="block text-[9px] text-rose-400 font-bold uppercase mt-0.5">Left</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-sm font-extrabold text-slate-900 flex items-center">
                    <span class="bg-sky-100 text-sky-600 w-7 h-7 rounded-full flex items-center justify-center mr-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span> 
                    Recent Orders
                </h3>
                <a href="#" class="text-xs text-indigo-600 hover:text-indigo-700 font-bold hover:underline underline-offset-2">View all</a>
            </div>
            <div class="p-3">
                <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-2xl transition-colors cursor-pointer group">
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-xl object-cover shadow-sm mr-3" src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Avatar">
                        <div>
                            <p class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Admin User</p>
                            <p class="text-xs text-slate-500 font-medium">Order #804 • $140.30</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-lg uppercase tracking-wide">Pending</span>
                </div>
            </div>
        </div>
        
    </div>
@endsection