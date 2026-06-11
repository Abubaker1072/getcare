@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp
@section('content')

{{-- SWIPER CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .reel-swiper {
        padding: 40px 0;
    }
    .swiper-slide {
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.5;
        transform: scale(0.85);
    }
    .swiper-slide-active {
        opacity: 1;
        transform: scale(1);
    }
    .swiper-button-next, .swiper-button-prev {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 16px;
    }
    /* Add inside your existing <style> tag */
@keyframes marquee {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-100%); }
}
.animate-marquee {
    animation: marquee 30s linear infinite;
    display: flex;
    min-width: 100%;
    flex-shrink: 0;
    justify-content: space-around;
}
.marquee-container:hover .animate-marquee {
    animation-play-state: paused;
}
</style>


{{-- HERO SECTION --}}
<section class="relative min-h-screen md:h-[600px] lg:h-[700px] overflow-hidden">
    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1400&h=700&fit=crop" 
             alt="LED Light Therapy Hero" 
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 h-full flex items-center justify-center md:justify-start">
        <div class="max-w-7xl w-full mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-0">
            <div class="max-w-xl">
                {{-- Main Heading --}}
                <h1 class="text-4xl sm:text-5xl md:text-5xl lg:text-7xl font-bold text-white mb-2 md:mb-3 leading-tight tracking-wide">
                    SEMI-ANNUAL<br>SALE
                </h1>

                {{-- Subtitle --}}
                <p class="text-base sm:text-lg md:text-lg lg:text-xl text-gray-100 mb-4 md:mb-6 font-light tracking-wide">
                    Science Your Skin Deserves
                </p>

                {{-- Offers --}}
                <div class="space-y-1 md:space-y-2 mb-6 md:mb-8">
                    <p class="text-sm md:text-base text-white font-semibold">BUY 1 | 10% OFF</p>
                    <p class="text-sm md:text-base text-white font-semibold">BUY 2 | 20% OFF</p>
                </div>

                {{-- CTA Button --}}
                <a href="{{ route('products.all') }}" class="inline-flex items-center gap-2 bg-white text-gray-900 px-6 sm:px-8 py-2.5 sm:py-3.5 rounded-full font-semibold hover:bg-gray-100 transition text-sm sm:text-base uppercase tracking-wider touch-none active:bg-gray-200">
                    SHOP THE SALE
                    <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES SECTION --}}
