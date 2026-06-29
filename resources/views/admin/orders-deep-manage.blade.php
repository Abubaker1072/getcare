@extends('layouts.admin')

@section('content')
    <!-- Header with Back Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('admin.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Standard Orders
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Order Deep Management</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Granular filters, month-by-month reports, and premium formatted exports.</p>
        </div>
    </div>

    <!-- Month Filter & Exports Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Filter Controls Card -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-850 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.orders.deep-manage') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-3">
                <input type="hidden" name="status" value="{{ $status }}">
                
                <!-- Search -->
                <div class="relative w-full sm:flex-1">
                    <svg class="absolute left-3.5 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search orders..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>

                <!-- Month Dropdown -->
                <div class="relative w-full sm:w-56">
                    <select name="month" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20">
                        <option value="all" {{ $month === 'all' ? 'selected' : '' }}>All Months (All Time)</option>
                        @foreach($availableMonths as $mOption)
                            <option value="{{ $mOption->month_val }}" {{ $month === $mOption->month_val ? 'selected' : '' }}>
                                {{ $mOption->month_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                @if($search)
                    <a href="{{ route('admin.orders.deep-manage', ['status' => $status, 'month' => $month]) }}" class="text-xs font-bold text-rose-500 hover:underline">Clear Search</a>
                @endif
            </form>
        </div>

        <!-- Exports Operations Card -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-850 shadow-sm flex flex-col justify-center">
            <h4 class="text-xs font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">Download Reports</h4>
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('admin.orders.export', ['status' => $status, 'month' => $month, 'format' => 'excel']) }}" class="flex flex-col items-center justify-center p-2.5 bg-emerald-50 dark:bg-emerald-950/20 hover:bg-emerald-100 dark:hover:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-2xl border border-emerald-100 dark:border-emerald-900/35 transition-all text-center">
                    <span class="text-lg mb-1">📊</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider">Excel / CSV</span>
                </a>
                <a href="{{ route('admin.orders.export', ['status' => $status, 'month' => $month, 'format' => 'word']) }}" class="flex flex-col items-center justify-center p-2.5 bg-blue-50 dark:bg-blue-950/20 hover:bg-blue-100 dark:hover:bg-blue-950/40 text-blue-700 dark:text-blue-400 rounded-2xl border border-blue-100 dark:border-blue-900/35 transition-all text-center">
                    <span class="text-lg mb-1">📝</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider">Word DOC</span>
                </a>
                <a href="{{ route('admin.orders.export', ['status' => $status, 'month' => $month, 'format' => 'pdf']) }}" target="_blank" class="flex flex-col items-center justify-center p-2.5 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 dark:hover:bg-red-950/40 text-red-700 dark:text-red-400 rounded-2xl border border-red-100 dark:border-red-900/35 transition-all text-center">
                    <span class="text-lg mb-1">📄</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider">PDF Format</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Month Summary Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-4 rounded-2xl shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Orders</span>
            <h3 class="text-xl font-black text-slate-850 dark:text-white mt-1">{{ $monthOrdersCount }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-4 rounded-2xl shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-emerald-500">Revenue (Paid)</span>
            <h3 class="text-xl font-black text-emerald-600 dark:text-emerald-450 mt-1">
                {{ \App\Helpers\CurrencyHelper::format($monthRevenue) }}
            </h3>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-4 rounded-2xl shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-amber-500">Pending</span>
            <h3 class="text-xl font-black text-amber-600 mt-1">{{ $monthPendingCount }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-4 rounded-2xl shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-green-500">Completed</span>
            <h3 class="text-xl font-black text-green-600 mt-1">{{ $monthCompletedCount }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-4 rounded-2xl shadow-sm col-span-2 lg:col-span-1">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-rose-500">Cancelled</span>
            <h3 class="text-xl font-black text-rose-600 mt-1">{{ $monthCancelledCount }}</h3>
        </div>
    </div>

    <!-- Status Navigation Tabs -->
    <div class="flex border-b border-slate-200 dark:border-slate-800 mb-6 overflow-x-auto scrollbar-none gap-2">
        @php
            $tabs = [
                'all' => 'All Orders',
                'pending' => 'Pending',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ];
        @endphp
        @foreach($tabs as $tabKey => $tabLabel)
            <a href="{{ route('admin.orders.deep-manage', ['status' => $tabKey, 'month' => $month, 'search' => $search]) }}" 
               class="px-5 py-3 border-b-2 font-bold text-xs uppercase tracking-wider whitespace-nowrap transition-all duration-300
               {{ $status === $tabKey 
                   ? 'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400 bg-indigo-50/10' 
                   : 'border-transparent text-slate-400 hover:text-slate-700 dark:hover:text-white' }}">
                {{ $tabLabel }}
            </a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-450 border border-emerald-100 dark:border-emerald-900/40 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Panel -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <!-- DESKTOP TABLE VIEW (SYSTEM VIEW) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
                        <th class="p-5 font-bold">Order Details</th>
                        <th class="p-5 font-bold">Date</th>
                        <th class="p-5 font-bold">Payment Status</th>
                        <th class="p-5 font-bold">Order Status</th>
                        <th class="p-5 font-bold">Total</th>
                        <th class="p-5 font-bold">Shipping Info</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-800/60">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group">
                            <td class="p-5">
                                <p class="font-extrabold text-indigo-600 dark:text-indigo-400 text-base">#{{ $order->order_number }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $order->user->name ?? 'Guest/Deleted' }} ({{ $order->user->email ?? '' }})</p>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    @foreach($order->items as $item)
                                        @if($item->product)
                                            <div class="relative flex-shrink-0 group/img">
                                                <img src="{{ asset('storage/' . ($item->product->cover_image ?? $item->product->image)) }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-sm" title="{{ $item->product->name }} (x{{ $item->quantity }})">
                                                <span class="absolute -top-1.5 -right-1.5 bg-slate-800 dark:bg-slate-700 text-white text-[9px] font-extrabold rounded-full w-5 h-5 flex items-center justify-center border border-white dark:border-slate-800">{{ $item->quantity }}</span>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-slate-700 text-[10px] text-slate-400 dark:text-slate-500 font-bold" title="Deleted Product">
                                                DEL
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-700 dark:text-slate-300 font-bold">{{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="p-5">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="payment_status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 px-2.5 py-1 outline-none cursor-pointer
                                        {{ $order->payment_status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-450 border-emerald-100 dark:border-emerald-900/40' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-450 border-amber-100 dark:border-amber-900/40' }}">
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-5">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex flex-col gap-1.5">
                                    @csrf
                                    <div class="flex gap-1.5">
                                        <select name="status" class="flex-1 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 px-2.5 py-1 outline-none cursor-pointer
                                            @if($order->status === 'completed') bg-green-50 dark:bg-green-950/40 text-green-700 dark:text-green-400 border-green-100 dark:border-green-900/40
                                            @elseif($order->status === 'cancelled') bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border-red-100 dark:border-red-900/40
                                            @elseif($order->status === 'shipped') bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 border-blue-100 dark:border-blue-900/40
                                            @else bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border-amber-100 dark:border-amber-900/40
                                            @endif">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white dark:bg-slate-700 dark:hover:bg-slate-600 px-2 py-1 rounded-lg text-xs font-bold shadow-sm transition-colors">Save</button>
                                    </div>
                                    <input type="text" name="tracking_note" placeholder="Add tracking note/update..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all placeholder-slate-400">
                                </form>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-900 dark:text-white font-extrabold text-base">{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</p>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-700 dark:text-slate-300 font-medium">{{ $order->shipping_name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $order->shipping_phone }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 line-clamp-2 max-w-[200px]" title="{{ $order->shipping_address }}">{{ $order->shipping_address }}</p>
                            </td>
                            <td class="p-5 text-right whitespace-nowrap">
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider mb-2">
                                    {{ $order->payment_method ?? 'COD' }}
                                </div>
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="openOrderModal('{{ $order->id }}')" class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-850 hover:bg-slate-200 dark:hover:bg-slate-750 px-2.5 py-1.5 rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View
                                    </button>
                                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 dark:hover:bg-indigo-950/60 px-2.5 py-1.5 rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Invoice
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                No orders found matching parameters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARD VIEW -->
        <div class="block md:hidden p-4 space-y-4">
            @forelse($orders as $order)
                <div class="bg-slate-50 dark:bg-slate-850 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col gap-4 shadow-sm">
                    
                    <!-- Card Top Header -->
                    <div class="flex justify-between items-center pb-3 border-b border-slate-200 dark:border-slate-750">
                        <div>
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">ORDER NUMBER</span>
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">#{{ $order->order_number }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">DATE</span>
                            <span class="text-xs font-bold text-slate-650 dark:text-slate-350">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="text-xs space-y-1.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-bold">Customer:</span>
                            <span class="text-slate-800 dark:text-slate-200 font-extrabold">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-bold">Phone:</span>
                            <div class="flex items-center gap-1">
                                <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $order->shipping_phone }}</span>
                                @php
                                    $cleanMobile = preg_replace('/[^0-9]/', '', $order->shipping_phone);
                                @endphp
                                <a href="https://wa.me/{{ $cleanMobile }}" target="_blank" class="w-5 h-5 bg-emerald-500 text-white rounded-full flex items-center justify-center hover:scale-105 active:scale-95 transition-transform" title="Contact via WhatsApp">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.413 9.863-9.83.001-2.624-1.013-5.091-2.859-6.937C16.638 1.993 14.183.98 11.55.979c-5.442 0-9.866 4.414-9.87 9.831-.001 1.714.453 3.39 1.316 4.873L2.005 20.3l4.642-1.146zm12.333-6.6c-.328-.164-1.94-.959-2.241-1.07-.302-.111-.521-.165-.74.165-.219.329-.85 1.07-1.041 1.289-.192.219-.383.247-.712.083a9.05 9.05 0 01-2.637-1.624 9.95 9.95 0 01-1.823-2.27c-.192-.329-.021-.507.143-.671.147-.148.328-.384.493-.575.164-.192.219-.329.328-.549.11-.219.055-.411-.027-.575-.083-.164-.74-1.78-.85-2.054-.3-.728-.606-.63-.829-.63-.219-.002-.47-.002-.72-.002-.25 0-.656.093-.997.466-.34.373-1.3 1.268-1.3 3.093 0 1.825 1.33 3.59 1.516 3.837.187.247 2.616 3.994 6.337 5.602.885.383 1.577.611 2.115.782.889.282 1.698.242 2.337.146.713-.107 1.94-.794 2.213-1.52.274-.728.274-1.352.192-1.488-.083-.137-.302-.219-.63-.383z"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-bold">Address:</span>
                            <span class="text-slate-600 dark:text-slate-300 font-medium text-right max-w-[180px] truncate" title="{{ $order->shipping_address }}">{{ $order->shipping_address }}</span>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl p-2 border border-slate-100 dark:border-slate-800 space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-2 text-xs">
                                <img src="{{ asset('storage/' . ($item->product->cover_image ?? $item->product->image ?? '')) }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-slate-700">
                                <div class="flex-1 truncate">
                                    <p class="font-extrabold text-slate-800 dark:text-slate-200 truncate">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                    <p class="text-[10px] text-slate-400">Qty: {{ $item->quantity }} x {{ \App\Helpers\CurrencyHelper::formatForOrder($item->price, $order) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Action forms for statuses -->
                    <div class="space-y-2 pt-2 border-t border-slate-200 dark:border-slate-750">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="grid grid-cols-2 gap-2">
                            @csrf
                            <div>
                                <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Pay Status</label>
                                <select name="payment_status" onchange="this.form.submit()" class="w-full text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 px-2 py-1.5 outline-none
                                    {{ $order->payment_status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 border-emerald-100 dark:border-emerald-900/40' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-600 border-amber-100 dark:border-amber-900/40' }}">
                                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Order Status</label>
                                <div class="flex gap-1">
                                    <select name="status" class="w-full text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 px-2 py-1.5 outline-none
                                        @if($order->status === 'completed') bg-green-50 dark:bg-green-950/40 text-green-700 border-green-100 dark:border-green-900/40
                                        @elseif($order->status === 'cancelled') bg-red-50 dark:bg-red-950/40 text-red-700 border-red-100 dark:border-red-900/40
                                        @elseif($order->status === 'shipped') bg-blue-50 dark:bg-blue-950/40 text-blue-700 border-blue-100 dark:border-blue-900/40
                                        @else bg-amber-50 dark:bg-amber-950/40 text-amber-700 border-amber-100 dark:border-amber-900/40
                                        @endif">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-bold transition-colors">OK</button>
                                </div>
                            </div>
                            <div class="col-span-2 mt-1">
                                <input type="text" name="tracking_note" placeholder="Add tracking update note..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-indigo-500/50 outline-none">
                            </div>
                        </form>
                    </div>

                    <!-- Total Amount & Quick Buttons -->
                    <div class="flex justify-between items-center pt-3 border-t border-slate-250 dark:border-slate-750">
                        <div>
                            <span class="text-[9px] text-slate-400 font-bold block">GRAND TOTAL</span>
                            <span class="text-base font-black text-slate-900 dark:text-white">{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="openOrderModal('{{ $order->id }}')" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-750 dark:text-slate-200 text-xs font-bold rounded-xl transition-colors">
                                View
                            </button>
                            <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="px-3 py-1.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-xl transition-colors">
                                Invoice
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-8 text-center text-slate-400 dark:text-slate-500 font-semibold bg-slate-50 dark:bg-slate-850 rounded-2xl border border-slate-100 dark:border-slate-800">
                    No orders found matching filters.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="p-5 border-t border-slate-50 dark:border-slate-850 bg-slate-50/20">
                {{ $orders->links() }}
            </div>
        @endif

    </div>

    <!-- Modal and details block reuse details -->
    {{-- Order Details Modal --}}
    <div id="order-details-modal" class="fixed inset-0 z-50 overflow-y-auto hidden animate-fade-in" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeOrderModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100 dark:border-slate-800">
                <div class="bg-white dark:bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white" id="modal-title">
                            Order Details
                        </h3>
                        <button type="button" onclick="closeOrderModal()" class="text-slate-400 hover:text-rose-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="mt-6 space-y-6" id="modal-body-content">
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-950/50 px-6 py-4 sm:px-8 sm:py-5 flex justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeOrderModal()" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ordersData = {
            @foreach($orders as $order)
                "{{ $order->id }}": {
                    "number": "{{ $order->order_number }}",
                    "shipping_name": {!! json_encode($order->shipping_name) !!},
                    "shipping_phone": {!! json_encode($order->shipping_phone) !!},
                    "shipping_address": {!! json_encode($order->shipping_address) !!},
                    "total_amount": "{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}",
                    "payment_method": {!! json_encode($order->payment_method) !!},
                    "payment_status": {!! json_encode($order->payment_status) !!},
                    "status": {!! json_encode($order->status) !!},
                    "items": [
                        @foreach($order->items as $item)
                        {
                            "name": {!! json_encode($item->product->name ?? 'Deleted Product') !!},
                            "price": "{{ \App\Helpers\CurrencyHelper::formatForOrder($item->price, $order) }}",
                            "quantity": "{{ $item->quantity }}",
                            "total": "{{ \App\Helpers\CurrencyHelper::formatForOrder($item->price * $item->quantity, $order) }}",
                            "image": "{{ asset('storage/' . ($item->product->cover_image ?? $item->product->image ?? '')) }}",
                            "description": {!! json_encode($item->product->description ?? 'No description available.') !!}
                        },
                        @endforeach
                    ]
                },
            @endforeach
        };

        function openOrderModal(orderId) {
            const order = ordersData[orderId];
            if (!order) return;

            document.getElementById('modal-title').innerText = `Order Details #${order.number}`;
            
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <div class="flex flex-col sm:flex-row gap-4 p-4 border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 rounded-2xl">
                        <div class="w-20 h-20 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-xl overflow-hidden shrink-0">
                            <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-extrabold text-slate-900 dark:text-white text-sm">${item.name}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">${item.description}</p>
                            <div class="flex justify-between items-center mt-3 text-xs">
                                <span class="text-slate-600 dark:text-slate-400 font-medium">Qty: ${item.quantity} x ${item.price}</span>
                                <span class="font-bold text-slate-900 dark:text-white">Total: ${item.total}</span>
                            </div>
                        </div>
                    </div>
                `;
            });

            const bodyHtml = `
                <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100/50 dark:border-slate-800/50">
                    <div>
                        <span class="font-bold text-slate-400 dark:text-slate-500">Recipient:</span>
                        <span class="block text-slate-800 dark:text-slate-200 normal-case font-extrabold mt-0.5">${order.shipping_name}</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 dark:text-slate-500">Phone:</span>
                        <span class="block text-slate-800 dark:text-slate-200 normal-case font-extrabold mt-0.5">${order.shipping_phone}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="font-bold text-slate-400 dark:text-slate-500">Address:</span>
                        <span class="block text-slate-800 dark:text-slate-200 normal-case font-medium mt-0.5">${order.shipping_address}</span>
                    </div>
                </div>

                <div class="space-y-3 mt-4">
                    <h4 class="text-xs font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Ordered Products</h4>
                    <div class="max-h-60 overflow-y-auto space-y-3 pr-1">
                        ${itemsHtml}
                    </div>
                </div>

                <div class="flex justify-between items-center border-t border-slate-100 dark:border-slate-800 pt-4 mt-6">
                    <span class="text-slate-500 dark:text-slate-400 font-extrabold text-xs uppercase tracking-widest">Grand Total</span>
                    <span class="text-indigo-600 dark:text-indigo-400 font-extrabold text-xl">${order.total_amount}</span>
                </div>
            `;

            document.getElementById('modal-body-content').innerHTML = bodyHtml;
            document.getElementById('order-details-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeOrderModal() {
            document.getElementById('order-details-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
@endsection
