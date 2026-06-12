@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Orders</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Track fulfillments, manage payments, and review incoming sales.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Date Range
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <!-- Table Search & Filters -->
        <div class="p-5 border-b border-slate-50 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-80">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search order ID, customer..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-sm">
            </div>
            <div class="flex space-x-2">
                <select class="bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 outline-none shadow-sm">
                    <option>All Statuses</option>
                    <option>Unfulfilled</option>
                    <option>Paid</option>
                </select>
            </div>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Order Details</th>
                        <th class="p-5 font-bold">Date</th>
                        <th class="p-5 font-bold">Payment</th>
                        <th class="p-5 font-bold">Fulfillment</th>
                        <th class="p-5 font-bold">Total</th>
                        <th class="p-5 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    
                    <!-- Row 1 (Paid & Shipped) -->
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <p class="font-extrabold text-indigo-600 text-base cursor-pointer hover:underline">#ORD-8042</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Jane Doe</p>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-700 font-bold">Today, 10:45 AM</p>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Paid
                            </span>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-sky-50 text-sky-600 border border-sky-100">
                                Shipped
                            </span>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-900 font-extrabold text-base">$140.30</p>
                        </td>
                        <td class="p-5 text-right">
                            <button class="text-slate-400 hover:text-indigo-600 font-bold text-xs uppercase tracking-wide px-3 py-1.5 hover:bg-indigo-50 rounded-lg transition-colors">View</button>
                        </td>
                    </tr>

                    <!-- Row 2 (Pending & Unfulfilled) -->
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <p class="font-extrabold text-indigo-600 text-base cursor-pointer hover:underline">#ORD-8043</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Michael Smith</p>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-700 font-bold">Yesterday, 4:20 PM</p>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Pending
                            </span>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Unfulfilled
                            </span>
                        </td>
                        <td class="p-5">
                            <p class="text-slate-900 font-extrabold text-base">$85.00</p>
                        </td>
                        <td class="p-5 text-right">
                            <button class="text-slate-400 hover:text-indigo-600 font-bold text-xs uppercase tracking-wide px-3 py-1.5 hover:bg-indigo-50 rounded-lg transition-colors">View</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection