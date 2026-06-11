@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            {{-- Cart Items List (Left) --}}
            <div class="lg:col-span-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 lg:mb-0">
                <div class="hidden sm:grid sm:grid-cols-6 gap-4 p-4 border-b border-gray-200 bg-gray-50 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                    <div class="col-span-3">Product</div>
                    <div class="col-span-1 text-center">Price</div>
                    <div class="col-span-1 text-center">Quantity</div>
                    <div class="col-span-1 text-right">Total</div>
                </div>

                {{-- Item 1 --}}
                <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:grid sm:grid-cols-6 items-center gap-4 sm:gap-6 relative">
                    {{-- Mobile Remove (top right) --}}
                    <button class="absolute top-4 right-4 sm:hidden text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>

                    <div class="col-span-3 flex items-center gap-4 w-full">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('Products/Product Item 11/EMS Foot Massager (1).webp') }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <a href="#" class="text-sm sm:text-base font-bold text-gray-900 hover:text-amber-600 line-clamp-2">EMS Foot Massager Mat</a>
                            <p class="text-xs text-gray-500 mt-1">Color: Black</p>
                            <button class="hidden sm:inline-block text-xs text-red-500 hover:underline mt-2">Remove</button>
                        </div>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Price:</span>
                        <span class="text-sm sm:text-base font-semibold text-gray-900">₨ 2,500</span>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Qty:</span>
                        <div class="flex items-center border border-gray-300 rounded-md bg-white">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="number" value="1" min="1" class="w-8 text-center text-sm border-none focus:ring-0 text-gray-900 font-medium bg-transparent p-0">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-end items-center">
                        <span class="sm:hidden text-sm text-gray-500">Total:</span>
                        <span class="text-base sm:text-lg font-bold text-amber-600">₨ 2,500</span>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="p-4 sm:p-6 flex flex-col sm:grid sm:grid-cols-6 items-center gap-4 sm:gap-6 relative">
                    <button class="absolute top-4 right-4 sm:hidden text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>

                    <div class="col-span-3 flex items-center gap-4 w-full">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('Products/Product Item 12/3 in 1 EMS Back Belt with Heating and RLT (1).webp') }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <a href="#" class="text-sm sm:text-base font-bold text-gray-900 hover:text-amber-600 line-clamp-2">3 IN 1 Lower Back Brace Belt Stimulator</a>
                            <p class="text-xs text-gray-500 mt-1">Color: Standard</p>
                            <button class="hidden sm:inline-block text-xs text-red-500 hover:underline mt-2">Remove</button>
                        </div>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Price:</span>
                        <span class="text-sm sm:text-base font-semibold text-gray-900">₨ 4,200</span>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-center items-center">
                        <span class="sm:hidden text-sm text-gray-500">Qty:</span>
                        <div class="flex items-center border border-gray-300 rounded-md bg-white">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="number" value="1" min="1" class="w-8 text-center text-sm border-none focus:ring-0 text-gray-900 font-medium bg-transparent p-0">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                    </div>
                    <div class="col-span-1 w-full sm:w-auto flex justify-between sm:justify-end items-center">
                        <span class="sm:hidden text-sm text-gray-500">Total:</span>
                        <span class="text-base sm:text-lg font-bold text-amber-600">₨ 4,200</span>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="p-4 sm:p-6 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('products.all') }}" class="text-sm font-medium text-amber-600 hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Continue Shopping
                    </a>
                    <button class="w-full sm:w-auto bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm font-semibold hover:bg-gray-50 transition shadow-sm">
                        Update Cart
                    </button>
                </div>
            </div>

            {{-- Order Summary (Right) --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal (2 items)</span>
                            <span class="font-medium text-gray-900">₨ 6,700</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping Fee</span>
                            <span class="font-medium text-gray-900">₨ 150</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span class="font-medium">- ₨ 0</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <div class="text-right">
                                <span class="text-2xl font-extrabold text-amber-600">₨ 6,850</span>
                                <p class="text-xs text-gray-400 mt-1">VAT included, where applicable</p>
                            </div>
                        </div>
                    </div>

                    {{-- Promo Code --}}
                    <div class="mb-6">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Enter Voucher Code" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 outline-none">
                            <button class="bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-800 transition">Apply</button>
                        </div>
                    </div>
                    
                    <button class="w-full bg-amber-500 text-white py-3.5 px-4 rounded-md font-bold text-base hover:bg-amber-600 transition shadow-lg shadow-amber-200 uppercase tracking-wide">
                        Proceed to Checkout
                    </button>
                    
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