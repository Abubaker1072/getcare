@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8 font-serif">Checkout</h1>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Billing & Shipping Form (Left) --}}
            <div class="lg:col-span-7 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-3">Shipping Details</h2>
                
                <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="shipping_name" class="block text-sm font-semibold text-gray-700 mb-2">Recipient Name</label>
                        <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                        @error('shipping_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="e.g. 03001234567" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                        @error('shipping_phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_address" class="block text-sm font-semibold text-gray-700 mb-2">Detailed Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="4" required placeholder="Apartment, suite, unit, building, street, city..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
                        <div class="space-y-4">
                            @if($codActive)
                            <div class="payment-option-container border rounded-lg p-4 flex items-center justify-between cursor-pointer transition-all {{ !$bankActive ? 'border-amber-500 bg-amber-50/50' : 'border-gray-200 hover:bg-gray-50' }}" onclick="selectPaymentMethod('cod')">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cod" id="payment_cod" {{ !$bankActive ? 'checked' : '' }}
                                        class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" onchange="togglePaymentSelection('cod')">
                                    <div>
                                        <label for="payment_cod" class="text-sm font-bold text-gray-900 cursor-pointer">Cash on Delivery (COD)</label>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $codDescription }}</p>
                                    </div>
                                </div>
                                <span class="text-amber-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </span>
                            </div>
                            @endif

                            @if($bankActive)
                            <div class="payment-option-container border rounded-lg p-4 transition-all {{ !$codActive ? 'border-amber-500 bg-amber-50/50' : 'border-gray-200 hover:bg-gray-50' }}" onclick="selectPaymentMethod('bank')">
                                <div class="flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank" id="payment_bank" {{ !$codActive ? 'checked' : '' }}
                                            class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" onchange="togglePaymentSelection('bank')">
                                        <div>
                                            <label for="payment_bank" class="text-sm font-bold text-gray-900 cursor-pointer">Direct Bank Transfer</label>
                                            <p class="text-xs text-gray-500 mt-0.5">Transfer directly to our bank account. Please share receipt on WhatsApp.</p>
                                        </div>
                                    </div>
                                    <span class="text-indigo-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                    </span>
                                </div>
                                <div id="bank-details-box" class="{{ $codActive ? 'hidden' : '' }} mt-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                                    @php
                                        $adminGateway = \App\Models\PaymentGateway::first();
                                    @endphp
                                    @if($adminGateway && $adminGateway->admin_bank_name)
                                    <div class="mb-4 p-4 bg-indigo-50/50 border border-indigo-100/50 rounded-xl text-xs space-y-1.5 text-slate-700">
                                        <p class="font-bold text-indigo-700 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                            STORE PAYEE DETAILS:
                                        </p>
                                        <div><strong>Bank Name:</strong> {{ $adminGateway->admin_bank_name }}</div>
                                        <div><strong>IBAN / Account Number:</strong> <code class="font-mono text-indigo-700 bg-white px-1.5 py-0.5 rounded border border-indigo-100">{{ $adminGateway->admin_account_number }}</code></div>
                                        <div><strong>Account Title:</strong> {{ $adminGateway->admin_account_holder_name }}</div>
                                    </div>
                                    @endif

                                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        {{ !$codActive ? 'Your Payment Account Details' : 'Your Bank Account Details' }}
                                    </p>
                                    
                                    <div>
                                        <label for="customer_bank_name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Your Bank Name *</label>
                                        <input type="text" name="customer_bank_name" id="customer_bank_name" placeholder="e.g. Meezan Bank, HBL" value="{{ old('customer_bank_name', $bankDetail->bank_name ?? '') }}" {{ !$codActive ? 'required' : '' }}
                                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors bg-white font-semibold">
                                        @error('customer_bank_name')
                                            <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="customer_account_number" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Your Account or IBAN Number *</label>
                                        <input type="text" name="customer_account_number" id="customer_account_number" placeholder="e.g. PK00MEZN00000123456789" value="{{ old('customer_account_number', $bankDetail->account_number ?? '') }}" {{ !$codActive ? 'required' : '' }}
                                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors bg-white font-semibold">
                                        @error('customer_account_number')
                                            <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="customer_account_holder" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Account Title / Holder Name *</label>
                                        <input type="text" name="customer_account_holder" id="customer_account_holder" placeholder="e.g. John Doe" value="{{ old('customer_account_holder', $bankDetail->account_holder_name ?? '') }}" {{ !$codActive ? 'required' : '' }}
                                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors bg-white font-semibold">
                                        @error('customer_account_holder')
                                            <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @if(!$codActive)
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="customer_expiry_date" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Expiry Date (MM/YY) *</label>
                                            <input type="text" name="customer_expiry_date" id="customer_expiry_date" placeholder="e.g. 12/29" value="{{ old('customer_expiry_date', $bankDetail->expiry_date ?? '') }}" {{ !$codActive ? 'required' : '' }}
                                                class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors bg-white font-semibold">
                                            @error('customer_expiry_date')
                                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="customer_cvc" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card CVC *</label>
                                            <input type="text" name="customer_cvc" id="customer_cvc" placeholder="e.g. 123" value="{{ old('customer_cvc', $bankDetail->cvc ?? '') }}" {{ !$codActive ? 'required' : '' }}
                                                class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors bg-white font-semibold">
                                            @error('customer_cvc')
                                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        @error('payment_method')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-amber-500 text-white py-3.5 px-4 rounded-lg font-bold text-base hover:bg-amber-600 transition shadow-lg shadow-amber-200 uppercase tracking-wide">
                        Place Order ({{ \App\Helpers\CurrencyHelper::format($total) }})
                    </button>
                </form>
            </div>

            {{-- Order Summary (Right) --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-3">Your Order</h2>
                    
                    {{-- Cart Items --}}
                    <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto mb-6 pr-2">
                        @foreach($cartItems as $item)
                        @php
                            $product = $item->product;
                            $imagePath = $product->cover_image || $product->image 
                                ? asset('storage/' . ($product->cover_image ?? $product->image))
                                : 'https://via.placeholder.com/150';
                        @endphp
                        <div class="flex items-center gap-4 py-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} x {{ \App\Helpers\CurrencyHelper::format($product->price) }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-900 flex-shrink-0">{{ \App\Helpers\CurrencyHelper::format($product->price * $item->quantity) }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Price breakdowns --}}
                    <div class="space-y-4 text-sm text-gray-600 border-t pt-4 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping Fee</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::format($shippingFee) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-4 items-end">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-extrabold text-amber-600">{{ \App\Helpers\CurrencyHelper::format($total) }}</span>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-4">
                        <div class="flex gap-2.5">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs text-amber-800 leading-relaxed">
                                Please review your items and shipping details carefully before ordering. We ship using tracked delivery service to ensure your device reaches you safely.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPaymentMethod(method) {
        const radio = document.getElementById('payment_' + method);
        if (radio) {
            radio.checked = true;
            togglePaymentSelection(method);
        }
    }

    function togglePaymentSelection(selectedMethod) {
        // Remove highlight from all containers
        document.querySelectorAll('.payment-option-container').forEach(container => {
            container.classList.remove('border-amber-500', 'bg-amber-50/50');
            container.classList.add('border-gray-250');
        });

        // Add highlight to selected container
        const radio = document.getElementById('payment_' + selectedMethod);
        if (radio) {
            const container = radio.closest('.payment-option-container');
            if (container) {
                container.classList.remove('border-gray-250');
                container.classList.add('border-amber-500', 'bg-amber-50/50');
            }
        }

        // Toggle bank details box visibility and required attribute
        const bankBox = document.getElementById('bank-details-box');
        if (bankBox) {
            const inputs = bankBox.querySelectorAll('input');
            if (selectedMethod === 'bank') {
                bankBox.classList.remove('hidden');
                inputs.forEach(input => input.setAttribute('required', 'required'));
            } else {
                bankBox.classList.add('hidden');
                inputs.forEach(input => input.removeAttribute('required'));
            }
        }
    }
</script>

@if(session('insufficient_balance'))
<div id="insufficient-balance-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl p-8 max-w-sm w-full text-center relative transform transition-all duration-300 scale-100">
        <!-- Close Button -->
        <button onclick="closeBalanceModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <!-- Warning Icon -->
        <div class="w-16 h-16 bg-rose-50 border border-rose-100 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-600 shadow-sm animate-bounce">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        
        <!-- Title & Description -->
        <h3 class="text-xl font-black text-slate-900 mb-2">Insufficient Balance</h3>
        <p class="text-sm text-slate-500 leading-relaxed mb-6 font-medium">
            {{ session('insufficient_balance') }}
        </p>
        
        <!-- Try Again Button -->
        <button onclick="closeBalanceModal()" class="w-full py-3 bg-slate-900 text-white rounded-xl text-sm font-bold shadow-md hover:bg-slate-800 transition-all">
            Try Another Account
        </button>
    </div>
</div>
<script>
    function closeBalanceModal() {
        const modal = document.getElementById('insufficient-balance-modal');
        if (modal) {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }
</script>
@endif

<!-- Order Placing Loader Overlay -->
<div id="order-placing-loader" class="fixed inset-0 bg-black/75 z-[99999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl flex flex-col items-center">
        <!-- Ticking pulse ring or animated cart icon -->
        <div class="relative w-24 h-24 mb-6 flex items-center justify-center bg-amber-50 rounded-full text-amber-500">
            <svg class="w-12 h-12 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <div class="absolute inset-0 rounded-full border-2 border-amber-500/30 border-t-amber-500 animate-spin"></div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Processing Your Order</h3>
        <p class="text-sm text-gray-500">Please do not close this window or refresh the page. We are securing your skincare routine...</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        if (form) {
            form.addEventListener('submit', function() {
                const loader = document.getElementById('order-placing-loader');
                if (loader) {
                    loader.classList.remove('hidden');
                    setTimeout(() => loader.classList.add('opacity-100'), 10);
                }
            });
        }
    });
</script>
@endsection