<section id="categories" class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 md:mb-4">Featured Collections</h2>
            <p class="text-gray-600 text-sm md:text-lg">Discover our premium skincare & beauty devices</p>
        </div>

        {{-- Category Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            {{-- LED Light Therapy --}}
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-pink-200 to-red-300">
                    <img src="{{ ImageHelper::getProductImage('led-light.jpg') }}" alt="LED Light Therapy" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">LED LIGHT THERAPY</h3>
                    <a href="{{ route('products.all') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2.5 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        SHOP NOW
                    </a>
                </div>
            </div>

            {{-- Anti-Aging --}}
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-amber-200 to-orange-300">
                    <img src="{{ ImageHelper::getProductImage('anti-aging.jpg') }}" alt="Anti-Aging" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">ANTI-AGING</h3>
                    <a href="{{ route('products.all') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2.5 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        SHOP NOW
                    </a>
                </div>
            </div>

            {{-- Anti-Acne --}}
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-green-200 to-teal-300">
                    <img src="{{ ImageHelper::getProductImage('anti-acne.jpg') }}" alt="Anti-Acne" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">ANTI-ACNE</h3>
                    <a href="{{ route('products.all') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2.5 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        SHOP NOW
                    </a>
                </div>
            </div>

            {{-- Shop All Devices --}}
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <div class="relative h-60 sm:h-72 md:h-80 bg-gradient-to-br from-blue-200 to-indigo-300">
                    <img src="{{ ImageHelper::getProductImage('all-devices.jpg') }}" alt="Shop All Devices" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-4 sm:p-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">SHOP ALL DEVICES</h3>
                    <a href="{{ route('products.all') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-6 py-2.5 rounded-full font-semibold w-fit hover:bg-gray-100 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        SHOP NOW
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRODUCTS SECTION --}}
<section class="py-16 md:py-24 relative overflow-hidden">
    {{-- Animated Background Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-slate-50 -z-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-pink-200/20 rounded-full blur-3xl -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl -z-10 animate-pulse animation-delay-2000"></div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block text-sm font-semibold text-amber-600 mb-3 tracking-wider uppercase">Premium Selection</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4">Bestselling Products</h2>
            <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">Discover our most loved beauty and skincare devices trusted by thousands</p>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-12">
            @php
                $homeProducts = [
                    [
                        'name' => 'CurrentBody Skin LED Red Light Therapy Face Mask: Series 2',
                        'description' => 'FDA cleared LED face mask for advanced anti-aging',
                        'price' => 469.99,
                        'original_price' => 549.99,
                        'rating' => 4.8,
                        'reviews' => 1175,
                        'image' => 'product-1.jpg',
                        'gradient' => 'from-pink-100 to-red-200',
                    ],
                    [
                        'name' => 'CurrentBody Skin LED Blue Light Therapy Face Mask: Series 2',
                        'description' => 'FDA cleared advanced red and blue LED therapy mask for clearer, brighter skin',
                        'price' => 469.99,
                        'original_price' => 549.99,
                        'rating' => 4.9,
                        'reviews' => 35,
                        'image' => 'product-2.jpg',
                        'gradient' => 'from-blue-100 to-cyan-200',
                    ],
                    [
                        'name' => 'CurrentBody Skin LED Neck & Décolletage Mask: Series 2',
                        'description' => 'FDA-cleared red and near-infrared light for advanced anti-aging',
                        'price' => 419.99,
                        'original_price' => 499.99,
                        'rating' => 4.7,
                        'reviews' => 19,
                        'image' => 'product-3.jpg',
                        'gradient' => 'from-amber-100 to-orange-200',
                    ],
                    [
                        'name' => 'CurrentBody Skin LED Red Light Hair Growth Helmet',
                        'description' => 'FDA cleared red light therapy for fuller, stronger, thicker hair growth',
                        'price' => 859.99,
                        'original_price' => 999.99,
                        'rating' => 4.6,
                        'reviews' => 174,
                        'image' => 'product-4.jpg',
                        'gradient' => 'from-purple-100 to-pink-200',
                    ],
                ];
            @endphp

            @foreach($homeProducts as $index => $product)
            <div class="product-card group cursor-pointer animation-delay-{{ $index * 100 }}">
                {{-- Card Container --}}
                <div class="relative h-full rounded-3xl overflow-hidden bg-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    {{-- Product Image Container --}}
                    <div class="relative bg-gradient-to-br {{ $product['gradient'] }} h-72 sm:h-80 md:h-96 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/0 group-hover:from-black/30 transition duration-500"></div>
                        <img src="{{ ImageHelper::getProductImage($product['image']) }}" 
                             alt="{{ $product['name'] }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">

                        <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg transform transition-transform duration-300 hover:scale-110">
                            Sale
                        </div>

                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="text-white text-center">
                                <svg class="w-16 h-16 mx-auto mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-5 sm:p-6">
                        <span class="inline-block text-xs font-semibold text-amber-600 mb-2 uppercase tracking-wider">LED Therapy</span>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base line-clamp-2 mb-2.5 leading-tight group-hover:text-amber-600 transition-colors">
                            {{ $product['name'] }}
                        </h3>

                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-2">
                            {{ $product['description'] }}
                        </p>

                        <div class="mb-4 pb-4 border-b border-gray-100">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-xl sm:text-2xl font-bold text-gray-900">${{ number_format($product['price'], 2) }}</span>
                                <span class="text-xs text-gray-400 line-through">${{ number_format($product['original_price'], 2) }}</span>
                                <span class="text-xs font-bold text-green-600">{{ round((1 - $product['price']/$product['original_price']) * 100) }}% OFF</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($product['rating']))
                                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-600 font-medium">({{ $product['reviews'] }} reviews)</span>
                        </div>

                        <button class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white py-3 px-4 rounded-xl font-bold text-sm sm:text-base uppercase tracking-wider hover:from-amber-700 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg group/btn relative overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Add to Cart
                            </span>
                            <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover/btn:translate-x-full transition-transform duration-500"></div>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('products.all') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-gray-900 to-gray-800 text-white px-8 md:px-10 py-3.5 md:py-4 rounded-full font-bold text-base md:text-lg uppercase tracking-wider hover:from-gray-800 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl group">
                View All Products
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- PROFESSIONAL REELS SECTION (NEW ADDITION) --}}
<section class="py-16 bg-white overflow-hidden">
    <div class="text-center mb-10 px-4">
        <h2 class="text-3xl md:text-4xl font-light text-gray-800">Used by the professionals, approved by the professionals</h2>
        <p class="text-sm md:text-base text-gray-500 mt-3">Professional-grade beauty technology</p>
    </div>

    <div class="swiper reel-swiper w-full max-w-7xl mx-auto relative">
        <div class="swiper-wrapper">
            
            {{-- We duplicate this slide 5 times so the carousel centers correctly on load --}}
            @for ($i = 0; $i < 5; $i++)
            <div class="swiper-slide w-72 md:w-80 flex flex-col items-center">
                <div class="relative w-full h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg">
                    <img src="https://via.placeholder.com/400x600" alt="Reel thumbnail" class="object-cover w-full h-full opacity-80">
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2 text-white">
                        <button class="bg-black/40 p-2 rounded-full backdrop-blur-sm hover:bg-black/60 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>

                    <div class="absolute bottom-6 left-0 right-0 px-4 text-center">
                        <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-lg backdrop-blur-md">and its short treatment time</span>
                    </div>
                </div>

                <div class="w-[95%] -mt-6 relative z-10 bg-[#f4f4f4] rounded-xl p-3 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-3">
                        <img src="https://via.placeholder.com/50" alt="Product" class="w-12 h-12 rounded bg-white object-cover">
                        <div>
                            <div class="flex items-center gap-1">
                                <h4 class="text-xs font-semibold text-gray-800 leading-tight">LumaLux Face+ | Pro LED Red<br>Light Therapy Face & Neck...</h4>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">PKR 181,900</p>
                        </div>
                    </div>
                    <button class="bg-[#d5c3ba] hover:bg-[#c4b0a6] transition text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </div>
            @endfor

        </div>
        
        <div class="swiper-button-prev !left-4 lg:!left-10"></div>
        <div class="swiper-button-next !right-4 lg:!right-10"></div>
    </div>
