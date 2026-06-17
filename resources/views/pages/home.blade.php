@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
    $homepageLayout = \App\Models\StoreSetting::getHomepageLayout();
    $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
    $isTheme2 = ($homepageTheme === 'theme_2');
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
    @media (min-width: 768px) {
        .reel-swiper .swiper-slide {
            opacity: 1 !important;
            transform: scale(1) !important;
        }
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
    .swiper-button-disabled {
        display: none !important;
    }
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
    
    /* Theme 2 Luxury Custom styles */
    .theme-2-glow {
        box-shadow: 0 0 40px -5px rgba(245, 158, 11, 0.15);
    }
    .theme-2-card {
        background: rgba(18, 18, 24, 0.6) !important;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .theme-2-card:hover {
        border-color: rgba(245, 158, 11, 0.3) !important;
        box-shadow: 0 20px 40px -15px rgba(245, 158, 11, 0.2) !important;
    }

    /* Bestseller swiper custom styling */
    .bestseller-swiper .swiper-scrollbar {
        height: 4px;
        background: #e2e8f0;
        border-radius: 0;
        position: relative;
        margin-top: 30px;
        bottom: auto;
        left: auto;
        width: 100%;
    }
    .bestseller-swiper .swiper-scrollbar-drag {
        background: #0f172a;
        border-radius: 0;
    }
    .theme-2 .bestseller-swiper .swiper-scrollbar-drag {
        background: #f59e0b;
    }
    .theme-2 .bestseller-swiper .swiper-scrollbar {
        background: rgba(255,255,255,0.05);
    }
    .bestseller-prev, .bestseller-next {
        color: #0f172a !important;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        margin-top: -40px;
    }
    .theme-2 .bestseller-prev, .theme-2 .bestseller-next {
        background: #121218;
        border-color: rgba(255,255,255,0.05);
        color: #f59e0b !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .bestseller-prev:hover, .bestseller-next:hover {
        background: #0f172a;
        color: #fff !important;
        border-color: #0f172a;
        transform: scale(1.05);
    }
    .theme-2 .bestseller-prev:hover, .theme-2 .bestseller-next:hover {
        background: #f59e0b;
        color: #0f172a !important;
        border-color: #f59e0b;
    }
    .bestseller-prev:after, .bestseller-next:after {
        font-size: 16px !important;
        font-weight: bold;
    }
</style>

<div class="{{ $isTheme2 ? 'theme-2 bg-[#0c0c0e] text-[#f3e8ff]' : '' }}">

@foreach($homepageLayout as $section)
    @if($section['visible'])
        
        @if($section['id'] === 'hero')
            {{-- HERO SECTION --}}
            @php
                $heroTitle = \App\Models\StoreSetting::getValue('hero_title', 'SEMI-ANNUAL SALE');
                $heroSubtitle = \App\Models\StoreSetting::getValue('hero_subtitle', 'Science Your Skin Deserves');
                $heroMediaType = \App\Models\StoreSetting::getValue('hero_media_type', 'image');
                $heroMediaPath = \App\Models\StoreSetting::getValue('hero_media_path');
                
                $activeMode = \App\Models\StoreSetting::getValue('hero_active_mode', 'default');
                $isSliderActive = ($activeMode === 'slider');
                $sliderMedia = [];
                $sliderInterval = 20000; // default 20s

                if ($isSliderActive) {
                    $sliderMedia = \App\Models\HeroSlider::orderBy('sort_order')->get();
                    $sliderInterval = (int)\App\Models\StoreSetting::getValue('hero_slider_interval', 20) * 1000;
                }

                $heroUrl = $heroMediaPath 
                    ? asset('storage/' . $heroMediaPath) 
                    : 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1400&h=700&fit=crop';
            @endphp
            <section class="relative min-h-screen md:h-[600px] lg:h-[700px] overflow-hidden border-b {{ $isTheme2 ? 'border-white/5' : 'border-transparent' }}">
                {{-- Background Media --}}
                <div class="absolute inset-0 z-0">
                    @if($isSliderActive && $sliderMedia->isNotEmpty())
                        <!-- Swiper Slider for Scheduled Media -->
                        <div class="swiper hero-bg-swiper w-full h-full">
                            <div class="swiper-wrapper">
                                @foreach($sliderMedia as $media)
                                    <div class="swiper-slide relative">
                                        @if($media->type === 'video')
                                            <video autoplay loop muted playsinline class="w-full h-full object-cover object-center">
                                                <source src="{{ asset('storage/' . $media->media_path) }}" type="video/mp4">
                                            </video>
                                        @else
                                            <img src="{{ asset('storage/' . $media->media_path) }}" class="w-full h-full object-cover object-center">
                                        @endif
                                        <div class="absolute inset-0 bg-black/40"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                new Swiper('.hero-bg-swiper', {
                                    loop: true,
                                    effect: 'fade',
                                    fadeEffect: {
                                        crossFade: true
                                    },
                                    autoplay: {
                                        delay: {{ $sliderInterval }},
                                        disableOnInteraction: false,
                                    },
                                    allowTouchMove: false
                                });
                            });
                        </script>
                    @else
                        <!-- Default Single Hero Media -->
                        @if($heroMediaType === 'video')
                            <video autoplay loop muted playsinline class="w-full h-full object-cover object-center">
                                <source src="{{ $heroUrl }}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-black/40"></div>
                        @else
                            <img src="{{ $heroUrl }}" alt="LED Light Therapy Hero" class="w-full h-full object-cover object-center">
                            <div class="absolute inset-0 {{ $isTheme2 ? 'bg-black/40' : 'bg-black/20' }}"></div>
                        @endif
                    @endif
                </div>

                {{-- Content --}}
                <div class="relative z-10 h-full flex items-center justify-center md:justify-start">
                    <div class="max-w-7xl w-full mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-0">
                        <div class="max-w-xl">
                            {{-- Main Heading --}}
                            <h1 class="text-4xl sm:text-5xl md:text-5xl lg:text-7xl font-bold text-white mb-2 md:mb-3 leading-tight tracking-wide {{ $isTheme2 ? 'drop-shadow-[0_2px_10px_rgba(245,158,11,0.2)]' : '' }}">
                                {!! nl2br(e($heroTitle)) !!}
                            </h1>

                            {{-- Subtitle --}}
                            <p class="text-base sm:text-lg md:text-lg lg:text-xl {{ $isTheme2 ? 'text-amber-400 font-medium' : 'text-gray-100 font-light' }} mb-4 md:mb-6 tracking-wide">
                                {{ $heroSubtitle }}
                            </p>

                            {{-- Offers --}}
                            <div class="space-y-1 md:space-y-2 mb-6 md:mb-8">
                                <p class="text-sm md:text-base text-white font-semibold">BUY 1 | 10% OFF</p>
                                <p class="text-sm md:text-base text-white font-semibold">BUY 2 | 20% OFF</p>
                            </div>

                            {{-- CTA Button --}}
                            <a href="{{ route('products.all') }}" class="inline-flex items-center gap-2 {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 text-slate-950 hover:shadow-lg hover:shadow-amber-500/20' : 'bg-white text-gray-900 hover:bg-gray-100' }} px-6 sm:px-8 py-2.5 sm:py-3.5 rounded-full font-bold transition text-sm sm:text-base uppercase tracking-wider touch-none active:bg-gray-200">
                                SHOP THE SALE
                                <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        
        @elseif($section['id'] === 'complete_routine')
            {{-- COMPLETE ROUTINE SECTION --}}
            @php
                $routineProductImage = \App\Models\StoreSetting::getValue('routine_product_image_path');
                $routineProductUrl = $routineProductImage ? asset('storage/' . $routineProductImage) : asset('images/complete-routine-placeholder.png');
                $routineLifestyleImage = \App\Models\StoreSetting::getValue('routine_lifestyle_image_path');
                $routineLifestyleUrl = $routineLifestyleImage ? asset('storage/' . $routineLifestyleImage) : asset('images/lifestyle-placeholder.jpg');
            @endphp
            <section class="w-full">
                <div class="flex flex-col md:flex-row w-full h-auto md:h-[600px]">
                    <!-- Left Side: Product Set -->
                    <div class="w-full md:w-1/2 {{ $isTheme2 ? 'bg-[#0a0a0c] border-r border-white/5' : 'bg-[#e6e2f1]' }} flex flex-col justify-center items-center p-12 relative overflow-hidden" 
                         style="{{ $isTheme2 ? 'background: radial-gradient(circle at center, rgba(245,158,11,0.06) 0%, rgba(10,10,12,0) 75%), #0a0a0c;' : '' }}">
                        
                        <img src="{{ $routineProductUrl }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80';" alt="Complete Glow Up Set" class="w-[80%] max-w-sm object-contain z-10 drop-shadow-2xl mix-blend-multiply transition-transform duration-700 hover:scale-105 filter {{ $isTheme2 ? 'brightness-110 contrast-105' : '' }}">
                        
                        <div class="mt-8 text-center z-10">
                            <h3 class="text-xl font-serif {{ $isTheme2 ? 'text-white' : 'text-slate-800' }} mb-2 font-medium">The Complete Glow Up Set</h3>
                            <p class="text-lg font-semibold {{ $isTheme2 ? 'text-amber-400' : 'text-slate-900' }}">$199.00</p>
                            
                            <div class="flex justify-center gap-2 mt-4">
                                <span class="w-2 h-2 rounded-full {{ $isTheme2 ? 'bg-slate-700' : 'bg-slate-300' }}"></span>
                                <span class="w-2 h-2 rounded-full {{ $isTheme2 ? 'bg-amber-500' : 'bg-slate-800' }}"></span>
                                <span class="w-2 h-2 rounded-full {{ $isTheme2 ? 'bg-slate-700' : 'bg-slate-300' }}"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Lifestyle Image -->
                    <div class="w-full md:w-1/2 relative flex items-center justify-center p-12 h-[400px] md:h-full overflow-hidden group">
                        <img src="{{ $routineLifestyleUrl }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1000&q=80';" alt="Skincare Routine" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t {{ $isTheme2 ? 'from-black/80 via-black/40' : 'from-black/60 via-black/20' }} to-transparent"></div>
                        
                        <div class="relative z-10 text-left w-full mt-auto">
                            <h2 class="text-4xl md:text-5xl lg:text-6xl font-serif font-medium {{ $isTheme2 ? 'text-[#c5a880]' : 'text-white' }} leading-tight drop-shadow-md">
                                Complete Routine in <br>One Set
                            </h2>
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section['id'] === 'categories')
            {{-- CATEGORIES SECTION --}}
            <section id="categories" class="py-12 md:py-20 {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="text-center mb-8 md:mb-12 reveal-on-scroll">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-2 md:mb-4">Featured Collections</h2>
                        <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-600' }} text-sm md:text-lg">Discover our premium skincare & beauty devices</p>
                    </div>

                    @if($featuredCategories->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <p>Featured categories coming soon.</p>
                        </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 reveal-on-scroll">
                        @foreach($featuredCategories as $category)
                        <div class="relative rounded-[2rem] overflow-hidden cursor-pointer hover:shadow-xl transition-all duration-300 group h-[400px] border {{ $isTheme2 ? 'border-white/5 hover:border-amber-500/30' : 'border-transparent' }}">
                            <img src="{{ ImageHelper::getCategoryImage($category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <div class="absolute inset-0 {{ $isTheme2 ? 'bg-black/40 backdrop-blur-[1px]' : 'bg-black/20' }} flex flex-col items-center justify-center p-6 text-center">
                                <h3 class="text-2xl font-semibold text-white mb-6 tracking-wide drop-shadow-md uppercase {{ $isTheme2 ? 'text-amber-400' : '' }}">
                                    {{ $category->name }}
                                </h3>
                                
                                <a href="{{ route('products.all', ['categories' => [$category->id]]) }}" 
                                   class="{{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md shadow-amber-500/10 hover:shadow-lg hover:shadow-amber-500/20' : 'bg-[#FDF9F5] text-[#4A4A4A] hover:bg-white' }} px-8 py-3 rounded-full font-bold text-sm tracking-widest transition-all duration-300">
                                    SHOP NOW
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>

        @elseif($section['id'] === 'products')
            {{-- PRODUCTS SECTION --}}
            <section class="py-16 md:py-24 relative overflow-hidden {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : '' }}">
                {{-- Animated Background Gradient --}}
                @if(!$isTheme2)
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-slate-50 -z-10"></div>
                    <div class="absolute top-0 right-0 w-96 h-96 bg-pink-200/20 rounded-full blur-3xl -z-10 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl -z-10 animate-pulse animation-delay-2000"></div>
                @else
                    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl -z-10"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500/5 rounded-full blur-3xl -z-10"></div>
                @endif

                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    {{-- Section Header --}}
                    <div class="text-center mb-12 md:mb-16 reveal-on-scroll">
                        <span class="inline-block text-sm font-semibold {{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} mb-3 tracking-wider uppercase">Premium Selection</span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">Bestselling Products</h2>
                        <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-600' }} text-base md:text-lg max-w-2xl mx-auto">Discover our most loved beauty and skincare devices trusted by thousands</p>
                    </div>

                    {{-- Products Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8 mb-12 reveal-on-scroll">
                        @foreach($bestsellingProducts as $index => $product)
                        <div class="product-card group cursor-pointer animation-delay-{{ $index * 100 }}">
                            {{-- Card Container --}}
                            <div class="relative h-full rounded-3xl overflow-hidden {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5' : 'bg-white shadow-lg' }} hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                                {{-- Product Image Container --}}
                                <a href="{{ route('product.detail', $product->id) }}" class="block relative bg-gradient-to-br from-slate-100 to-slate-200 h-72 sm:h-80 md:h-96 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/0 group-hover:from-black/30 transition duration-500"></div>
                                    <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">

                                    @if($product->compare_price && $product->compare_price > $product->price)
                                    <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg transform transition-transform duration-300 hover:scale-110">
                                        Sale
                                    </div>
                                    @endif

                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="text-white text-center">
                                            <svg class="w-16 h-16 mx-auto mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                {{-- Product Info --}}
                                <div class="p-5 sm:p-6">
                                    <span class="inline-block text-xs font-semibold {{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} mb-2 uppercase tracking-wider">Product</span>
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <h3 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-sm sm:text-base line-clamp-2 mb-2.5 leading-tight group-hover:text-amber-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                    </a>

                                    <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} text-xs sm:text-sm leading-relaxed mb-4 line-clamp-2">
                                        {{ $product->description ?? 'Premium quality product.' }}
                                    </p>

                                    <div class="mb-4 pb-4 border-b {{ $isTheme2 ? 'border-white/5' : 'border-gray-100' }}">
                                        <div class="flex items-baseline gap-2 mb-1">
                                            @if($product->compare_price && $product->compare_price > $product->price)
                                                <span class="text-xl sm:text-2xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }}">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                                <span class="text-xs text-gray-400 line-through">{{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}</span>
                                                @if($product->discount_price && (float)$product->discount_price > 0)
                                                    <span class="text-xs font-bold text-green-600">Save {{ \App\Helpers\CurrencyHelper::format($product->discount_price) }}</span>
                                                @else
                                                    <span class="text-xs font-bold text-green-600">{{ round((1 - $product->price/$product->compare_price) * 100) }}% OFF</span>
                                                @endif
                                            @else
                                                <span class="text-xl sm:text-2xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }}">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <a href="{{ route('product.detail', $product->id) }}" class="block w-full bg-gradient-to-r {{ $isTheme2 ? 'from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-amber-500/10' : 'from-amber-600 to-orange-600 text-white hover:from-amber-700 hover:to-orange-700 shadow-md' }} text-center py-3 px-4 rounded-xl font-bold text-sm sm:text-base uppercase tracking-wider transition-all duration-300 transform hover:scale-105 active:scale-95 hover:shadow-lg group/btn relative overflow-hidden">
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Product
                                        </span>
                                        <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover/btn:translate-x-full transition-transform duration-500"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        <a href="{{ route('products.all') }}" class="inline-flex items-center gap-3 {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-amber-500/10' : 'bg-gradient-to-r from-gray-900 to-gray-800 text-white hover:from-gray-850 hover:to-gray-750' }} px-8 md:px-10 py-3.5 md:py-4 rounded-full font-bold text-base md:text-lg uppercase tracking-wider transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl group">
                            View All Products
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                @if(isset($hotDealProducts) && $hotDealProducts->isNotEmpty())
                    @php
                        $featuredHotDeal = $hotDealProducts->first();
                        $featuredSale = $featuredHotDeal->price;
                        $featuredCompare = $featuredHotDeal->compare_price;
                        $featuredSavings = ($featuredCompare && $featuredCompare > $featuredSale) ? ($featuredHotDeal->discount_price && (float)$featuredHotDeal->discount_price > 0 ? (float)$featuredHotDeal->discount_price : $featuredCompare - $featuredSale) : 0;
                    @endphp
                    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 mt-16">
                        <div class="fade-up relative rounded-[2rem] {{ $isTheme2 ? 'bg-slate-950 border border-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.3)]' : 'bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]' }} overflow-hidden group">
                            <div class="flex flex-col lg:flex-row items-center">
                                <div class="w-full lg:w-1/2 p-10 md:p-16 relative z-10">
                                    <span class="{{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} text-xs font-bold tracking-widest uppercase mb-4 block">Master Collection</span>
                                    <h2 class="text-4xl md:text-5xl font-light mb-6 {{ $isTheme2 ? 'text-white' : 'text-slate-900' }}">
                                        The Clinical <br><span class="italic font-serif {{ $isTheme2 ? 'text-slate-300' : 'text-slate-700' }}">Renewal Bundle</span>
                                    </h2>
                                    <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-slate-500' }} leading-relaxed mb-10 max-w-md font-light">
                                        {{ $featuredHotDeal->description ?? 'Our highest-tier LED mask paired with the potent 24K gold serum. A complete clinical protocol for unprecedented cellular rejuvenation.' }}
                                    </p>
                                    <div class="flex items-end gap-6 mb-10">
                                        <div>
                                            @if($featuredCompare && $featuredCompare > $featuredSale)
                                                <span class="{{ $isTheme2 ? 'text-slate-500' : 'text-slate-400' }} line-through text-sm block mb-1">Standard Price {{ \App\Helpers\CurrencyHelper::format($featuredCompare) }}</span>
                                            @endif
                                            <span class="text-5xl font-bold {{ $isTheme2 ? 'text-amber-400' : 'text-slate-900' }}">{{ \App\Helpers\CurrencyHelper::format($featuredSale) }}</span>
                                        </div>
                                        @if($featuredSavings > 0)
                                        <div class="{{ $isTheme2 ? 'bg-amber-950/20 border border-amber-500/20' : 'bg-red-50 border border-red-100' }} px-4 py-2 rounded-lg">
                                            <span class="{{ $isTheme2 ? 'text-amber-500' : 'text-red-600' }} font-bold tracking-wider uppercase text-xs">You Save {{ \App\Helpers\CurrencyHelper::format($featuredSavings) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.detail', $featuredHotDeal->slug) }}"
                                       class="inline-block {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950' : 'bg-slate-900 text-white hover:bg-slate-800' }} px-10 py-4 rounded-xl text-sm font-bold tracking-[0.2em] uppercase hover:scale-105 hover:shadow-xl transition-all duration-300">
                                        Claim Offer
                                    </a>
                                </div>
                                <div class="w-full lg:w-1/2 relative h-[400px] lg:h-[500px] flex items-center justify-center p-10 {{ $isTheme2 ? 'bg-slate-900/30' : 'bg-slate-50/50' }}">
                                    <div class="absolute w-[300px] h-[300px] {{ $isTheme2 ? 'bg-gradient-to-tr from-amber-500/10 to-transparent' : 'bg-gradient-to-tr from-amber-200/40 to-red-100/40' }} rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                                    @if($featuredHotDeal->cover_image || $featuredHotDeal->image)
                                        <img src="{{ asset('storage/' . ($featuredHotDeal->cover_image ?? $featuredHotDeal->image)) }}"
                                             alt="{{ $featuredHotDeal->name }}"
                                             class="relative z-10 w-full max-w-[400px] h-full object-contain drop-shadow-2xl">
                                    @else
                                        <img src="{{ asset('images/categories/hero-deal.jpg') }}"
                                             alt="{{ $featuredHotDeal->name }}"
                                             class="relative z-10 w-full max-w-[400px] object-contain drop-shadow-2xl">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </section>

        @elseif($section['id'] === 'reels')
            {{-- PROFESSIONAL REELS SECTION --}}
            <section class="py-16 {{ $isTheme2 ? 'bg-[#08080a] border-b border-white/5' : 'bg-white' }} overflow-hidden">
                <div class="text-center mb-10 px-4">
                    <h2 class="text-3xl md:text-4xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-800' }}">Used by the professionals, approved by the professionals</h2>
                    <p class="text-sm md:text-base {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} mt-3">Professional-grade beauty technology</p>
                </div>

                @if($reels->isNotEmpty() && $reels->count() < 3)
                    {{-- Centered Flex Layout for 1-2 Reels --}}
                    <div class="flex flex-wrap justify-center gap-6 max-w-7xl mx-auto px-4 relative">
                        @foreach ($reels as $reel)
                        <div class="w-64 sm:w-72 md:w-80 flex flex-col items-center group/slide reel-card-item">
                            <div class="relative w-full h-[360px] sm:h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg cursor-pointer">
                                <video src="{{ asset('storage/' . $reel->video_path) }}" 
                                       @if($reel->thumbnail_path) poster="{{ asset('storage/' . $reel->thumbnail_path) }}" @endif 
                                       class="reel-video object-cover w-full h-full opacity-80" 
                                       loop 
                                       muted 
                                       playsinline>
                                </video>
                                
                                {{-- Play/Pause overlay icon on click/hover --}}
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="play-btn bg-black/50 p-4 rounded-full text-white opacity-0 group-hover/slide:opacity-100 transition duration-300">
                                        <svg class="w-8 h-8 play-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        <svg class="w-8 h-8 pause-icon hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                    </div>
                                </div>

                                <div class="absolute top-4 right-4 flex flex-col gap-2 text-white z-20">
                                    <button class="mute-btn bg-black/40 p-2 rounded-full backdrop-blur-sm hover:bg-black/60 transition pointer-events-auto">
                                        <svg class="w-4 h-4 mute-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <svg class="w-4 h-4 sound-icon hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>

                                @if($reel->caption)
                                <div class="absolute bottom-6 left-0 right-0 px-4 text-center z-10">
                                    <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-lg backdrop-blur-md inline-block max-w-[90%] truncate">
                                        {{ $reel->caption }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            @if($reel->product)
                            <div class="w-[95%] -mt-6 relative z-10 {{ $isTheme2 ? 'bg-slate-900 border border-white/5 text-slate-200' : 'bg-[#f4f4f4]' }} rounded-xl p-3 flex items-center justify-between shadow-md">
                                <div class="flex items-center gap-3">
                                    @if($reel->product->cover_image || $reel->product->image)
                                        <img src="{{ asset('storage/' . ($reel->product->cover_image ?? $reel->product->image)) }}" alt="{{ $reel->product->name }}" class="w-12 h-12 rounded bg-white object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded bg-white flex items-center justify-center text-xs text-gray-400">No image</div>
                                    @endif
                                    <div class="text-left">
                                        <div class="flex items-center gap-1">
                                            <h4 class="text-xs font-semibold leading-tight line-clamp-2" title="{{ $reel->product->name }}">
                                                {{ $reel->product->name }}
                                            </h4>
                                        </div>
                                        <p class="text-xs {{ $isTheme2 ? 'text-amber-400' : 'text-gray-600' }} mt-1">{{ \App\Helpers\CurrencyHelper::format($reel->product->price) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('product.detail', $reel->product->id) }}" class="{{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600' : 'bg-[#d5c3ba] hover:bg-[#c4b0a6]' }} transition text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="swiper reel-swiper w-full max-w-7xl mx-auto relative">
                        <div class="swiper-wrapper">
                            
                            @forelse ($reels as $reel)
                            <div class="swiper-slide w-64 sm:w-72 md:w-80 flex flex-col items-center group/slide reel-card-item">
                                <div class="relative w-full h-[360px] sm:h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg cursor-pointer">
                                    <video src="{{ asset('storage/' . $reel->video_path) }}" 
                                           @if($reel->thumbnail_path) poster="{{ asset('storage/' . $reel->thumbnail_path) }}" @endif 
                                           class="reel-video object-cover w-full h-full opacity-80" 
                                           loop 
                                           muted 
                                           playsinline>
                                    </video>
                                    
                                    {{-- Play/Pause overlay icon on click/hover --}}
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="play-btn bg-black/50 p-4 rounded-full text-white opacity-0 group-hover/slide:opacity-100 transition duration-300">
                                            <svg class="w-8 h-8 play-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            <svg class="w-8 h-8 pause-icon hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute top-4 right-4 flex flex-col gap-2 text-white z-20">
                                        <button class="mute-btn bg-black/40 p-2 rounded-full backdrop-blur-sm hover:bg-black/60 transition pointer-events-auto">
                                            <svg class="w-4 h-4 mute-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <svg class="w-4 h-4 sound-icon hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>

                                    @if($reel->caption)
                                    <div class="absolute bottom-6 left-0 right-0 px-4 text-center z-10">
                                        <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-lg backdrop-blur-md inline-block max-w-[90%] truncate">
                                            {{ $reel->caption }}
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                @if($reel->product)
                                <div class="w-[95%] -mt-6 relative z-10 {{ $isTheme2 ? 'bg-slate-900 border border-white/5 text-slate-200' : 'bg-[#f4f4f4]' }} rounded-xl p-3 flex items-center justify-between shadow-md">
                                    <div class="flex items-center gap-3">
                                        @if($reel->product->cover_image || $reel->product->image)
                                            <img src="{{ asset('storage/' . ($reel->product->cover_image ?? $reel->product->image)) }}" alt="{{ $reel->product->name }}" class="w-12 h-12 rounded bg-white object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded bg-white flex items-center justify-center text-xs text-gray-400">No image</div>
                                        @endif
                                        <div class="text-left">
                                            <div class="flex items-center gap-1">
                                                <h4 class="text-xs font-semibold leading-tight line-clamp-2" title="{{ $reel->product->name }}">
                                                    {{ $reel->product->name }}
                                                </h4>
                                            </div>
                                            <p class="text-xs {{ $isTheme2 ? 'text-amber-400' : 'text-gray-600' }} mt-1">{{ \App\Helpers\CurrencyHelper::format($reel->product->price) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('product.detail', $reel->product->id) }}" class="{{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600' : 'bg-[#d5c3ba] hover:bg-[#c4b0a6]' }} transition text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                            @empty
                                @for ($i = 0; $i < 5; $i++)
                                <div class="swiper-slide w-72 md:w-80 flex flex-col items-center reel-card-item">
                                    <div class="relative w-full h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400&h=600&fit=crop" alt="Reel thumbnail" class="object-cover w-full h-full opacity-80">
                                        <div class="absolute bottom-6 left-0 right-0 px-4 text-center">
                                            <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-lg backdrop-blur-md">Used by the professionals</span>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            @endforelse

                        </div>
                        
                        <div class="swiper-button-prev !left-4 lg:!left-10"></div>
                        <div class="swiper-button-next !right-4 lg:!right-10"></div>
                    </div>
                @endif
            </section>

        @elseif($section['id'] === 'brand_marquee')
            {{-- BRAND LOGOS MARQUEE --}}
            <section class="{{ $isTheme2 ? 'bg-[#0d0d0f] border-t border-b border-amber-500/20 text-[#c5a880]/80' : 'bg-[#EAE2DB] text-gray-800' }} py-6 overflow-hidden marquee-container flex cursor-default">
                {{-- First Block --}}
                <div class="animate-marquee items-center gap-12 px-6">
                    <span class="text-xl md:text-2xl font-bold tracking-tighter">socioon</span>
                    <span class="text-lg md:text-xl font-serif tracking-widest uppercase">VOGUE</span>
                    <span class="text-xl md:text-2xl font-serif tracking-[0.3em] uppercase">ELLE</span>
                    <span class="text-xl md:text-2xl font-bold tracking-tight {{ $isTheme2 ? 'text-amber-500' : 'text-blue-900' }}">getgroup</span>
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
                    <span class="text-xl md:text-2xl font-bold tracking-tight {{ $isTheme2 ? 'text-amber-500' : 'text-blue-900' }}">getgroup</span>
                    <span class="text-lg md:text-xl font-serif tracking-widest uppercase">BAZAAR</span>
                    <span class="text-lg md:text-xl font-bold tracking-tighter lowercase">marie claire</span>
                    <span class="text-xl md:text-2xl font-black tracking-tighter">gettechnology</span>
                    <span class="text-lg md:text-xl font-serif font-bold uppercase tracking-wider">GLAMOUR</span>
                    <span class="text-lg md:text-xl font-black tracking-tighter uppercase">COSMOPOLITAN</span>
                </div>
            </section>

        @elseif($section['id'] === 'skin_edit')
            {{-- THE SKIN EDIT (BLOG/ARTICLES) --}}
            @php
                $articles = [
                    1 => [
                        'default_title' => 'Everything to Consider When Purchasing A Red Light Panel',
                        'default_text' => 'Red light panels use red and near-infrared light to rejuvenate skin, support recovery, and boost wellness. This guide explores how they work, their key benefits, and what to consider when choosing ...',
                        'default_image' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&h=400&fit=crop',
                        'default_link' => '#'
                    ],
                    2 => [
                        'default_title' => 'How To Combine Red Light Therapy With Your Skincare?',
                        'default_text' => 'Red light therapy and skincare make a powerful duo for achieving radiant, healthy skin. This guide explains what to use before, during, and after your LED session to maximize results — from proper ...',
                        'default_image' => 'https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=600&h=400&fit=crop',
                        'default_link' => '#'
                    ],
                    3 => [
                        'default_title' => 'What Happens If You Overdo LED Light Therapy?',
                        'default_text' => 'Red light therapy is everywhere, and fast establishing itself as a relatively safe anti-aging and skin rejuvenation treatment but what are the risks associated with overuse and how can we use our r...',
                        'default_image' => 'https://images.unsplash.com/photo-1512496015851-a11fb389b4f0?w=600&h=400&fit=crop',
                        'default_link' => '#'
                    ]
                ];
            @endphp
            <section class="py-16 md:py-24 {{ $isTheme2 ? 'bg-[#0a0a0c] border-b border-white/5' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    
                    {{-- Header --}}
                    <div class="text-center mb-12 reveal-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-800' }} mb-2">Our Products For Daily Use</h2>
                        <p class="text-sm md:text-base {{ $isTheme2 ? 'text-amber-400' : 'text-gray-500' }} italic font-serif">Your Simplified routine Bible</p>
                    </div>

                    {{-- Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-on-scroll">
                        @foreach($articles as $i => $data)
                            @php
                                $customTitle = \App\Models\StoreSetting::getValue("article_{$i}_title");
                                $customText = \App\Models\StoreSetting::getValue("article_{$i}_text");
                                $customLink = \App\Models\StoreSetting::getValue("article_{$i}_link");
                                $customImagePath = \App\Models\StoreSetting::getValue("article_{$i}_image_path");

                                $title = $customTitle ?: $data['default_title'];
                                $text = $customText ?: $data['default_text'];
                                $link = $customLink ?: $data['default_link'];
                                $imageUrl = $customImagePath ? asset('storage/' . $customImagePath) : $data['default_image'];
                            @endphp
                            
                            {{-- Article Card {{ $i }} --}}
                            <div onclick="window.location.href='{{ $link }}'" class="group {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5 hover:border-amber-500/30' : 'bg-[#FCFAF8] hover:shadow-xl' }} rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                                <div class="h-48 md:h-56 overflow-hidden">
                                    <img src="{{ $imageUrl }}" onerror="this.onerror=null; this.src='{{ $data['default_image'] }}';" alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                                <div class="p-6 md:p-8 flex flex-col flex-grow">
                                    <h3 class="text-lg md:text-xl {{ $isTheme2 ? 'text-slate-200' : 'text-gray-800' }} font-medium mb-4 leading-snug group-hover:text-amber-500 transition-colors">{{ $title }}</h3>
                                    <p class="text-sm {{ $isTheme2 ? 'text-slate-400' : 'text-gray-600' }} mb-6 flex-grow leading-relaxed">{{ $text }}</p>
                                    <a href="{{ $link }}" class="text-xs {{ $isTheme2 ? 'text-amber-500 border-amber-500' : 'text-gray-800 border-gray-800' }} font-semibold uppercase tracking-wider border-b w-fit pb-0.5 hover:text-amber-600 transition-colors">Read more</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- View All Button --}}
                    <div class="mt-12 text-center">
                        <a href="#" class="inline-block {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-bold hover:shadow-lg hover:shadow-amber-500/10' : 'bg-[#EBE2D9] text-gray-800 hover:bg-[#dfd3c7]' }} px-8 py-3 rounded-full text-xs font-semibold tracking-widest uppercase transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-sm">
                            VIEW ALL
                        </a>
                    </div>

                </div>
            </section>

        @elseif($section['id'] === 'why_choose_us')
            {{-- PREMIUM WHY CHOOSE US SECTION --}}
            <section class="py-24 {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : 'bg-white' }} overflow-hidden">
                <div class="max-w-6xl mx-auto px-6">
                    <div class="text-center mb-20 reveal-on-scroll">
                        <span class="text-[10px] font-bold uppercase tracking-[0.4em] {{ $isTheme2 ? 'text-amber-500' : 'text-blue-800' }} mb-4 block">{{ \App\Models\StoreSetting::getValue('why_choose_us_subtitle', 'Our Philosophy') }}</span>
                        <h2 class="text-4xl md:text-6xl font-serif {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-6">{{ \App\Models\StoreSetting::getValue('why_choose_us_title', 'Why Choose Us') }}</h2>
                        <div class="h-[1px] w-12 {{ $isTheme2 ? 'bg-amber-500' : 'bg-blue-800' }} mx-auto"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 reveal-on-scroll">
                        
                        {{-- Card 1 --}}
                        <div class="group relative p-10 {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5 hover:border-amber-500/30' : 'bg-white border border-gray-200' }} shadow-sm rounded-[2rem] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                            <div class="mb-8 w-16 h-16 flex items-center justify-center rounded-2xl {{ $isTheme2 ? 'bg-amber-500/10 text-amber-500 shadow-inner' : 'bg-pink-50 text-pink-500' }} group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_title', 'Advanced Tech') }}</h3>
                            <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} leading-relaxed">{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_desc', 'FDA-cleared devices and premium formulations engineered for visible results.') }}</p>
                        </div>

                        {{-- Card 2 --}}
                        <div class="group relative p-10 {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5 hover:border-amber-500/30' : 'bg-white border border-gray-200' }} shadow-sm rounded-[2rem] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                            <div class="mb-8 w-16 h-16 flex items-center justify-center rounded-2xl {{ $isTheme2 ? 'bg-amber-500/10 text-amber-500 shadow-inner' : 'bg-amber-50 text-amber-500' }} group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10h-2m0 0H8m4 0v4m0-4v-2m0 2h2m0 0v2m0-2h-2m0 2v4m6-6a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_title', 'Expert Care') }}</h3>
                            <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} leading-relaxed">{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_desc', 'Professional guidance and fully customized skincare routines for your unique needs.') }}</p>
                        </div>

                        {{-- Card 3 --}}
                        <div class="group relative p-10 {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5 hover:border-amber-500/30' : 'bg-white border border-gray-200' }} shadow-sm rounded-[2rem] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                            <div class="mb-8 w-16 h-16 flex items-center justify-center rounded-2xl {{ $isTheme2 ? 'bg-amber-500/10 text-amber-500 shadow-inner' : 'bg-green-50 text-green-500' }} group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_title', 'Guaranteed Results') }}</h3>
                            <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} leading-relaxed">{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_desc', 'Experience visible transformations driven by our proven, high-end beauty solutions.') }}</p>
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section['id'] === 'testimonials')
            {{-- TESTIMONIALS SECTION --}}
            <section class="py-16 md:py-24 {{ $isTheme2 ? 'bg-[#0a0a0c] border-b border-white/5' : 'bg-[#faf9f8]' }} overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    
                    {{-- Section Header --}}
                    <div class="text-center mb-12 md:mb-16 reveal-on-scroll">
                        <span class="inline-block text-sm font-semibold {{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} mb-3 tracking-wider uppercase">Real Results</span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">What Our Clients Say</h2>
                        <div class="w-16 h-0.5 {{ $isTheme2 ? 'bg-amber-500' : 'bg-amber-600' }} mx-auto"></div>
                    </div>

                    {{-- Swiper Container --}}
                    <div class="swiper testimonial-swiper pb-12 reveal-on-scroll">
                        <div class="swiper-wrapper">
                            @forelse($homepageReviews as $rev)
                                <div class="swiper-slide h-auto md:w-1/3">
                                    <div class="p-8 rounded-2xl transition-shadow duration-300 h-full flex flex-col border {{ $isTheme2 ? 'bg-slate-900/40 border-white/5 text-slate-300' : 'bg-white border-gray-50 shadow-sm hover:shadow-md' }}">
                                        <div class="flex gap-1 mb-4 text-amber-400">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $rev->rating ? 'fill-current' : 'text-slate-200 dark:text-slate-700 stroke-current' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <h4 class="font-extrabold text-sm {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-2">{{ $rev->title }}</h4>
                                        <p class="italic mb-6 flex-grow leading-relaxed {{ $isTheme2 ? 'text-slate-300' : 'text-gray-600' }}">"{{ $rev->text }}"</p>
                                        <div class="flex items-center gap-4 mt-auto pt-6 border-t {{ $isTheme2 ? 'border-white/5' : 'border-gray-100' }}">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-amber-500/10">
                                                {{ strtoupper(substr($rev->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-sm">{{ $rev->name }}</h4>
                                                <span class="text-xs {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }}">{{ $rev->product_name ?? 'Verified Buyer' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- Testimonial 1 --}}
                                <div class="swiper-slide h-auto md:w-1/3">
                                    <div class="p-8 rounded-2xl transition-shadow duration-300 h-full flex flex-col border {{ $isTheme2 ? 'bg-slate-900/40 border-white/5 text-slate-300' : 'bg-white border-gray-50 shadow-sm hover:shadow-md' }}">
                                        <div class="flex gap-1 mb-4 text-amber-400">
                                            @for($i=0; $i<5; $i++)
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                        <p class="italic mb-6 flex-grow leading-relaxed {{ $isTheme2 ? 'text-slate-300' : 'text-gray-600' }}">"This LED mask completely transformed my skin texture. My fine lines are visibly reduced and my skin has this permanent healthy glow. Worth every penny!"</p>
                                        <div class="flex items-center gap-4 mt-auto pt-6 border-t {{ $isTheme2 ? 'border-white/5' : 'border-gray-100' }}">
                                            <img src="https://ui-avatars.com/api/?name=Sarah+M&background=fdf4ff&color=d946ef" alt="Sarah M." class="w-10 h-10 rounded-full">
                                            <div>
                                                <h4 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-sm">Sarah M.</h4>
                                                <span class="text-xs {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }}">Verified Buyer</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Testimonial 2 --}}
                                <div class="swiper-slide h-auto md:w-1/3">
                                    <div class="p-8 rounded-2xl transition-shadow duration-300 h-full flex flex-col border {{ $isTheme2 ? 'bg-slate-900/40 border-white/5 text-slate-300' : 'bg-white border-gray-50 shadow-sm hover:shadow-md' }}">
                                        <div class="flex gap-1 mb-4 text-amber-400">
                                            @for($i=0; $i<5; $i++)
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                        <p class="italic mb-6 flex-grow leading-relaxed {{ $isTheme2 ? 'text-slate-300' : 'text-gray-600' }}">"I was skeptical at first, but the anti-acne device cleared my hormonal breakouts in just two weeks. It's now a non-negotiable part of my nighttime routine."</p>
                                        <div class="flex items-center gap-4 mt-auto pt-6 border-t {{ $isTheme2 ? 'border-white/5' : 'border-gray-100' }}">
                                            <img src="https://ui-avatars.com/api/?name=Emily+R&background=f0fdf4&color=16a34a" alt="Emily R." class="w-10 h-10 rounded-full">
                                            <div>
                                                <h4 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-sm">Emily R.</h4>
                                                <span class="text-xs {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }}">Verified Buyer</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Testimonial 3 --}}
                                <div class="swiper-slide h-auto md:w-1/3">
                                    <div class="p-8 rounded-2xl transition-shadow duration-300 h-full flex flex-col border {{ $isTheme2 ? 'bg-slate-900/40 border-white/5 text-slate-300' : 'bg-white border-gray-50 shadow-sm hover:shadow-md' }}">
                                        <div class="flex gap-1 mb-4 text-amber-400">
                                            @for($i=0; $i<5; $i++)
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                        <p class="italic mb-6 flex-grow leading-relaxed {{ $isTheme2 ? 'text-slate-300' : 'text-gray-600' }}">"Professional grade results at home. I actually cancelled my monthly clinic appointments because this device maintains my skin beautifully."</p>
                                        <div class="flex items-center gap-4 mt-auto pt-6 border-t {{ $isTheme2 ? 'border-white/5' : 'border-gray-100' }}">
                                            <img src="https://ui-avatars.com/api/?name=Jessica+T&background=eff6ff&color=2563eb" alt="Jessica T." class="w-10 h-10 rounded-full">
                                            <div>
                                                <h4 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-sm">Jessica T.</h4>
                                                <span class="text-xs {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }}">Verified Buyer</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        {{-- Pagination Dots --}}
                        <div class="swiper-pagination !-bottom-2"></div>
                    </div>
                </div>
            </section>

        @elseif($section['id'] === 'features_strip')
            {{-- FEATURES / BENEFITS STRIP --}}
            <section class="py-10 {{ $isTheme2 ? 'bg-[#0d0d0f] border-t border-b border-white/5 text-slate-300' : 'bg-white border-t border-b border-gray-100' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x {{ $isTheme2 ? 'divide-white/5' : 'divide-gray-100' }} reveal-on-scroll">
                        
                        {{-- Feature 1 --}}
                        <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8 {{ $isTheme2 ? 'text-amber-500' : 'text-[#9b1c31]' }} mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            <p class="text-[13px] md:text-sm {{ $isTheme2 ? 'text-slate-300' : 'text-gray-700' }} font-medium">Free Delivery on Orders {!! \App\Helpers\CurrencyHelper::format(43000) !!}+</p>
                        </div>

                        {{-- Feature 2 --}}
                        <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8 {{ $isTheme2 ? 'text-amber-500' : 'text-[#9b1c31]' }} mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <p class="text-[13px] md:text-sm {{ $isTheme2 ? 'text-slate-300' : 'text-gray-700' }} font-medium">60-Day Trial</p>
                        </div>

                        {{-- Feature 3 --}}
                        <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8 {{ $isTheme2 ? 'text-amber-500' : 'text-[#9b1c31]' }} mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <p class="text-[13px] md:text-sm {{ $isTheme2 ? 'text-slate-300' : 'text-gray-700' }} font-medium">12 Years Leading LED Innovation Globally</p>
                        </div>

                        {{-- Feature 4 --}}
                        <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                            <svg class="w-8 h-8 {{ $isTheme2 ? 'text-amber-500' : 'text-[#9b1c31]' }} mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <p class="text-[13px] md:text-sm {{ $isTheme2 ? 'text-slate-300' : 'text-gray-700' }} font-medium">Transformed 500,000+ Skincare Routines</p>
                        </div>

                    </div>
                </div>
            </section>
        @endif
        
    @endif
@endforeach

</div>

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

        // Reels Video play/pause/mute logic
        function handleSlideVideo(activeSlide) {
            if (!activeSlide) return;
            
            // Pause all videos first
            document.querySelectorAll('.reel-video').forEach(video => {
                video.pause();
                const slide = video.closest('.swiper-slide');
                if (slide) updatePlayBtnUI(slide, false);
            });
            
            // Play active slide video
            const activeVideo = activeSlide.querySelector('.reel-video');
            if (activeVideo) {
                activeVideo.play().catch(e => console.log('Autoplay blocked:', e));
                updatePlayBtnUI(activeSlide, true);
            }
        }

        function updatePlayBtnUI(slide, isPlaying) {
            const playIcon = slide.querySelector('.play-icon');
            const pauseIcon = slide.querySelector('.pause-icon');
            if (isPlaying) {
                playIcon?.classList.add('hidden');
                pauseIcon?.classList.remove('hidden');
            } else {
                playIcon?.classList.remove('hidden');
                pauseIcon?.classList.add('hidden');
            }
        }

        swiper.on('slideChangeTransitionEnd', function () {
            const activeSlide = swiper.slides[swiper.activeIndex];
            handleSlideVideo(activeSlide);
        });

        // Initial play for active slide after a small delay to ensure loading
        setTimeout(() => {
            const activeSlide = swiper.slides[swiper.activeIndex];
            handleSlideVideo(activeSlide);
        }, 800);

        // Click to toggle Play/Pause
        document.addEventListener('click', function (e) {
            const video = e.target.closest('.reel-video');
            if (video) {
                const slide = video.closest('.swiper-slide');
                if (video.paused) {
                    video.play();
                    updatePlayBtnUI(slide, true);
                } else {
                    video.pause();
                    updatePlayBtnUI(slide, false);
                }
            }
        });

        // Click to toggle Mute
        document.addEventListener('click', function (e) {
            const muteBtn = e.target.closest('.mute-btn');
            if (muteBtn) {
                e.stopPropagation();
                const slide = muteBtn.closest('.swiper-slide');
                const video = slide.querySelector('.reel-video');
                if (video) {
                    const shouldMute = !video.muted;
                    document.querySelectorAll('.reel-video').forEach(v => {
                        v.muted = shouldMute;
                        const s = v.closest('.swiper-slide');
                        if (s) {
                            const muteIcon = s.querySelector('.mute-icon');
                            const soundIcon = s.querySelector('.sound-icon');
                            if (shouldMute) {
                                muteIcon?.classList.remove('hidden');
                                soundIcon?.classList.add('hidden');
                            } else {
                                muteIcon?.classList.add('hidden');
                                soundIcon?.classList.remove('hidden');
                            }
                        }
                    });
                }
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