@extends('layouts.app')

@php
    $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
    $isTheme2 = ($homepageTheme === 'theme_2');
@endphp

@section('content')

@if($isTheme2)
    {{-- Theme 2: Luxury Dark Mode --}}
    <style>
        :root {
            --sidebar-bg: #0c0c0e;
            --content-bg: #08080a;
            --border-color: rgba(255, 255, 255, 0.05);
            --text-muted: #94a3b8;
            --text-active: #ffffff;
            --hover-bg: rgba(255, 255, 255, 0.02);
            --active-bg: rgba(245, 158, 11, 0.08);
            --active-text: #f59e0b;
            --active-accent: #f59e0b;
            
            --card-bg: rgba(18, 18, 24, 0.6);
            --card-border: rgba(255, 255, 255, 0.04);
            --text-title: #ffffff;
            --badge-bg: rgba(245, 158, 11, 0.1);
        }
    </style>
@else
    {{-- Theme 1: Soft Light Mode --}}
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --content-bg: #f8fafc;
            --border-color: rgba(0, 0, 0, 0.05);
            --text-muted: #64748b;
            --text-active: #0f172a;
            --hover-bg: #f8fafc;
            --active-bg: rgba(155, 28, 49, 0.05);
            --active-text: #9b1c31;
            --active-accent: #9b1c31;
            
            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.03);
            --text-title: #0f172a;
            --badge-bg: rgba(155, 28, 49, 0.06);
        }
    </style>
@endif

<style>
    .category-explorer-container {
        background-color: var(--content-bg);
        min-height: 100vh;
        padding-top: 1rem; /* Reduced top spacing */
        padding-bottom: 2rem; /* Reduced bottom spacing */
    }
    
    .category-filter-btn {
        background: transparent;
        border: none;
        outline: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        transition: all 0.3s ease;
    }

    .category-filter-btn .circle-container {
        border-color: var(--border-color);
        background-color: var(--card-bg);
        border-width: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-filter-btn:hover .circle-container {
        border-color: var(--text-active);
        transform: scale(1.05);
    }

    .category-filter-btn.active .circle-container {
        border-color: var(--active-accent) !important;
        background-color: var(--active-bg) !important;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);
    }

    .category-filter-btn.active span {
        color: var(--active-text) !important;
        font-weight: 800;
    }

    .category-main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
</style>

<div class="category-explorer-container">
    <main class="category-main-content">
        
        {{-- Header Section --}}
        <div class="text-center mb-6 mt-2">
            <h1 class="text-3xl sm:text-5xl font-light {{ $isTheme2 ? 'text-white' : 'text-slate-800' }} tracking-wide font-serif mb-1 uppercase">Explore Collections</h1>
            <p class="{{ $isTheme2 ? 'text-slate-400' : 'text-slate-500' }} text-[10px] sm:text-xs tracking-widest uppercase">Premium device catalog & skincare solutions</p>
        </div>

        {{-- Categories Grid: 6 side-by-side in system view, 4 side-by-side in mobile view --}}
        <div class="max-w-5xl mx-auto mb-6">
            <div class="grid grid-cols-4 md:grid-cols-6 gap-x-2 sm:gap-x-6 gap-y-4 justify-items-center text-center">
                
                {{-- All Collections Tab --}}
                <button onclick="filterCategory('all')" id="cat-btn-all" class="category-filter-btn active">
                    <div class="circle-container w-16 h-16 sm:w-24 sm:h-24 rounded-full flex items-center justify-center shadow-sm">
                        <span class="text-xl sm:text-3xl">✨</span>
                    </div>
                    <span class="text-[11px] sm:text-[13px] font-extrabold uppercase tracking-wider text-slate-500 text-center leading-tight whitespace-normal max-w-[76px] sm:max-w-[130px] mt-2.5 transition-colors">
                        All
                    </span>
                </button>

                @foreach($categories as $category)
                    <button onclick="filterCategory('{{ $category->id }}')" id="cat-btn-{{ $category->id }}" class="category-filter-btn">
                        <div class="circle-container w-16 h-16 sm:w-24 sm:h-24 rounded-full overflow-hidden flex items-center justify-center p-0">
                            <img src="{{ \App\Helpers\ImageHelper::getCategoryImage($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        </div>
                        <span class="text-[11px] sm:text-[13px] font-extrabold uppercase tracking-wider text-slate-500 text-center leading-tight whitespace-normal max-w-[76px] sm:max-w-[130px] mt-2.5 transition-colors line-clamp-3">
                            {{ $category->name }}
                        </span>
                    </button>
                @endforeach

            </div>
        </div>

        @php
            $allProducts = collect();
            foreach($categories as $category) {
                foreach($category->products as $product) {
                    // Inject Category Context for Filtering
                    $product->filter_category_id = $category->id;
                    if (!$allProducts->contains('id', $product->id)) {
                        $allProducts->push($product);
                    }
                }
            }
        @endphp

        {{-- Unified Products Grid --}}
        @if($allProducts->isEmpty())
            <div class="bg-white dark:bg-slate-900/30 rounded-2xl border border-slate-100 dark:border-white/5 p-12 text-center max-w-md mx-auto my-12">
                <p class="text-slate-400 text-sm font-light">No products under these categories yet.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 md:gap-8">
                @foreach($allProducts as $product)
                    <div class="product-card filter-product-card group cursor-pointer transition-all duration-350" data-category-id="{{ $product->filter_category_id }}">
                        {{-- Card Container --}}
                        <div class="relative h-full rounded-2xl overflow-hidden {{ $isTheme2 ? 'bg-slate-900/40 border border-white/5' : 'bg-white shadow-lg' }} hover:shadow-2xl transition-all duration-500 flex flex-col justify-between">
                            
                            {{-- Product Image Container --}}
                            <a href="{{ route('product.detail', $product->id) }}" class="block relative {{ $isTheme2 ? 'bg-slate-950/60' : 'bg-slate-50' }} h-36 sm:h-48 md:h-56 overflow-hidden flex items-center justify-center p-3 sm:p-4">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/5 via-transparent to-black/0 group-hover:from-black/10 transition duration-500"></div>
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700 ease-out {{ $product->stock <= 0 ? 'opacity-45 grayscale' : '' }}">

                                @if($product->stock <= 0)
                                <div class="absolute top-2 right-2 bg-gray-500 text-white px-2 py-0.5 rounded-full text-[8px] sm:text-[10px] font-sans font-bold uppercase tracking-wider shadow-lg z-10">
                                    Sold Out
                                </div>
                                @elseif($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-0.5 rounded-full text-[8px] sm:text-[10px] font-sans font-bold uppercase tracking-wider shadow-lg z-10">
                                    Sale
                                </div>
                                @endif

                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="text-white text-center">
                                        <svg class="w-10 h-10 mx-auto mb-1 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <div class="text-[9px] sm:text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap flex-shrink-0">
                                        {{ $product->purchased_count }}+ sold
                                    </div>
                                    @endif
                                </div>

                                <div class="w-full overflow-hidden mb-3">
                                    <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 mb-1 w-full">
                                        @if($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                            <span class="text-sm sm:text-lg font-sans font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                            <span class="text-[10px] sm:text-sm font-sans text-gray-400 line-through whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}</span>
                                            @if($product->discount_price && (float)$product->discount_price > 0)
                                                <span class="text-[9px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1 py-0.5 rounded whitespace-nowrap">Save {{ \App\Helpers\CurrencyHelper::format($product->discount_price) }}</span>
                                            @else
                                                <span class="text-[9px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1 py-0.5 rounded whitespace-nowrap">{{ round((1 - $product->price/$product->compare_price) * 100) }}% OFF</span>
                                            @endif
                                        @else
                                            <span class="text-sm sm:text-lg font-sans font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-900' }} whitespace-nowrap">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Add to Cart --}}
                                @if($product->stock > 0)
                                    <button onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)" type="button" class="w-full bg-slate-900 dark:bg-slate-800 dark:hover:bg-amber-500 hover:bg-black text-white text-[10px] sm:text-xs font-bold uppercase tracking-wider py-2 sm:py-3 rounded-xl transition duration-300 transform active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @else
                                    <button class="w-full bg-slate-100 dark:bg-slate-900 text-slate-400 dark:text-slate-600 text-[10px] sm:text-xs font-bold uppercase tracking-wider py-2 sm:py-3 rounded-xl cursor-not-allowed" disabled>
                                        Sold Out
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Empty filter state --}}
            <div id="no-products-message" class="hidden bg-white dark:bg-slate-900/30 rounded-2xl border border-slate-100 dark:border-white/5 p-12 text-center max-w-md mx-auto my-12">
                <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="text-slate-400 text-sm font-medium">No products found in this category.</p>
            </div>
        @endif

        {{-- Category Descriptions Container (Displayed below products) --}}
        <div class="mt-12">
            @foreach($categories as $category)
                @if($category->description)
                    <div class="filter-category-desc hidden bg-slate-50 dark:bg-slate-900/20 border border-slate-100 dark:border-white/5 rounded-3xl p-6 sm:p-8 max-w-4xl mx-auto shadow-sm" data-category-id="{{ $category->id }}">
                        <span class="text-amber-500 text-[10px] font-bold tracking-[0.2em] uppercase mb-2 block">ABOUT THE COLLECTION</span>
                        <h3 class="text-xl sm:text-2xl font-bold {{ $isTheme2 ? 'text-white' : 'text-slate-800' }} mb-3 font-serif uppercase">{{ $category->name }}</h3>
                        <p class="{{ $isTheme2 ? 'text-slate-300' : 'text-slate-650' }} text-sm font-light leading-relaxed whitespace-pre-line">{{ $category->description }}</p>
                    </div>
                @endif
            @endforeach
        </div>

    </main>
</div>

<script>
    function filterCategory(categoryId) {
        // 1. Update active category button styles
        const buttons = document.querySelectorAll('.category-filter-btn');
        buttons.forEach(btn => {
            if (btn.id === 'cat-btn-' + categoryId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // 2. Filter product cards
        const cards = document.querySelectorAll('.filter-product-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const cardCatId = card.getAttribute('data-category-id');
            if (categoryId === 'all' || cardCatId === categoryId) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // 3. Show / Hide empty state message
        const emptyState = document.getElementById('no-products-message');
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }

        // 4. Toggle Category Descriptions
        const descriptions = document.querySelectorAll('.filter-category-desc');
        descriptions.forEach(desc => {
            const descCatId = desc.getAttribute('data-category-id');
            if (categoryId !== 'all' && descCatId === categoryId) {
                desc.style.display = 'block';
            } else {
                desc.style.display = 'none';
            }
        });
    }

    // Force default state initialization on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterCategory('all');
    });
</script>
@endsection