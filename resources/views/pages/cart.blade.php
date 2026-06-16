@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            {{-- Cart Items List (Left) --}}
            <div class="lg:col-span-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 lg:mb-0">
                <div class="hidden sm:grid sm:grid-cols-6 gap-4 p-4 border-b border-gray-200 bg-gray-50 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                    <div class="col-span-3">Product</div>
                    <div class="col-span-1 text-center">Price</div>
                    <div class="col-span-1 text-center">Quantity</div>
                    <div class="col-span-1 text-right">Total</div>
                </div>

                @forelse($cartItems as $item)
                @php
                    $product = $item->product;
                    $itemPrice = $product->price;
                    $itemTotal = $itemPrice * $item->quantity;
                    $imagePath = $product->cover_image || $product->image 
                        ? asset('storage/' . ($product->cover_image ?? $product->image))
                        : 'https://via.placeholder.com/150';
                @endphp
                {{-- Item Row --}}
                <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:grid sm:grid-cols-6 items-center gap-4 sm:gap-6 relative">
                    {{-- Mobile Remove (top right) --}}
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="absolute top-4 right-4 sm:hidden">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>

                    <div class="col-span-3 flex items-center gap-4 w-full">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            <img src="{{ $imagePath }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <a href="{{ route('product.detail', $product->slug) }}" class="text-sm sm:text-base font-bold text-gray-900 hover:text-amber-600 line-clamp-2">{{ $product->name }}</a>
                            <p class="text-xs text-gray-500 mt-1">Category: {{ $product->category->name ?? 'N/A' }}</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="hidden sm:block mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline">Remove</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Price:</span>
                        <span class="text-sm sm:text-base font-semibold text-gray-900">{{ \App\Helpers\CurrencyHelper::format($itemPrice) }}</span>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Qty:</span>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-gray-300 rounded-md bg-white">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-2 py-1 text-gray-600 hover:bg-gray-100" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $product->stock }}" class="w-8 text-center text-sm border-none focus:ring-0 text-gray-900 font-medium bg-transparent p-0" onchange="this.form.submit()">
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-2 py-1 text-gray-600 hover:bg-gray-100" {{ $item->quantity >= $product->stock ? 'disabled' : '' }}>+</button>
                        </form>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-end items-center">
                        <span class="sm:hidden text-sm text-gray-500">Total:</span>
                        <span class="text-base sm:text-lg font-bold text-amber-600">{{ \App\Helpers\CurrencyHelper::format($itemTotal) }}</span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    Your cart is currently empty.
                </div>
                @endforelse
                
                {{-- Actions --}}
                <div class="p-4 sm:p-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('products.all') }}" class="text-sm font-medium text-amber-600 hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            {{-- Order Summary (Right) --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping Fee</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::format($shippingFee) }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <div class="text-right">
                                <span class="text-2xl font-extrabold text-amber-600">{{ \App\Helpers\CurrencyHelper::format($total) }}</span>
                                <p class="text-xs text-gray-400 mt-1">VAT included, where applicable</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($cartItems->isNotEmpty())
                    <a href="/checkout" class="block w-full bg-amber-500 text-white text-center py-3.5 px-4 rounded-md font-bold text-base hover:bg-amber-600 transition shadow-lg shadow-amber-200 uppercase tracking-wide">
                        Proceed to Checkout
                    </a>
                    @else
                    <button disabled class="w-full bg-gray-300 text-white py-3.5 px-4 rounded-md font-bold text-base cursor-not-allowed uppercase tracking-wide">
                        Proceed to Checkout
                    </button>
                    @endif
                    
                    <div class="mt-6 flex justify-center gap-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" class="h-6 object-contain grayscale opacity-60">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" class="h-6 object-contain grayscale opacity-60">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection