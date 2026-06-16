@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')
    {{-- Product Categories Carousel --}}
    <section class="py-12 md:py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 md:mb-12">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">Featured Collections</h2>
                    <p class="text-sm md:text-base text-gray-600">Discover our premium skincare & beauty devices</p>
                </div>
            </div>

            {{-- Category Cards Carousel --}}
            <div class="relative">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 overflow-x-auto pb-4">
                    {{-- LED Light Therapy --}}
                    <div class="relative min-w-full md:min-w-auto rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-pink-200 to-red-300 flex items-center justify-center">
                            <img src="{{ ImageHelper::getProductImage('led-light.jpg') }}" alt="LED Light Therapy" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">LED LIGHT THERAPY</h3>
                            <button class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                SHOP NOW
                            </button>
                        </div>
                    </div>

                    {{-- Anti-Aging --}}
                    <div class="relative min-w-full md:min-w-auto rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center">
                            <img src="{{ ImageHelper::getProductImage('anti-aging.jpg') }}" alt="Anti-Aging" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">ANTI-AGING</h3>
                            <button class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                SHOP NOW
                            </button>
                        </div>
                    </div>

                    {{-- Anti-Acne --}}
                    <div class="relative min-w-full md:min-w-auto rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-green-200 to-teal-300 flex items-center justify-center">
                            <img src="{{ ImageHelper::getProductImage('anti-acne.jpg') }}" alt="Anti-Acne" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">ANTI-ACNE</h3>
                            <button class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                SHOP NOW
                            </button>
                        </div>
                    </div>

                    {{-- Shop All Devices --}}
                    <div class="relative min-w-full md:min-w-auto rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-blue-200 to-indigo-300 flex items-center justify-center">
                            <img src="{{ ImageHelper::getProductImage('all-devices.jpg') }}" alt="Shop All Devices" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">SHOP ALL DEVICES</h3>
                            <button class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                SHOP NOW
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Transformation Stats Section --}}
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-gray-500 text-xs md:text-sm font-semibold mb-2 uppercase tracking-wider">LOVED BY YOU, LOVED BY SKIN. APPROVED BY YOU</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900">500,000+ Skincare Routines Transformed</h2>
            </div>

            {{-- Testimonials Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6 mb-12">
                {{-- Fine Lines & Dullness --}}
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-100 h-48 sm:h-56 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                            <span class="text-gray-500 text-sm">Before & After</span>
                        </div>
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage('before-after-1.jpg') }}" alt="Fine Lines" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Fine Lines, Dullness</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3">"My 100% result buying. My face and neck are transformed"</p>
                    <div class="flex items-center gap-2">
                        <img src="{{ ImageHelper::getProductImage('avatar-1.jpg') }}" alt="User" class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gray-300">
                        <div class="text-xs">
                            <p class="font-semibold text-gray-900">Sarah M.</p>
                            <p class="text-gray-500 text-xs">Verified Purchase</p>
                        </div>
                    </div>
                </div>

                {{-- Aging, Wrinkles --}}
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-100 h-48 sm:h-56 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                            <span class="text-gray-500 text-sm">Before & After</span>
                        </div>
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage('before-after-2.jpg') }}" alt="Aging" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Aging, Wrinkles</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3">"The depth of my forehead wrinkles look less noticeable"</p>
                    <div class="flex items-center gap-2">
                        <img src="{{ ImageHelper::getProductImage('avatar-2.jpg') }}" alt="User" class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gray-300">
                        <div class="text-xs">
                            <p class="font-semibold text-gray-900">Emma L.</p>
                            <p class="text-gray-500 text-xs">Verified Purchase</p>
                        </div>
                    </div>
                </div>

                {{-- Inflammation, Redness --}}
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-100 h-48 sm:h-56 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                            <span class="text-gray-500 text-sm">Before & After</span>
                        </div>
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage('before-after-3.jpg') }}" alt="Inflammation" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Inflammation, Redness</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3">"I genuinely see visible results. My skin is calmer & brighter"</p>
                    <div class="flex items-center gap-2">
                        <img src="{{ ImageHelper::getProductImage('avatar-3.jpg') }}" alt="User" class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gray-300">
                        <div class="text-xs">
                            <p class="font-semibold text-gray-900">Jessica T.</p>
                            <p class="text-gray-500 text-xs">Verified Purchase</p>
                        </div>
                    </div>
                </div>

                {{-- Fine Lines, Sun Damage --}}
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-100 h-48 sm:h-56 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                            <span class="text-gray-500 text-sm">Before & After</span>
                        </div>
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage('before-after-4.jpg') }}" alt="Sun Damage" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Fine Lines, Sun Damage</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3">"Definitely enhanced my routine. Visible skin improvements in skin tone and hydration"</p>
                    <div class="flex items-center gap-2">
                        <img src="{{ ImageHelper::getProductImage('avatar-4.jpg') }}" alt="User" class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gray-300">
                        <div class="text-xs">
                            <p class="font-semibold text-gray-900">Michelle K.</p>
                            <p class="text-gray-500 text-xs">Verified Purchase</p>
                        </div>
                    </div>
                </div>

                {{-- Saggy Skin --}}
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-100 h-48 sm:h-56 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                            <span class="text-gray-500 text-sm">Before & After</span>
                        </div>
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage('before-after-5.jpg') }}" alt="Saggy Skin" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Saggy Skin</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mb-3">"My skin looks firmer and more lifted. Truly game-changing"</p>
                    <div class="flex items-center gap-2">
                        <img src="{{ ImageHelper::getProductImage('avatar-5.jpg') }}" alt="User" class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gray-300">
                        <div class="text-xs">
                            <p class="font-semibold text-gray-900">Rachel P.</p>
                            <p class="text-gray-500 text-xs">Verified Purchase</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Carousel Navigation (Optional) --}}
            <div class="flex items-center justify-center gap-4">
                <button class="p-2 rounded-full border border-gray-300 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div class="flex gap-2">
                    <button class="w-3 h-3 rounded-full bg-amber-600 transition"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 transition"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 transition"></button>
                </div>
                <button class="p-2 rounded-full border border-gray-300 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Featured Products Grid --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Best Sellers</h2>
                <p class="text-gray-600 text-lg">Handpicked products loved by thousands of customers</p>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $products = [
                        ['name' => 'Premium LED Mask', 'category' => 'Light Therapy', 'price' => 199.99, 'image' => 'product-1.jpg', 'rating' => 4.8],
                        ['name' => 'Anti-Aging Serum', 'category' => 'Skincare', 'price' => 79.99, 'image' => 'product-2.jpg', 'rating' => 4.9],
                        ['name' => 'Facial Cleansing Brush', 'category' => 'Cleansing', 'price' => 89.99, 'image' => 'product-3.jpg', 'rating' => 4.7],
                        ['name' => 'Microneedle Roller', 'category' => 'Treatment', 'price' => 49.99, 'image' => 'product-4.jpg', 'rating' => 4.6],
                        ['name' => 'Hydrating Face Mask', 'category' => 'Skincare', 'price' => 34.99, 'image' => 'product-5.jpg', 'rating' => 4.8],
                        ['name' => 'Ultra Sonic Pen', 'category' => 'Device', 'price' => 129.99, 'image' => 'product-6.jpg', 'rating' => 4.9],
                        ['name' => 'Gold Eye Patches', 'category' => 'Treatment', 'price' => 24.99, 'image' => 'product-7.jpg', 'rating' => 4.7],
                        ['name' => 'Vitamin C Brightener', 'category' => 'Serum', 'price' => 59.99, 'image' => 'product-8.jpg', 'rating' => 4.8],
                    ];
                @endphp

                @foreach($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    {{-- Product Image --}}
                    <a href="{{ route('product.detail', 11) }}" class="block relative h-72 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden group">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImage($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">SALE</div>
                        <button class="absolute bottom-4 left-4 right-4 bg-white text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-100 transition opacity-0 group-hover:opacity-100" onclick="event.preventDefault(); window.openCart(event)">
                            ADD TO CART
                        </button>
                    </a>

                    {{-- Product Info --}}
                    <div class="p-5">
                        <p class="text-xs text-gray-500 font-semibold mb-1 uppercase">{{ $product['category'] }}</p>
                        <a href="{{ route('product.detail', 11) }}" class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-amber-600 transition">{{ $product['name'] }}</a>
                        
                        {{-- Rating --}}
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($product['rating']))
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">({{ $product['rating'] }})</span>
                        </div>

                        {{-- Price --}}
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-gray-900">{!! \App\Helpers\CurrencyHelper::format($product['price']) !!}</span>
                            <span class="text-lg text-gray-400 line-through">{!! \App\Helpers\CurrencyHelper::format($product['price'] * 1.3) !!}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