</section>

{{-- ABOUT & SERVICES SECTION --}}
<section class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 md:mb-4">Why Choose Us</h2>
            <p class="text-gray-600 text-sm md:text-lg max-w-2xl mx-auto px-2">
                We are a modern beauty studio focused on skincare, makeup, and wellness treatments that bring out your best natural glow.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 md:p-8 rounded-xl">
                <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Advanced Technology</h3>
                <p class="text-gray-600 text-sm md:text-base">FDA-cleared devices and premium formulations for effective results.</p>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 md:p-8 rounded-xl">
                <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-2m0 0H8m4 0v4m0-4v-2m0 2h2m0 0v2m0-2h-2m0 2v4m6-6a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Expert Care</h3>
                <p class="text-gray-600 text-sm md:text-base">Professional guidance and customized skincare routines for your needs.</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 md:p-8 rounded-xl">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Guaranteed Results</h3>
                <p class="text-gray-600 text-sm md:text-base">Visible transformations with our proven beauty solutions.</p>
            </div>
        </div>
    </div>
</section>

{{-- 2. BRAND LOGOS MARQUEE --}}
<section class="bg-[#EAE2DB] py-6 overflow-hidden marquee-container flex cursor-default">
    {{-- First Block --}}
    <div class="animate-marquee items-center gap-12 px-6">
        <span class="text-xl md:text-2xl font-bold tracking-tighter">socioon</span>
        <span class="text-lg md:text-xl font-serif tracking-widest uppercase">VOGUE</span>
        <span class="text-xl md:text-2xl font-serif tracking-[0.3em] uppercase">ELLE</span>
        <span class="text-xl md:text-2xl font-bold tracking-tight text-blue-900">getgroup</span>
        <span class="text-lg md:text-xl font-serif tracking-widest uppercase">BAZAAR</span>
        <span class="text-lg md:text-xl font-bold tracking-tighter lowercase">marie claire</span>
        <span class="text-xl md:text-2xl font-black tracking-tighter">gettechnology</span>
        <span class="text-lg md:text-xl font-serif font-bold uppercase tracking-wider">GLAMOUR</span>
        <span class="text-lg md:text-xl font-black tracking-tighter uppercase">COSMOPOLITAN</span>
    </div>
    
    {{-- Second Block (Duplicated for seamless loop) --}}
    <div class="animate-marquee items-center gap-12 px-6" aria-hidden="true">
        <span class="text-xl md:text-2xl font-bold tracking-tighter">socioon</span>
        <span class="text-lg md:text-xl font-serif tracking-widest uppercase">VOGUE</span>
        <span class="text-xl md:text-2xl font-serif tracking-[0.3em] uppercase">ELLE</span>
        <span class="text-xl md:text-2xl font-bold tracking-tight text-blue-900">getgroup</span>
        <span class="text-lg md:text-xl font-serif tracking-widest uppercase">BAZAAR</span>
        <span class="text-lg md:text-xl font-bold tracking-tighter lowercase">marie claire</span>
        <span class="text-xl md:text-2xl font-black tracking-tighter">gettechnology</span>
        <span class="text-lg md:text-xl font-serif font-bold uppercase tracking-wider">GLAMOUR</span>
        <span class="text-lg md:text-xl font-black tracking-tighter uppercase">COSMOPOLITAN</span>
    </div>
</section>

{{-- 3. THE SKIN EDIT (BLOG/ARTICLES) --}}
<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-light text-gray-800 mb-2">The Skin Edit</h2>
            <p class="text-sm md:text-base text-gray-500 italic font-serif">Your Simplified Skin Bible</p>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Article Card 1 --}}
            <div class="group bg-[#FCFAF8] rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                <div class="h-48 md:h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&h=400&fit=crop" alt="Article 1" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="p-6 md:p-8 flex flex-col flex-grow">
                    <h3 class="text-lg md:text-xl text-gray-800 font-medium mb-4 leading-snug group-hover:text-[#9b1c31] transition-colors">Everything to Consider When Purchasing A Red Light Panel</h3>
                    <p class="text-sm text-gray-600 mb-6 flex-grow leading-relaxed">Red light panels use red and near-infrared light to rejuvenate skin, support recovery, and boost wellness. This guide explores how they work, their key benefits, and what to consider when choosing ...</p>
                    <a href="#" class="text-xs text-gray-800 font-semibold uppercase tracking-wider border-b border-gray-800 w-fit pb-0.5 hover:text-[#9b1c31] hover:border-[#9b1c31] transition-colors">Read more</a>
                </div>
            </div>

            {{-- Article Card 2 --}}
            <div class="group bg-[#FCFAF8] rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                <div class="h-48 md:h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=600&h=400&fit=crop" alt="Article 2" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="p-6 md:p-8 flex flex-col flex-grow">
                    <h3 class="text-lg md:text-xl text-gray-800 font-medium mb-4 leading-snug group-hover:text-[#9b1c31] transition-colors">How To Combine Red Light Therapy With Your Skincare?</h3>
                    <p class="text-sm text-gray-600 mb-6 flex-grow leading-relaxed">Red light therapy and skincare make a powerful duo for achieving radiant, healthy skin. This guide explains what to use before, during, and after your LED session to maximize results — from proper ...</p>
                    <a href="#" class="text-xs text-gray-800 font-semibold uppercase tracking-wider border-b border-gray-800 w-fit pb-0.5 hover:text-[#9b1c31] hover:border-[#9b1c31] transition-colors">Read more</a>
                </div>
            </div>

            {{-- Article Card 3 --}}
            <div class="group bg-[#FCFAF8] rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                <div class="h-48 md:h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1512496015851-a11fb389b4f0?w=600&h=400&fit=crop" alt="Article 3" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <div class="p-6 md:p-8 flex flex-col flex-grow">
                    <h3 class="text-lg md:text-xl text-gray-800 font-medium mb-4 leading-snug group-hover:text-[#9b1c31] transition-colors">What Happens If You Overdo LED Light Therapy?</h3>
                    <p class="text-sm text-gray-600 mb-6 flex-grow leading-relaxed">Red light therapy is everywhere, and fast establishing itself as a relatively safe anti-aging and skin rejuvenation treatment but what are the risks associated with overuse and how can we use our r...</p>
                    <a href="#" class="text-xs text-gray-800 font-semibold uppercase tracking-wider border-b border-gray-800 w-fit pb-0.5 hover:text-[#9b1c31] hover:border-[#9b1c31] transition-colors">Read more</a>
                </div>
            </div>

        </div>

        {{-- View All Button --}}
        <div class="mt-12 text-center">
            <a href="#" class="inline-block bg-[#EBE2D9] text-gray-800 px-8 py-3 rounded-full text-xs font-semibold tracking-widest uppercase hover:bg-[#dfd3c7] transition transform hover:scale-105 active:scale-95 shadow-sm">
                VIEW ALL
            </a>
        </div>

    </div>
</section>

{{-- TESTIMONIALS SECTION --}}
<section class="py-16 md:py-24 bg-[#faf9f8] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block text-sm font-semibold text-amber-600 mb-3 tracking-wider uppercase">Real Results</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-light text-gray-900 mb-4">What Our Clients Say</h2>
            <div class="w-16 h-0.5 bg-amber-600 mx-auto"></div>
        </div>

        {{-- Swiper Container --}}
        <div class="swiper testimonial-swiper pb-12">
            <div class="swiper-wrapper">
                
                {{-- Testimonial 1 --}}
                <div class="swiper-slide h-auto md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col border border-gray-50">
                        <div class="flex gap-1 mb-4 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-6 flex-grow leading-relaxed">"This LED mask completely transformed my skin texture. My fine lines are visibly reduced and my skin has this permanent healthy glow. Worth every penny!"</p>
                        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-100">
                            <img src="https://ui-avatars.com/api/?name=Sarah+M&background=fdf4ff&color=d946ef" alt="Sarah M." class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Sarah M.</h4>
                                <span class="text-xs text-gray-500">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="swiper-slide h-auto md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col border border-gray-50">
                        <div class="flex gap-1 mb-4 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-6 flex-grow leading-relaxed">"I was skeptical at first, but the anti-acne device cleared my hormonal breakouts in just two weeks. It's now a non-negotiable part of my nighttime routine."</p>
                        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-100">
                            <img src="https://ui-avatars.com/api/?name=Emily+R&background=f0fdf4&color=16a34a" alt="Emily R." class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Emily R.</h4>
                                <span class="text-xs text-gray-500">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="swiper-slide h-auto md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col border border-gray-50">
                        <div class="flex gap-1 mb-4 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-6 flex-grow leading-relaxed">"Professional grade results at home. I actually cancelled my monthly clinic appointments because this device maintains my skin beautifully."</p>
                        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-100">
                            <img src="https://ui-avatars.com/api/?name=Jessica+T&background=eff6ff&color=2563eb" alt="Jessica T." class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Jessica T.</h4>
                                <span class="text-xs text-gray-500">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 4 --}}
                <div class="swiper-slide h-auto md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col border border-gray-50">
                        <div class="flex gap-1 mb-4 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-6 flex-grow leading-relaxed">"The best investment I've made for my skincare routine. It's so relaxing to use while watching TV, and the anti-aging benefits are undeniable."</p>
                        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-100">
                            <img src="https://ui-avatars.com/api/?name=Amanda+K&background=fffbeb&color=d97706" alt="Amanda K." class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Amanda K.</h4>
                                <span class="text-xs text-gray-500">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 5 --}}
                <div class="swiper-slide h-auto md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full flex flex-col border border-gray-50">
                        <div class="flex gap-1 mb-4 text-amber-400">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic mb-6 flex-grow leading-relaxed">"I've been using this for 3 months and the hyperpigmentation on my cheeks has faded significantly. My makeup goes on so much smoother now."</p>
                        <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-100">
                            <img src="https://ui-avatars.com/api/?name=Rachel+B&background=fef2f2&color=dc2626" alt="Rachel B." class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Rachel B.</h4>
                                <span class="text-xs text-gray-500">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Pagination Dots --}}
            <div class="swiper-pagination !-bottom-2"></div>
        </div>
    </div>

    {{-- 1. FEATURES / BENEFITS STRIP --}}
<section class="py-10 bg-white border-t border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-gray-100">
            
            {{-- Feature 1 --}}
            <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                <svg class="w-8 h-8 text-[#9b1c31] mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium">Free Delivery on Orders Rs.43,000+</p>
            </div>

            {{-- Feature 2 --}}
            <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                <svg class="w-8 h-8 text-[#9b1c31] mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium">60-Day Trial</p>
            </div>

            {{-- Feature 3 --}}
            <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                <svg class="w-8 h-8 text-[#9b1c31] mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium">12 Years Leading LED Innovation Globally</p>
            </div>

            {{-- Feature 4 --}}
            <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                <svg class="w-8 h-8 text-[#9b1c31] mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium">Transformed 500,000+ Skincare Routines</p>
            </div>

        </div>
    </div>
</section>

</section>
{{-- SWIPER JS INIT --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.reel-swiper', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: { slidesPerView: 1.2, spaceBetween: 10 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            }
        });
    });
    // Initialize Testimonial Swiper
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3500, // Slides every 3.5 seconds
            disableOnInteraction: false, // Keeps playing even if the user clicks
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            // Mobile: 1 card
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            // Tablet: 2 cards side-by-side
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            // Desktop: 3 cards side-by-side
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        }
    });
</script>

@endsection