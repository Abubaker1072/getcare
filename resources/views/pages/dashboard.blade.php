@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Success message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Profile Sidebar --}}
            <div class="w-full lg:w-80 flex-shrink-0">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
                    <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4 font-serif">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-3 bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100 uppercase tracking-wide">
                        Verified Customer
                    </span>

                    <hr class="my-6 border-gray-100">

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-4 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition shadow-md shadow-gray-100 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </button>
                    </form>
                </div>

                {{-- Saved Payment Gateway details --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 font-serif text-left flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Saved Gateway Details
                    </h3>
                    <p class="text-xs text-gray-500 mb-4 text-left">Configure your default payment gateway credentials for faster checkout processing.</p>

                    <form action="{{ route('dashboard.bank-details.update') }}" method="POST" class="space-y-4 text-left">
                        @csrf
                        <div>
                            <label for="bank_name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" placeholder="e.g. Meezan Bank" value="{{ old('bank_name', $bankDetail->bank_name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('bank_name')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_number" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Account or IBAN Number</label>
                            <input type="text" name="account_number" id="account_number" placeholder="e.g. PK00MEZN00000123456789" value="{{ old('account_number', $bankDetail->account_number ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('account_number')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_holder_name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Account Title / Holder Name</label>
                            <input type="text" name="account_holder_name" id="account_holder_name" placeholder="e.g. John Doe" value="{{ old('account_holder_name', $bankDetail->account_holder_name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('account_holder_name')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="expiry_date" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Expiry (MM/YY)</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="12/29" value="{{ old('expiry_date', $bankDetail->expiry_date ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                @error('expiry_date')
                                    <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cvc" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card CVC</label>
                                <input type="text" name="cvc" id="cvc" placeholder="123" value="{{ old('cvc', $bankDetail->cvc ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                @error('cvc')
                                    <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2 px-4 bg-amber-500 text-white rounded-xl text-xs font-bold hover:bg-amber-600 transition shadow-md shadow-amber-100 flex items-center justify-center gap-1.5 uppercase tracking-wider">
                            Update Details
                        </button>
                    </form>
                </div>
            </div>

            {{-- Main Dashboard Content --}}
            <div class="flex-1">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6 font-serif">Your Order History</h1>

                    @php
                        $approvedOrders = $orders->filter(fn($o) => in_array($o->status, ['processing', 'shipped', 'completed']));
                    @endphp
                    @if($approvedOrders->isNotEmpty())
                        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl text-sm shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 font-bold shadow-md shadow-emerald-500/10">
                                    🎉
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-extrabold text-base text-slate-900 mb-0.5">Order Approved!</h4>
                                    <p class="font-medium text-slate-700">
                                        Your order(s) 
                                        @foreach($approvedOrders as $ao)
                                            <strong class="text-emerald-700">#{{ $ao->order_number }}</strong>@if(!$loop->last), @endif
                                        @endforeach
                                        have been approved by Admin. You can now download their invoice below.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($orders->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <h3 class="text-base font-bold text-gray-800">No Orders Found</h3>
                            <p class="text-sm text-gray-500 mt-1">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.all') }}" class="inline-block mt-4 bg-amber-500 text-white font-bold text-sm px-6 py-2.5 rounded-lg hover:bg-amber-600 transition shadow-md shadow-amber-100">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition-shadow">
                                    {{-- Order Info Header --}}
                                    <div class="bg-gray-50 px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4 border-b">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Order Number</p>
                                            <h4 class="text-sm sm:text-base font-extrabold text-amber-600">{{ $order->order_number }}</h4>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Date Placed</p>
                                            <p class="text-sm font-medium text-gray-800">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Payment Status</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Order Status</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase 
                                                @if($order->status === 'completed') bg-green-50 text-green-700 border border-green-100
                                                @elseif($order->status === 'cancelled') bg-red-50 text-red-700 border border-red-100
                                                @elseif($order->status === 'shipped') bg-blue-50 text-blue-700 border border-blue-100
                                                @else bg-gray-100 text-gray-700 border border-gray-200
                                                @endif">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Actions</p>
                                            @if($order->status === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold">
                                                    <svg class="w-3.5 h-3.5 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3 3L22 4"></path></svg>
                                                    Awaiting Review
                                                </span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold">
                                                    Cancelled
                                                </span>
                                            @else
                                                <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-md shadow-emerald-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Invoice
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Order Items --}}
                                    <div class="p-4 sm:p-6 divide-y divide-gray-100 bg-white">
                                        @foreach($order->items as $item)
                                            @php
                                                $product = $item->product;
                                                $imagePath = $product && ($product->cover_image || $product->image)
                                                    ? asset('storage/' . ($product->cover_image ?? $product->image))
                                                    : 'https://via.placeholder.com/150';
                                            @endphp
                                            <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                                                <div class="w-14 h-14 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                                    <img src="{{ $imagePath }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    @if($product)
                                                        <h5 class="text-sm font-bold text-gray-900 truncate hover:text-amber-600">
                                                            <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                        </h5>
                                                    @else
                                                        <h5 class="text-sm font-bold text-gray-500 truncate">Deleted Product</h5>
                                                    @endif
                                                    <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} x {{ \App\Helpers\CurrencyHelper::format($item->price) }}</p>
                                                </div>
                                                <span class="text-sm font-bold text-gray-900">{{ \App\Helpers\CurrencyHelper::format($item->price * $item->quantity) }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Order Shipping Summary --}}
                                    <div class="bg-gray-50/50 p-4 sm:px-6 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">
                                        <div>
                                            <span class="font-semibold text-gray-700">Shipping to:</span>
                                            <span class="text-gray-600">{{ $order->shipping_name }} ({{ $order->shipping_phone }}), {{ $order->shipping_address }}</span>
                                        </div>
                                        <div class="text-right w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 flex justify-between sm:block gap-4">
                                            <span class="font-bold text-gray-500 sm:mr-2">Grand Total:</span>
                                            <span class="text-lg font-extrabold text-amber-600">{{ \App\Helpers\CurrencyHelper::format($order->total_amount) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
