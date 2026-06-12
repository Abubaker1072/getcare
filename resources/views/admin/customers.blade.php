@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Customers</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manage your clientele, view purchase history, and track lifetime value.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Export CSV
            </button>
            <button class="flex items-center px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Customer
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <!-- Table Search -->
        <div class="p-5 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <div class="relative w-72">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search by name or email..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-sm">
            </div>
            <div class="text-sm text-slate-500 font-medium">Total Customers: <span class="text-slate-900 font-bold">2,104</span></div>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Customer Profile</th>
                        <th class="p-5 font-bold text-center">Orders</th>
                        <th class="p-5 font-bold">Total Spent</th>
                        <th class="p-5 font-bold">Last Active</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5 flex items-center">
                            <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm mr-4" src="https://ui-avatars.com/api/?name=Eleanor+Pena&background=e0e7ff&color=4f46e5" alt="Avatar">
                            <div>
                                <p class="font-extrabold text-slate-900 text-base">Eleanor Pena</p>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">eleanor.pena@example.com</p>
                            </div>
                        </td>
                        <td class="p-5 text-center">
                            <span class="font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-lg">14</span>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-900 font-extrabold text-base">$1,240.50</p>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-700 font-bold">Oct 24, 2023</p>
                            <p class="text-xs text-slate-400 font-medium">3 days ago</p>
                        </td>
                        <td class="p-5 text-right">
                            <button class="text-slate-400 hover:text-indigo-600 transition-colors p-2 hover:bg-indigo-50 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                            <button class="text-slate-400 hover:text-rose-600 transition-colors p-2 hover:bg-rose-50 rounded-lg ml-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection