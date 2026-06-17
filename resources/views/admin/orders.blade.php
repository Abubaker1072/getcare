@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Orders</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Track fulfillments, manage payments, and review incoming sales.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-250 dark:border-emerald-900/40 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <!-- Table Search & Filters -->
        <div class="p-5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
                <div class="relative w-full sm:w-72">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search orders by number, name, phone..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-sm" onchange="this.form.submit()">
                </div>
                <div class="flex space-x-2 w-full sm:w-auto">
                    <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 outline-none shadow-sm">
                        <option value="All Statuses" {{ $status === 'All Statuses' || !$status ? 'selected' : '' }}>All Statuses</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
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
                                <p class="font-extrabold text-indigo-600 dark:text-indigo-400 text-base text-link">#{{ $order->order_number }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $order->user->name ?? 'Guest/Deleted' }} ({{ $order->user->email ?? '' }})</p>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    @foreach($order->items as $item)
                                        @if($item->product)
                                            <div class="relative group/img flex-shrink-0">
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
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 px-2.5 py-1 outline-none cursor-pointer
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
                                    <button type="button" onclick="openOrderModal('{{ $order->id }}')" class="inline-flex items-center gap-1 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 px-2.5 py-1.5 rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View
                                    </button>
                                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 dark:hover:bg-indigo-950/60 px-2.5 py-1.5 rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Invoice
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete order #{{ $order->order_number }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 dark:text-rose-400 hover:text-rose-900 dark:hover:text-rose-300 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-950/60 px-2.5 py-1.5 rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="p-5 border-t border-slate-50 dark:border-slate-800">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

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
                        {{-- Dynamically populated content --}}
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