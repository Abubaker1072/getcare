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
    .reel-swiper .swiper-slide {
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.5;
        transform: scale(0.85);
    }
    .reel-swiper .swiper-slide-active {
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
    @keyframes marquee-shortcuts {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee-shortcuts {
        animation: marquee-shortcuts 25s linear infinite;
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

    /* Hot Deal Swiper Custom Transitions & Optimization */
    .hotdeal-swiper .swiper-wrapper {
        will-change: transform;
    }
    .hotdeal-swiper .swiper-slide {
        will-change: transform;
    }
    
    /* Slide Content Animations (Active Slide) */
    .hotdeal-swiper .swiper-slide img {
        transform: scale(0.92) translateY(5px);
        opacity: 0.8;
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.8s ease;
    }
    .hotdeal-swiper .swiper-slide-active img {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .hotdeal-swiper .swiper-slide h2 {
        transform: translateY(10px);
        opacity: 0.8;
        transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.7s ease;
    }
    .hotdeal-swiper .swiper-slide-active h2 {
        transform: translateY(0);
        opacity: 1;
    }

    .hotdeal-swiper .swiper-slide p {
        transform: translateY(8px);
        opacity: 0.7;
        transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.7s ease;
        transition-delay: 0.05s;
    }
    .hotdeal-swiper .swiper-slide-active p {
        transform: translateY(0);
        opacity: 1;
    }

    .hotdeal-swiper .swiper-slide .claim-offer-btn {
        transform: translateY(10px);
        opacity: 0.8;
        transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.7s ease;
        transition-delay: 0.1s;
    }
    .hotdeal-swiper .swiper-slide-active .claim-offer-btn {
        transform: translateY(0);
        opacity: 1;
    }

    @media (max-width: 767px) {
        /* Optimize expensive CSS filters to prevent paint lag during manual touch swiping on mobile */
        .hotdeal-swiper img {
            filter: none !important;
        }
        .hotdeal-swiper .blur-2xl {
            filter: none !important;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.22) 0%, transparent 65%) !important;
        }
        /* Snappier transition durations on mobile for better touch gesture response */
        .hotdeal-swiper .swiper-slide img,
        .hotdeal-swiper .swiper-slide h2,
        .hotdeal-swiper .swiper-slide p,
        .hotdeal-swiper .swiper-slide .claim-offer-btn {
            transition-duration: 0.4s !important;
        }
    }
    
    /* Routine Carousel Pagination Styling */
    .routine-pagination .swiper-pagination-bullet {
        background: #94a3b8;
        opacity: 0.5;
        width: 6px;
        height: 6px;
        transition: all 0.3s ease;
    }
    .routine-pagination .swiper-pagination-bullet-active {
        background: #0f172a !important;
        opacity: 1;
        width: 16px;
        border-radius: 3px;
    }
    .theme-2 .routine-pagination .swiper-pagination-bullet-active {
        background: #f59e0b !important;
    }

    /* Premium Blog/Article Card Styles */
    .article-card-premium {
        position: relative;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 1.25rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.6s cubic-bezier(0.16, 1, 0.3, 1), 
                    border-color 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, box-shadow;
    }
    .article-card-premium:hover {
        transform: translateY(-6px);
        border-color: transparent;
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.08);
    }
    .theme-2 .article-card-premium {
        background: rgba(15, 23, 42, 0.4);
        border-color: rgba(255, 255, 255, 0.05);
    }
    .theme-2 .article-card-premium:hover {
        border-color: rgba(245, 158, 11, 0.15);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4);
    }
    
    .article-card-image-wrapper {
        position: relative;
        overflow: hidden;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .article-card-image-wrapper img {
        transition: transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .article-card-premium:hover .article-card-image-wrapper img {
        transform: scale(1.05);
    }
    
    /* Elegant text limit with transition support */
    .article-desc {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-height: 2.75rem; /* ~2 lines */
        transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease;
        opacity: 0.85;
    }
    .article-desc.expanded {
        display: block;
        max-height: 25rem;
        opacity: 1;
    }

    .article-card-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 10;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #1e293b;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .theme-2 .article-card-badge {
        background: rgba(15, 23, 42, 0.85);
        color: #f59e0b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .article-card-read-time {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 500;
        padding: 0.35rem 0.65rem;
        border-radius: 9999px;
        transition: all 0.3s ease;
    }
    
    /* Swiper bullets styling specifically for articles */
    .articles-swiper .swiper-pagination-bullet {
        background: #94a3b8;
        opacity: 0.5;
        width: 6px;
        height: 6px;
        transition: all 0.3s ease;
    }
    .articles-swiper .swiper-pagination-bullet-active {
        background: #0f172a !important;
        opacity: 1;
        width: 16px;
        border-radius: 3px;
    }
    .theme-2 .articles-swiper .swiper-pagination-bullet-active {
        background: #f59e0b !important;
    }

    /* PREMIUM OVERHAUL CUSTOM ANIMATIONS & EFFECTS */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes pulse-glow {
        0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        50% { transform: scale(1.1); opacity: 0.8; box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
    }
    .animate-pulse-glow {
        animation: pulse-glow 2s infinite;
    }

    /* Viewport scroll reveal base classes */
    .reveal-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, opacity;
    }
    .reveal-on-scroll.is-revealed {
        opacity: 1;
        transform: translateY(0);
    }
    .animation-delay-100 { transition-delay: 100ms; }
    .animation-delay-200 { transition-delay: 200ms; }
    .animation-delay-300 { transition-delay: 300ms; }
    .animation-delay-400 { transition-delay: 400ms; }
    .animation-delay-500 { transition-delay: 500ms; }

    /* Category Nav Scroll Styling */
    .scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hidden {
        -ms-overflow-style: none;
        scrollbar-width: none;
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
            <section class="relative min-h-[450px] sm:min-h-[500px] md:h-[600px] lg:h-[700px] overflow-hidden border-b {{ $isTheme2 ? 'border-white/5' : 'border-transparent' }}">
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
                                const heroSlides = document.querySelectorAll('.hero-bg-swiper .swiper-slide');
                                new Swiper('.hero-bg-swiper', {
                                    loop: heroSlides.length > 1,
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
                <div class="relative z-10 h-full flex items-center justify-center md:justify-start pt-24 md:pt-0">
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
        
        @elseif($section['id'] === 'category_quick_nav')
            {{-- Circular Category Quick Navigation (Amazon/Temu/Daraz Inspired) Marquee --}}
            <section class="py-6 sm:py-10 {{ $isTheme2 ? 'bg-[#0a0a0c] border-b border-white/5' : 'bg-[#faf9f6] border-b border-slate-100' }} overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="w-full overflow-hidden relative">
                        <div class="flex gap-8 w-max animate-marquee-shortcuts hover:[animation-play-state:paused] cursor-pointer">
                            
                            {{-- Original Items --}}
                            @foreach($featuredCategories as $cat)
                                <a href="{{ route('products.all', ['categories' => [$cat->id]]) }}" class="flex flex-col items-center gap-3 group shrink-0 w-20 sm:w-28 text-center transition-transform duration-300 hover:-translate-y-1">
                                    <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-full overflow-hidden border-2 {{ $isTheme2 ? 'border-white/10 group-hover:border-amber-500 shadow-amber-500/10' : 'border-gray-200 group-hover:border-slate-800' }} p-0.5 bg-white transition-all duration-300 shadow-sm group-hover:shadow-lg">
                                        <img src="{{ ImageHelper::getCategoryImage($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover rounded-full transition-transform duration-700 group-hover:scale-110">
                                    </div>
                                    <span class="text-[10px] sm:text-xs font-extrabold tracking-wider text-center uppercase {{ $isTheme2 ? 'text-slate-400 group-hover:text-amber-400' : 'text-gray-600 group-hover:text-slate-900' }} transition-colors whitespace-normal leading-tight line-clamp-3">
                                        {{ $cat->name }}
                                    </span>
                                </a>
                            @endforeach

                            {{-- Duplicate Items for Seamless Loop --}}
                            @foreach($featuredCategories as $cat)
                                <a href="{{ route('products.all', ['categories' => [$cat->id]]) }}" class="flex flex-col items-center gap-3 group shrink-0 w-20 sm:w-28 text-center transition-transform duration-300 hover:-translate-y-1">
                                    <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-full overflow-hidden border-2 {{ $isTheme2 ? 'border-white/10 group-hover:border-amber-500 shadow-amber-500/10' : 'border-gray-200 group-hover:border-slate-800' }} p-0.5 bg-white transition-all duration-300 shadow-sm group-hover:shadow-lg">
                                        <img src="{{ ImageHelper::getCategoryImage($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover rounded-full transition-transform duration-700 group-hover:scale-110">
                                    </div>
                                    <span class="text-[10px] sm:text-xs font-extrabold tracking-wider text-center uppercase {{ $isTheme2 ? 'text-slate-400 group-hover:text-amber-400' : 'text-gray-600 group-hover:text-slate-900' }} transition-colors whitespace-normal leading-tight line-clamp-3">
                                        {{ $cat->name }}
                                    </span>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </section>
        
        @elseif($section['id'] === 'complete_routine')
            {{-- COMPLETE ROUTINE SECTION --}}
            @php
                $routineLifestyleImage = \App\Models\StoreSetting::getValue('routine_lifestyle_image_path');
                $routineLifestyleUrl = $routineLifestyleImage ? asset('storage/' . $routineLifestyleImage) : asset('images/lifestyle-placeholder.jpg');
            @endphp
            <section class="w-full">
                <div class="flex flex-row w-full h-[280px] xs:h-[340px] sm:h-[420px] md:h-[600px]">
                    <!-- Left Side: Product Set (Swiper Slider) -->
                    <div class="w-1/2 h-full {{ $isTheme2 ? 'bg-[#0a0a0c] border-r border-white/5' : 'bg-[#e6e2f1]' }} relative overflow-hidden flex flex-col justify-center" 
                         style="{{ $isTheme2 ? 'background: radial-gradient(circle at center, rgba(245,158,11,0.06) 0%, rgba(10,10,12,0) 75%), #0a0a0c;' : '' }}">
                        
                        {{-- Background bubble/glow --}}
                        <div class="hidden md:block absolute w-[200px] sm:w-[320px] h-[200px] sm:h-[320px] {{ $isTheme2 ? 'bg-gradient-to-tr from-amber-500/15 to-transparent' : 'bg-gradient-to-tr from-purple-300/30 to-pink-300/30' }} rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700 pointer-events-none z-0"></div>

                        @if(isset($heroHotDeals) && $heroHotDeals->isNotEmpty())
                            <div class="swiper routine-swiper w-full h-full">
                                <div class="swiper-wrapper">
                                    @foreach($heroHotDeals as $product)
                                        <div class="swiper-slide flex flex-col justify-center items-center p-3 sm:p-6 text-center select-none h-full">
                                            <a href="{{ route('product.detail', $product->id) }}" class="flex flex-col items-center justify-center group/item h-full">
                                                <div class="relative w-[85%] max-w-[100px] xs:max-w-[140px] sm:max-w-[200px] md:max-w-[280px] aspect-square flex items-center justify-center mb-1 xs:mb-3 sm:mb-6">
                                                    <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80';" 
                                                         alt="{{ $product->name }}" 
                                                         class="max-w-full max-h-full object-contain drop-shadow-2xl transition-transform duration-700 group-hover/item:scale-105 filter {{ $isTheme2 ? 'brightness-110 contrast-105' : '' }}">
                                                </div>
                                                <div class="mt-1 text-center">
                                                    <h3 class="text-[10px] xs:text-xs sm:text-base md:text-xl font-serif {{ $isTheme2 ? 'text-white' : 'text-slate-800' }} font-medium line-clamp-1 max-w-[160px] sm:max-w-xs mx-auto">
                                                        {{ $product->name }}
                                                    </h3>
                                                    <p class="text-[10px] xs:text-xs sm:text-base md:text-lg font-semibold {{ $isTheme2 ? 'text-amber-400' : 'text-slate-900' }} mt-0.5 sm:mt-1">
                                                        {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- Pagination dots --}}
                                <div class="swiper-pagination routine-pagination !bottom-1 sm:!bottom-4"></div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-4 text-slate-500">
                                <p class="text-xs sm:text-sm italic">No hot deals featured for hero.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Side: Lifestyle Image -->
                    <div class="w-1/2 relative flex items-center justify-center p-4 sm:p-12 h-full overflow-hidden group">
                        <img src="{{ $routineLifestyleUrl }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1000&q=80';" alt="Skincare Routine" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t {{ $isTheme2 ? 'from-black/80 via-black/40' : 'from-black/60 via-black/20' }} to-transparent"></div>
                        
                        <div class="relative z-10 text-left w-full mt-auto">
                            <h2 class="text-sm xs:text-lg sm:text-3xl md:text-5xl lg:text-6xl font-serif font-medium {{ $isTheme2 ? 'text-[#c5a880]' : 'text-white' }} leading-tight drop-shadow-md">
                                Complete Routine in <br>One Set
                            </h2>
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section['id'] === 'categories')
            {{-- CATEGORIES SECTION --}}
            <section id="categories" class="py-1 sm:py-2 {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="text-center mb-2 md:mb-3 reveal-on-scroll">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-2 md:mb-4">Featured Collections</h2>
                        <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-600' }} text-sm md:text-lg">Discover our premium skincare & beauty devices</p>
                    </div>

                    @if($featuredCategories->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <p>Featured categories coming soon.</p>
                        </div>
                    @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 reveal-on-scroll">
                        @foreach($featuredCategories as $category)
                        <div class="relative rounded-[1rem] sm:rounded-[2rem] overflow-hidden cursor-pointer hover:shadow-xl transition-all duration-300 group h-[200px] sm:h-[400px] border {{ $isTheme2 ? 'border-white/5 hover:border-amber-500/30' : 'border-transparent' }}">
                            <img src="{{ ImageHelper::getCategoryImage($category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <div class="absolute inset-0 {{ $isTheme2 ? 'bg-black/40 backdrop-blur-[1px]' : 'bg-black/20' }} flex flex-col items-center justify-center p-2 sm:p-6 text-center">
                                <h3 class="text-base sm:text-2xl font-semibold text-white mb-2 sm:mb-6 tracking-wide drop-shadow-md uppercase {{ $isTheme2 ? 'text-amber-400' : '' }}">
                                    {{ $category->name }}
                                </h3>
                                
                                <a href="{{ route('products.all', ['categories' => [$category->id]]) }}" 
                                   class="{{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md shadow-amber-500/10 hover:shadow-lg hover:shadow-amber-500/20' : 'bg-[#FDF9F5] text-[#4A4A4A] hover:bg-white' }} px-4 py-2 sm:px-8 sm:py-3 rounded-full font-bold text-[10px] sm:text-sm tracking-widest transition-all duration-300">
                                    SHOP NOW
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>

        @elseif($section['id'] === 'flash_sale_banner')
            {{-- Conversion-Driven Flash Sale Banner --}}
            @php
                $countdownActive = \App\Models\StoreSetting::getValue('countdown_is_active', '0') === '1';
                $countdownEndTime = \App\Models\StoreSetting::getValue('countdown_end_time');
                $countdownText = \App\Models\StoreSetting::getValue('countdown_text', 'Limited Time Flash Sale');
                $countdownSubtext = \App\Models\StoreSetting::getValue('countdown_subtext', 'Extra 10% Off automatically applied at checkout!');
            @endphp
            @if($countdownActive && $countdownEndTime)
            <section class="py-4 sm:py-6 relative overflow-hidden {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : '' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div id="homepage-flash-banner" data-target-time="{{ $countdownEndTime }}" class="max-w-3xl mx-auto reveal-on-scroll animation-delay-100">
                        <div class="relative rounded-2xl p-4 sm:p-6 {{ $isTheme2 ? 'bg-[#121218]/80 border border-amber-500/20 shadow-lg shadow-amber-500/5' : 'bg-gradient-to-r from-rose-50 to-orange-50 border border-rose-100 shadow-sm' }} flex flex-col sm:flex-row items-center justify-between gap-4">
                            
                            {{-- Left side label --}}
                            <div class="flex items-center gap-3">
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider {{ $isTheme2 ? 'text-white' : 'text-gray-900' }}">
                                        {{ $countdownText }}
                                    </h4>
                                    <p class="text-[10px] sm:text-xs {{ $isTheme2 ? 'text-amber-400' : 'text-rose-600' }} font-bold tracking-wide">
                                        {{ $countdownSubtext }}
                                    </p>
                                </div>
                            </div>
                            
                            {{-- Right side timer --}}
                            <div class="flex items-center gap-2">
                                <div class="flex flex-col items-center">
                                    <div id="flash-hours" class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl text-base sm:text-lg font-bold {{ $isTheme2 ? 'bg-slate-900 text-amber-400 border border-amber-500/30' : 'bg-white text-rose-600 shadow-sm border border-rose-100' }}">
                                        00
                                    </div>
                                    <span class="text-[8px] sm:text-[9px] uppercase font-semibold text-gray-400 tracking-wider mt-1">Hrs</span>
                                </div>
                                <span class="text-base sm:text-lg font-bold {{ $isTheme2 ? 'text-amber-500' : 'text-rose-600' }} -mt-5">:</span>
                                <div class="flex flex-col items-center">
                                    <div id="flash-minutes" class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl text-base sm:text-lg font-bold {{ $isTheme2 ? 'bg-slate-900 text-amber-400 border border-amber-500/30' : 'bg-white text-rose-600 shadow-sm border border-rose-100' }}">
                                        00
                                    </div>
                                    <span class="text-[8px] sm:text-[9px] uppercase font-semibold text-gray-400 tracking-wider mt-1">Min</span>
                                </div>
                                <span class="text-base sm:text-lg font-bold {{ $isTheme2 ? 'text-amber-500' : 'text-rose-600' }} -mt-5">:</span>
                                <div class="flex flex-col items-center">
                                    <div id="flash-seconds" class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl text-base sm:text-lg font-bold {{ $isTheme2 ? 'bg-slate-900 text-amber-400 border border-amber-500/30 animate-pulse-glow' : 'bg-white text-rose-600 shadow-sm border border-rose-100 animate-pulse-glow' }}">
                                        00
                                    </div>
                                    <span class="text-[8px] sm:text-[9px] uppercase font-semibold text-gray-400 tracking-wider mt-1">Sec</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            @endif

        @elseif($section['id'] === 'products')
            {{-- PRODUCTS SECTION --}}
            <section class="py-2 sm:py-3 relative overflow-hidden {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : '' }}">
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
                    <div class="text-center mb-3 md:mb-4 reveal-on-scroll">
                        <span class="inline-block text-sm font-semibold {{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} mb-2 tracking-wider uppercase">Premium Selection</span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">Bestselling Products</h2>
                        <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-600' }} text-base md:text-lg max-w-2xl mx-auto">Discover our most loved beauty and skincare devices trusted by thousands</p>
                    </div>

                    {{-- Products Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 md:gap-8 mb-6 reveal-on-scroll">
                        @foreach($bestsellingProducts->take(8) as $index => $product)
                        <div class="product-card group cursor-pointer animation-delay-{{ $index * 100 }}">
                            {{-- Card Container --}}
                            <div class="relative h-full rounded-2xl overflow-hidden {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5' : 'bg-white shadow-lg' }} hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col justify-between">
                                {{-- Product Image Container --}}
                                <a href="{{ route('product.detail', $product->id) }}" class="block relative {{ $isTheme2 ? 'bg-slate-950/60' : 'bg-slate-50' }} h-40 sm:h-48 md:h-56 overflow-hidden flex items-center justify-center p-4">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/5 via-transparent to-black/0 group-hover:from-black/10 transition duration-500"></div>
                                    <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700 ease-out {{ $product->stock <= 0 ? 'opacity-45 grayscale' : '' }}">

                                    @if($product->stock <= 0)
                                    <div class="absolute top-4 right-4 bg-gray-500 text-white px-3 py-1 rounded-full text-[10px] font-sans font-bold uppercase tracking-wider shadow-lg transform transition-transform duration-300 hover:scale-110 z-10">
                                        Sold Out
                                    </div>
                                    @elseif($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                    <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-[10px] font-sans font-bold uppercase tracking-wider shadow-lg transform transition-transform duration-300 hover:scale-110 z-10">
                                        Sale
                                    </div>
                                    @endif

                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="text-white text-center">
                                            <svg class="w-12 h-12 mx-auto mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                {{-- Product Info --}}
                                <div class="p-3 sm:p-4 flex-grow flex flex-col justify-between">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <h3 class="font-bold {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} text-xs sm:text-sm line-clamp-2 mb-1.5 leading-tight group-hover:text-amber-600 transition-colors break-words">
                                            {{ $product->name }}
                                        </h3>
                                    </a>

                                    <div class="flex items-center justify-between gap-1 mb-2">
                                        <div class="flex items-center gap-1 flex-shrink-0">
                                            <div class="flex flex-row flex-nowrap text-amber-400 text-[10px] sm:text-xs whitespace-nowrap">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor((float)$product->rating))
                                                        ★
                                                    @elseif($i - 0.5 <= (float)$product->rating)
                                                        <span class="relative">★<span class="absolute inset-0 overflow-hidden w-1/2 text-amber-400">★</span></span>
                                                    @else
                                                        <span class="text-gray-300">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-[10px] sm:text-xs text-gray-500">({{ $product->reviews_count ?? 0 }})</span>
                                        </div>
                                        @if(($product->purchased_count ?? 0) > 0)
                                        <div class="text-[10px] sm:text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap flex-shrink-0">
                                            {{ $product->purchased_count }}+ sold
                                        </div>
                                        @endif
                                    </div>

                                    <div class="w-full overflow-hidden">
                                        <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 mb-1 w-full">
                                            @if($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                                <span class="text-sm sm:text-lg font-sans font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                                <span class="text-[10px] sm:text-sm font-sans text-gray-400 line-through whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}</span>
                                                @if($product->discount_price && (float)$product->discount_price > 0)
                                                    <span class="text-[10px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">Save {{ \App\Helpers\CurrencyHelper::format($product->discount_price) }}</span>
                                                @else
                                                    <span class="text-[10px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">{{ round((1 - $product->price/$product->compare_price) * 100) }}% OFF</span>
                                                @endif
                                            @else
                                                <span class="text-sm sm:text-lg font-sans font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                            @endif
                                        </div>
                                    </div>


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
                    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 mt-2 sm:mt-3 relative">
                        <div class="swiper hotdeal-swiper !pb-6">
                            <div class="swiper-wrapper">
                                @foreach($hotDealProducts as $featuredHotDeal)
                                    @php
                                        $featuredSale = $featuredHotDeal->price;
                                        $featuredCompare = $featuredHotDeal->compare_price;
                                        $featuredSavings = ($featuredCompare && $featuredCompare > $featuredSale) ? ($featuredHotDeal->discount_price && (float)$featuredHotDeal->discount_price > 0 ? (float)$featuredHotDeal->discount_price : $featuredCompare - $featuredSale) : 0;
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="fade-up relative rounded-[2rem] {{ $isTheme2 ? 'bg-slate-950 border border-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.3)] hover:shadow-[0_30px_60px_rgba(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)]' }} overflow-hidden group hover:-translate-y-2 transition-[transform,box-shadow] duration-500">
                                            <div class="flex flex-row items-stretch h-[180px] xs:h-[210px] sm:h-auto">
                                                <div class="w-[58%] sm:w-1/2 p-2.5 xs:p-3 sm:p-6 md:p-10 relative z-10 flex flex-col justify-center">
                                                    <span class="{{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} text-[8px] sm:text-[10px] md:text-xs font-bold tracking-widest uppercase mb-0.5 sm:mb-3 block">Master Collection</span>
                                                    <h2 class="text-[11px] xs:text-xs sm:text-2xl md:text-4xl font-light mb-1 sm:mb-4 {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} line-clamp-2 leading-tight">
                                                        {{ $featuredHotDeal->name }}
                                                    </h2>
                                                    <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-slate-500' }} text-[9px] xs:text-[10px] sm:text-sm leading-relaxed mb-1.5 sm:mb-6 max-w-md font-light line-clamp-2 sm:line-clamp-3 pr-1 sm:pr-0">
                                                        {{ $featuredHotDeal->description ?? 'Premium selection of our top-rated products.' }}
                                                    </p>
                                                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-3 mb-1.5 sm:mb-6">
                                                        <div>
                                                            @if($featuredCompare && $featuredCompare > $featuredSale)
                                                                <span class="{{ $isTheme2 ? 'text-slate-500' : 'text-slate-400' }} line-through text-[8px] sm:text-xs block mb-0.5">Standard Price {{ \App\Helpers\CurrencyHelper::format($featuredCompare) }}</span>
                                                            @endif
                                                            <span class="text-xs xs:text-sm sm:text-2xl md:text-4xl font-bold {{ $isTheme2 ? 'text-amber-400' : 'text-slate-900' }}">{{ \App\Helpers\CurrencyHelper::format($featuredSale) }}</span>
                                                        </div>
                                                        @if($featuredSavings > 0)
                                                        <div class="{{ $isTheme2 ? 'bg-amber-950/20 border border-amber-500/20' : 'bg-red-50 border border-red-100' }} px-1.5 py-0.5 sm:px-3 sm:py-1.5 rounded-md sm:rounded-lg w-fit mt-0.5 sm:mt-0">
                                                            <span class="{{ $isTheme2 ? 'text-amber-500' : 'text-red-600' }} font-bold tracking-wider uppercase text-[7px] xs:text-[8px] sm:text-xs">You Save {{ \App\Helpers\CurrencyHelper::format($featuredSavings) }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="mt-1 sm:mt-4">
                                                        <a href="{{ route('product.detail', $featuredHotDeal->slug ?? $featuredHotDeal->id) }}"
                                                           class="claim-offer-btn inline-block text-center {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950' : 'bg-slate-900 text-white hover:bg-slate-800' }} px-3 py-1.5 sm:px-6 sm:py-3 rounded-lg sm:rounded-xl text-[8px] xs:text-[9px] sm:text-xs font-bold tracking-[0.05em] sm:tracking-[0.2em] uppercase hover:scale-105 hover:shadow-xl transition-all duration-300 w-fit">
                                                            Claim Offer
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="w-[42%] sm:w-1/2 relative flex flex-col justify-center items-center p-2 sm:p-6 {{ $isTheme2 ? 'bg-slate-900/30' : 'bg-slate-50/50 sm:bg-transparent' }} overflow-hidden rounded-none">
                                                    <div class="absolute w-[100px] sm:w-[250px] h-[100px] sm:h-[250px] {{ $isTheme2 ? 'bg-gradient-to-tr from-amber-500/20 to-transparent' : 'bg-gradient-to-tr from-amber-300/40 to-rose-200/40' }} rounded-full blur-2xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-700"></div>
                                                    <div class="h-[100px] sm:h-[250px] lg:h-[300px] w-full flex items-center justify-center p-1 sm:p-0">
                                                        @if($featuredHotDeal->cover_image || $featuredHotDeal->image)
                                                            <img src="{{ asset('storage/' . ($featuredHotDeal->cover_image ?? $featuredHotDeal->image)) }}"
                                                                 alt="{{ $featuredHotDeal->name }}"
                                                                 class="relative z-10 w-full max-w-[90px] xs:max-w-[110px] sm:max-w-[250px] h-full object-contain drop-shadow-xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                                        @else
                                                            <img src="{{ asset('images/categories/hero-deal.jpg') }}"
                                                                 alt="{{ $featuredHotDeal->name }}"
                                                                 class="relative z-10 w-full max-w-[90px] xs:max-w-[110px] sm:max-w-[250px] h-full object-contain drop-shadow-xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination !bottom-0"></div>
                        </div>
                    </div>
                @endif
            </section>

            {{-- HOMEPAGE GALLERY MARQUEE (IMAGE 2) --}}
            <section class="py-1.5 sm:py-2 {{ $isTheme2 ? 'bg-[#0c0c0e] border-b border-white/5' : 'bg-white' }} overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 mb-3 text-center reveal-on-scroll">
                    <h2 class="text-3xl md:text-5xl font-serif font-light {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} mb-2">#Beauty Vibes</h2>
                    <span class="inline-block text-xs font-semibold uppercase tracking-[0.2em] {{ $isTheme2 ? 'text-amber-500' : 'text-slate-800' }} pb-1 border-b border-current">FOLLOW US</span>
                </div>

                <div class="marquee-container flex overflow-hidden w-full relative py-2 hover-pause cursor-default">
                    {{-- First Block --}}
                    <div class="animate-marquee flex items-center gap-4 sm:gap-6 px-3">
                        @forelse($marqueeImages as $img)
                            @if($img->link_url)
                                <a href="{{ $img->link_url }}" class="flex-shrink-0 relative group block overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                            @else
                                <div class="flex-shrink-0 relative group overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                            @endif
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title ?: 'Gallery Image' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @if($img->title)
                                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                        <span class="text-white text-xs font-semibold tracking-wider uppercase text-center w-full pb-4">{{ $img->title }}</span>
                                    </div>
                                @endif
                            @if($img->link_url)
                                </a>
                            @else
                                </div>
                            @endif
                        @empty
                            @php
                                $fallbacks = [
                                    'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500&q=80',
                                    'https://images.unsplash.com/photo-1608248597481-496100c80836?w=500&q=80',
                                    'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=500&q=80',
                                    'https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=500&q=80',
                                    'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?w=500&q=80'
                                ];
                            @endphp
                            @foreach($fallbacks as $url)
                                <div class="flex-shrink-0 relative group overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                                    <img src="{{ $url }}" alt="Beauty Vibes" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            @endforeach
                        @endforelse
                    </div>

                    {{-- Second Block --}}
                    <div class="animate-marquee flex items-center gap-4 sm:gap-6 px-3" aria-hidden="true">
                        @forelse($marqueeImages as $img)
                            @if($img->link_url)
                                <a href="{{ $img->link_url }}" class="flex-shrink-0 relative group block overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                            @else
                                <div class="flex-shrink-0 relative group overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                            @endif
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title ?: 'Gallery Image' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @if($img->title)
                                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                        <span class="text-white text-xs font-semibold tracking-wider uppercase text-center w-full pb-4">{{ $img->title }}</span>
                                    </div>
                                @endif
                            @if($img->link_url)
                                </a>
                            @else
                                </div>
                            @endif
                        @empty
                            @foreach($fallbacks as $url)
                                <div class="flex-shrink-0 relative group overflow-hidden rounded-2xl w-48 sm:w-64 h-48 sm:h-64 shadow-md">
                                    <img src="{{ $url }}" alt="Beauty Vibes" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                </div>
            </section>

        @elseif($section['id'] === 'reels')
            {{-- PROFESSIONAL REELS SECTION --}}
            <section class="py-2 sm:py-3 {{ $isTheme2 ? 'bg-[#08080a] border-b border-white/5' : 'bg-white' }} overflow-hidden">
                <div class="text-center mb-3 px-4">
                    <h2 class="text-3xl md:text-4xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-800' }}">Used by the professionals, approved by the professionals</h2>
                    <p class="text-sm md:text-base {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} mt-2">Professional-grade beauty technology</p>
                </div>

                    <div class="swiper reel-swiper w-full max-w-7xl mx-auto relative">
                        <div class="swiper-wrapper">
                            
                            @php
                                $repeatedReels = $reels;
                                if ($reels->isNotEmpty() && $reels->count() < 6) {
                                    $repeatedReels = collect();
                                    while ($repeatedReels->count() < 6) {
                                        $repeatedReels = $repeatedReels->concat($reels);
                                    }
                                }
                            @endphp
                            
                            @forelse ($repeatedReels as $reel)
                            <div class="swiper-slide w-64 sm:w-72 md:w-80 flex flex-col items-center group/slide reel-card-item">
                                <div class="relative w-full aspect-[9/16] rounded-2xl overflow-hidden bg-gray-900 shadow-lg cursor-pointer">
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

                                    <!-- Social Stats Overlay -->
                                    <div class="absolute top-4 left-4 z-20 flex flex-col gap-1.5">
                                        <button type="button" onclick="event.stopPropagation(); const span = this.querySelector('.likes-count'); if(!this.dataset.liked) { span.textContent = parseInt(span.textContent) + 1; this.dataset.liked = true; this.querySelector('svg').classList.add('text-red-500', 'fill-current'); this.querySelector('svg').classList.remove('text-white'); }" class="bg-black/40 hover:bg-black/60 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm flex items-center gap-1.5 transition-all duration-350 active:scale-110 focus:outline-none">
                                            <svg class="w-3.5 h-3.5 text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="likes-count">{{ rand(50, 450) }}</span>
                                        </button>
                                        <span class="bg-black/40 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm flex items-center gap-1.5 select-none w-fit">
                                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>{{ rand(1, 15) }}.{{ rand(1, 9) }}k views</span>
                                        </span>
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
                                    <div class="relative w-full aspect-[9/16] rounded-2xl overflow-hidden bg-gray-900 shadow-lg">
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
            </section>

        @elseif($section['id'] === 'brand_marquee')
            {{-- BRAND LOGOS MARQUEE --}}
            <section class="{{ $isTheme2 ? 'bg-[#0d0d0f] border-t border-b border-amber-500/20 text-[#c5a880]/80' : 'bg-[#EAE2DB] text-gray-800' }} py-1 sm:py-1.5 overflow-hidden marquee-container flex cursor-default">
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
            <section class="py-2 sm:py-3 {{ $isTheme2 ? 'bg-[#0a0a0c] border-b border-white/5' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    
                    {{-- Header --}}
                    <div class="text-center mb-3 reveal-on-scroll">
                        <h2 class="text-3xl md:text-4xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-800' }} mb-2">Our Products For Daily Use</h2>
                        <p class="text-sm md:text-base {{ $isTheme2 ? 'text-amber-400' : 'text-gray-500' }} italic font-serif">Your Simplified routine Bible</p>
                    </div>

                    {{-- Mobile Swiper --}}
                    <div class="block md:hidden">
                        <div class="swiper articles-swiper pb-12 reveal-on-scroll">
                            <div class="swiper-wrapper flex">
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

                                    $categories = [
                                        1 => 'Wellness Guide',
                                        2 => 'Skincare Ritual',
                                        3 => 'Science & Safety'
                                    ];
                                    $readTimes = [
                                        1 => '5 min read',
                                        2 => '4 min read',
                                        3 => '6 min read'
                                    ];
                                    $category = $categories[$i] ?? 'Skincare';
                                    $readTime = $readTimes[$i] ?? '5 min read';
                                @endphp
                                
                                {{-- Article Card Mobile --}}
                                <div class="swiper-slide w-full h-auto px-4 flex justify-center">
                                    <div class="article-card-premium group w-full">
                                        <div class="article-card-image-wrapper h-52 relative">
                                            {{-- Badges --}}
                                            <span class="article-card-badge">{{ $category }}</span>
                                            <span class="article-card-read-time">{{ $readTime }}</span>
                                            <a href="{{ $link }}" class="w-full h-full block">
                                                <img src="{{ $imageUrl }}" onerror="this.onerror=null; this.src='{{ $data['default_image'] }}';" alt="{{ $title }}" class="w-full h-full object-cover">
                                            </a>
                                        </div>
                                        <div class="p-6 flex flex-col flex-grow">
                                            {{-- Category tag --}}
                                            <span class="text-[10px] tracking-[0.2em] font-bold text-amber-600 dark:text-amber-500 uppercase mb-2 block">{{ $category }}</span>
                                            <a href="{{ $link }}">
                                                <h3 class="text-lg font-light {{ $isTheme2 ? 'text-slate-200' : 'text-gray-800' }} mb-3 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition-colors duration-300 leading-snug line-clamp-2">{{ $title }}</h3>
                                            </a>
                                            
                                            {{-- Paragraph with line-clamping toggling --}}
                                            <div class="article-desc text-sm {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} mb-6 leading-relaxed">
                                                {{ $text }}
                                            </div>
                                            
                                            <div class="mt-auto flex items-center justify-between pt-2">
                                                <button onclick="let desc = this.closest('.article-card-premium').querySelector('.article-desc'); desc.classList.toggle('expanded'); this.innerText = desc.classList.contains('expanded') ? 'Read less' : 'Read more';" class="text-xs {{ $isTheme2 ? 'text-amber-500 border-amber-500/30 hover:border-amber-500' : 'text-gray-800 border-gray-300 hover:border-gray-800' }} font-bold uppercase tracking-wider border-b pb-0.5 transition-colors">Read more</button>
                                                
                                                <a href="{{ $link }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-amber-500 transition-colors">
                                                    <span class="sr-only">Go to article</span>
                                                    <svg class="w-4 h-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                </div>

                {{-- Desktop Grid --}}
                    <div class="hidden md:grid grid-cols-3 gap-8 items-start reveal-on-scroll">
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

                                $categories = [
                                    1 => 'Wellness Guide',
                                    2 => 'Skincare Ritual',
                                    3 => 'Science & Safety'
                                ];
                                $readTimes = [
                                    1 => '5 min read',
                                    2 => '4 min read',
                                    3 => '6 min read'
                                ];
                                $category = $categories[$i] ?? 'Skincare';
                                $readTime = $readTimes[$i] ?? '5 min read';
                            @endphp
                            
                            {{-- Article Card Desktop --}}
                            <div class="article-card-premium group w-full">
                                <div class="article-card-image-wrapper h-56 relative">
                                    {{-- Badges --}}
                                    <span class="article-card-badge">{{ $category }}</span>
                                    <span class="article-card-read-time">{{ $readTime }}</span>
                                    <a href="{{ $link }}" class="w-full h-full block">
                                        <img src="{{ $imageUrl }}" onerror="this.onerror=null; this.src='{{ $data['default_image'] }}';" alt="{{ $title }}" class="w-full h-full object-cover">
                                    </a>
                                </div>
                                <div class="p-8 flex flex-col flex-grow">
                                    {{-- Category tag --}}
                                    <span class="text-[10px] tracking-[0.2em] font-bold text-amber-600 dark:text-amber-500 uppercase mb-2 block">{{ $category }}</span>
                                    <a href="{{ $link }}">
                                        <h3 class="text-xl font-light {{ $isTheme2 ? 'text-slate-200' : 'text-gray-800' }} mb-3 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition-colors duration-300 leading-snug line-clamp-2">{{ $title }}</h3>
                                    </a>
                                    
                                    {{-- Paragraph with line-clamping toggling --}}
                                    <div class="article-desc text-sm {{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} mb-6 leading-relaxed">
                                        {{ $text }}
                                    </div>
                                    
                                    <div class="mt-auto flex items-center justify-between pt-2">
                                        <button onclick="let desc = this.closest('.article-card-premium').querySelector('.article-desc'); desc.classList.toggle('expanded'); this.innerText = desc.classList.contains('expanded') ? 'Read less' : 'Read more';" class="text-xs {{ $isTheme2 ? 'text-amber-500 border-amber-500/30 hover:border-amber-500' : 'text-gray-800 border-gray-300 hover:border-gray-800' }} font-bold uppercase tracking-wider border-b pb-0.5 transition-colors">Read more</button>
                                        
                                        <a href="{{ $link }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-amber-500 transition-colors">
                                            <span class="sr-only">Go to article</span>
                                            <svg class="w-4 h-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- View All Button --}}
                    <div class="mt-12 text-center">
                        <a href="#" class="inline-block {{ $isTheme2 ? 'border-2 border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-slate-950 hover:shadow-[0_0_20px_rgba(245,158,11,0.2)]' : 'border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white hover:shadow-lg' }} px-8 py-3.5 rounded-full text-xs font-bold tracking-widest uppercase transition-all duration-300 transform hover:scale-105 active:scale-95">
                            VIEW ALL ARTICLES
                        </a>
                    </div>

                </div>
            </section>

        @elseif($section['id'] === 'why_choose_us')
            {{-- PREMIUM WHY CHOOSE US SECTION (New UI) --}}
            @php
                $wcuImage = \App\Models\StoreSetting::getValue('wcu_image_path');
                $wcuMainTitle = \App\Models\StoreSetting::getValue('wcu_main_title', 'WHY CHOOSE US');
                $wcuMainDesc = \App\Models\StoreSetting::getValue('wcu_main_desc', 'Experience the perfect blend of luxury and science. Our curated collection of premium beauty essentials is designed to elevate your daily routine.');
                $wcuStat1Title = \App\Models\StoreSetting::getValue('wcu_stat1_title', '95%');
                $wcuStat1Desc = \App\Models\StoreSetting::getValue('wcu_stat1_desc', 'Customer satisfaction rate');
                $wcuStat2Title = \App\Models\StoreSetting::getValue('wcu_stat2_title', '$109+');
                $wcuStat2Desc = \App\Models\StoreSetting::getValue('wcu_stat2_desc', 'Average order value');
                $wcuBox1Title = \App\Models\StoreSetting::getValue('wcu_box1_title', 'Expertly Curated');
                $wcuBox1Desc = \App\Models\StoreSetting::getValue('wcu_box1_desc', 'Every product in our collection is meticulously selected by beauty experts.');
                $wcuBox2Title = \App\Models\StoreSetting::getValue('wcu_box2_title', 'Proven Results');
                $wcuBox2Desc = \App\Models\StoreSetting::getValue('wcu_box2_desc', 'Our treatments and formulations are clinically backed for maximum efficacy.');
                $wcuBox3Title = \App\Models\StoreSetting::getValue('wcu_box3_title', 'Premium Quality');
                $wcuBox3Desc = \App\Models\StoreSetting::getValue('wcu_box3_desc', 'We source only the finest ingredients to ensure a luxurious experience.');
            @endphp
            <section class="py-2 sm:py-3 overflow-hidden relative {{ $isTheme2 ? 'bg-[#08080a] border-b border-white/5' : 'bg-white' }}" id="wcu-section">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center">
                    
                    {{-- Left side content --}}
                    <div class="w-full {{ $wcuImage ? 'md:w-1/2 pr-0 md:pr-10' : 'mx-auto' }} mb-2 md:mb-0">
                        <div class="flex items-center justify-center md:justify-start gap-4 mb-4 wcu-animate opacity-0 translate-y-8 transition-all duration-700 ease-out">
                            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light {{ $isTheme2 ? 'text-amber-500' : 'text-[#5B4A82]' }} leading-tight uppercase tracking-wide text-center md:text-left">
                                {!! nl2br(e($wcuMainTitle)) !!}
                            </h2>
                        </div>
                        
                        <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-gray-500' }} mb-5 {{ $wcuImage ? 'max-w-md' : 'max-w-2xl mx-auto md:mx-0' }} text-sm md:text-base leading-relaxed wcu-animate opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out text-center md:text-left">
                            {{ $wcuMainDesc }}
                        </p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-12 mb-6 wcu-animate opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out">
                            <div class="text-center md:text-left">
                                <h3 class="text-4xl md:text-5xl font-bold {{ $isTheme2 ? 'text-amber-400' : 'text-[#5B4A82]' }} mb-2">{{ $wcuStat1Title }}</h3>
                                <p class="{{ $isTheme2 ? 'text-slate-500' : 'text-gray-500' }} text-sm max-w-[120px] mx-auto md:mx-0">{{ $wcuStat1Desc }}</p>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-4xl md:text-5xl font-bold {{ $isTheme2 ? 'text-amber-400' : 'text-[#5B4A82]' }} mb-2">{{ $wcuStat2Title }}</h3>
                                <p class="{{ $isTheme2 ? 'text-slate-500' : 'text-gray-500' }} text-sm max-w-[120px] mx-auto md:mx-0">{{ $wcuStat2Desc }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Box 1 -->
                            <div class="wcu-animate opacity-0 -translate-x-12 transition-all duration-700 ease-out {{ $isTheme2 ? 'bg-slate-800 border border-white/10' : 'bg-gradient-to-br from-[#7C5CC1] to-[#593CA4]' }} rounded-2xl p-6 flex-1 text-white shadow-lg transform hover:-translate-y-2 hover:shadow-xl">
                                <h4 class="font-bold mb-2 {{ $isTheme2 ? 'text-amber-400' : 'text-white' }}">{{ $wcuBox1Title }}</h4>
                                <p class="text-xs {{ $isTheme2 ? 'text-slate-300' : 'text-white/80' }}">{{ $wcuBox1Desc }}</p>
                            </div>
                            <!-- Box 2 -->
                            <div class="wcu-animate opacity-0 translate-y-12 transition-all duration-700 delay-150 ease-out {{ $isTheme2 ? 'bg-slate-800 border border-white/10' : 'bg-gradient-to-br from-[#12C2E9] to-[#0CB0D5]' }} rounded-2xl p-6 flex-1 text-white shadow-lg transform hover:-translate-y-2 hover:shadow-xl">
                                <h4 class="font-bold mb-2 {{ $isTheme2 ? 'text-amber-400' : 'text-white' }}">{{ $wcuBox2Title }}</h4>
                                <p class="text-xs {{ $isTheme2 ? 'text-slate-300' : 'text-white/80' }}">{{ $wcuBox2Desc }}</p>
                            </div>
                            <!-- Box 3 -->
                            <div class="wcu-animate opacity-0 translate-x-12 transition-all duration-700 delay-300 ease-out {{ $isTheme2 ? 'bg-slate-800 border border-white/10' : 'bg-white shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-gray-50' }} rounded-2xl p-6 flex-1 {{ $isTheme2 ? 'text-white' : 'text-gray-800' }} transform hover:-translate-y-2 hover:shadow-xl">
                                <h4 class="font-bold mb-2 {{ $isTheme2 ? 'text-amber-400' : 'text-gray-800' }}">{{ $wcuBox3Title }}</h4>
                                <p class="text-xs {{ $isTheme2 ? 'text-slate-300' : 'text-gray-500' }}">{{ $wcuBox3Desc }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Right side image --}}
                    @if($wcuImage)
                    <div class="w-full md:w-1/2 relative flex justify-center md:justify-end h-full min-h-[300px] md:min-h-[400px] mt-10 md:mt-0 wcu-animate opacity-0 translate-x-10 transition-all duration-1000 delay-300 ease-out">
                        <div class="relative md:absolute md:right-[-10%] md:top-1/2 md:-translate-y-1/2 w-[300px] h-[300px] md:w-[600px] md:h-[600px] lg:w-[800px] lg:h-[800px] rounded-full {{ $isTheme2 ? 'bg-slate-800' : 'bg-gradient-to-br from-[#8C76A6] to-[#5B4A82]' }} overflow-hidden">
                            <img src="{{ asset('storage/' . $wcuImage) }}" alt="Why Choose Us" class="w-full h-full object-cover mix-blend-overlay opacity-80 object-top">
                        </div>
                    </div>
                    @endif
                    
                </div>
            </section>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.remove('opacity-0', 'translate-y-8', 'translate-x-10', '-translate-x-12', 'translate-y-12', 'translate-x-12');
                                entry.target.classList.add('opacity-100', 'translate-y-0', 'translate-x-0');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.wcu-animate').forEach((el) => observer.observe(el));
                });
            </script>

        @elseif($section['id'] === 'testimonials')
            {{-- TESTIMONIALS SECTION --}}
            <section class="py-2 sm:py-3 {{ $isTheme2 ? 'bg-[#0a0a0c] border-b border-white/5' : 'bg-[#faf9f8]' }} overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    
                    {{-- Section Header --}}
                    <div class="text-center mb-3 md:mb-4 reveal-on-scroll">
                        <span class="inline-block text-sm font-semibold {{ $isTheme2 ? 'text-amber-500' : 'text-amber-600' }} mb-2 tracking-wider uppercase">Real Results</span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-light {{ $isTheme2 ? 'text-white' : 'text-gray-900' }} mb-4">What Our Clients Say</h2>
                        <div class="w-16 h-0.5 {{ $isTheme2 ? 'bg-amber-500' : 'bg-amber-600' }} mx-auto"></div>
                    </div>

                    {{-- Swiper Container --}}
                    <div class="swiper testimonial-swiper pb-6 reveal-on-scroll">
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
            <section class="py-2 sm:py-3 {{ $isTheme2 ? 'bg-[#0d0d0f] border-t border-b border-white/5 text-slate-300' : 'bg-white border-t border-b border-gray-100' }}">
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
        // Flash Sale rolling/target countdown timer
        function startFlashCountdown() {
            const hoursEl = document.getElementById('flash-hours');
            const minutesEl = document.getElementById('flash-minutes');
            const secondsEl = document.getElementById('flash-seconds');
            const bannerEl = document.getElementById('homepage-flash-banner');

            if (!hoursEl || !minutesEl || !secondsEl) return;

            const targetTimeStr = bannerEl ? bannerEl.getAttribute('data-target-time') : null;
            let targetTime = null;
            if (targetTimeStr) {
                targetTime = new Date(targetTimeStr).getTime();
            }

            function updateTimer() {
                const now = new Date();
                let timeRemainingMs = 0;

                if (targetTime && !isNaN(targetTime)) {
                    timeRemainingMs = targetTime - now.getTime();
                    if (timeRemainingMs < 0) {
                        timeRemainingMs = 0;
                    }
                }

                // If no target time or it has expired, use rolling 8-hour loop
                if (timeRemainingMs <= 0) {
                    const startOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    const diffMs = now.getTime() - startOfDay.getTime();
                    const eightHoursMs = 8 * 60 * 60 * 1000;
                    const currentCycle = Math.floor(diffMs / eightHoursMs);
                    const nextCycleTime = new Date(startOfDay.getTime() + (currentCycle + 1) * eightHoursMs);
                    timeRemainingMs = nextCycleTime.getTime() - now.getTime();
                }
                
                const totalSeconds = Math.floor(timeRemainingMs / 1000);
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        }
        startFlashCountdown();


        const reelSlides = document.querySelectorAll('.reel-swiper .swiper-slide');
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

        // Initialize Hot Deal Swiper
        const hotdealSwiperEl = document.querySelector('.hotdeal-swiper');
        if (hotdealSwiperEl) {
            const hotdealSlidesCount = hotdealSwiperEl.querySelectorAll('.swiper-slide').length;
            new Swiper('.hotdeal-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: hotdealSlidesCount > 1,
                speed: 650,
                grabCursor: true,
                autoplay: {
                    delay: 5500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                }
            });
        }

        // Initialize Routine Swiper (Left Slider)
        const routineSwiperEl = document.querySelector('.routine-swiper');
        if (routineSwiperEl) {
            const routineSlidesCount = routineSwiperEl.querySelectorAll('.swiper-slide').length;
            new Swiper('.routine-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: routineSlidesCount > 1,
                speed: 650,
                grabCursor: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.routine-pagination',
                    clickable: true,
                }
            });
        }

        // Initialize Why Choose Us Swiper
        const wcuSwiperEl = document.querySelector('.wcu-swiper');
        if (wcuSwiperEl) {
            new Swiper('.wcu-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 'auto',
                        spaceBetween: 0,
                        allowTouchMove: false // Disable swiping on desktop where grid takes over
                    }
                }
            });
        }

        // Initialize Articles Swiper
        const articlesSwiperEl = document.querySelector('.articles-swiper');
        if (articlesSwiperEl) {
            new Swiper('.articles-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 'auto',
                        spaceBetween: 0,
                        allowTouchMove: false // Disable swiping on desktop where grid takes over
                    }
                }
            });
        }

        // Initialize Testimonial Swiper
        const testimonialSwiperEl = document.querySelector('.testimonial-swiper');
        if (testimonialSwiperEl) {
            const testimonialSlidesCount = testimonialSwiperEl.querySelectorAll('.swiper-slide').length;
            new Swiper('.testimonial-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: testimonialSlidesCount > 3,
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
        }
    });
</script>

@endsection