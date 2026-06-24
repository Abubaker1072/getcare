@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')



{{-- Premium Products Header --}}
<section class="bg-[#FDFBF6] py-6 md:py-10 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <h1 class="text-3xl md:text-5xl font-extrabold text-[#0B132B] mb-2 tracking-tight">All Products</h1>
        <p class="text-base md:text-lg text-slate-500 font-medium">Discover our complete collection of premium beauty & skincare devices</p>
    </div>
</section>

{{-- Main Content Area with Sidebar --}}
<section class="py-4 md:py-6 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-4 lg:gap-10">
            
            {{-- Left Sidebar Filters --}}
            <aside id="shop-filter-aside" class="hidden lg:block w-full lg:w-[280px] flex-shrink-0 mb-4 lg:mb-0">
                <form id="shop-filters" action="{{ route('products.all') }}" method="GET" class="bg-white rounded-xl shadow-[0_2px_15px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 overflow-hidden sticky top-6 transition-all duration-500 transform hover:-translate-y-1">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if(request('price_range'))
                        <input type="hidden" name="price_range" value="{{ request('price_range') }}">
                    @endif
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="bg-[#0f172a] px-4 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-400 font-bold text-xs tracking-widest uppercase">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            FILTERS
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('products.all') }}" class="text-[11px] text-slate-300 hover:text-white transition-colors font-medium">Clear all</a>
                            <button type="button" onclick="toggleMobileFilters()" class="lg:hidden text-slate-300 hover:text-white text-xs font-bold font-sans">✕</button>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="mb-4">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-[11px] font-bold text-slate-800 tracking-wider uppercase">AVAILABILITY</span>
                            </div>
                            <label class="flex items-center justify-between cursor-pointer group transition-transform duration-300 hover:translate-x-1">
                                <div class="flex items-center gap-2.5 text-sm text-slate-600 group-hover:text-amber-600 transition-colors">
                                    <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()"
                                        {{ !empty($filters['in_stock']) ? 'checked' : '' }}
                                        class="w-3.5 h-3.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                    <span class="font-medium text-xs">In Stock</span>
                                </div>
                            </label>
                        </div>

                        <hr class="border-slate-100 mb-4">

                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-[11px] font-bold text-slate-800 tracking-wider uppercase">CATEGORIES</span>
                            </div>

                            <div class="relative mb-3 group/search">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 group-focus-within/search:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="category-search" placeholder="Search categories..."
                                    class="w-full pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-lg bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-all placeholder:text-slate-400 shadow-sm">
                            </div>

                            @if($categories->isEmpty())
                                <p class="text-xs text-slate-400">No categories available.</p>
                            @else
                            <div id="category-list" class="space-y-2.5 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($categories as $category)
                                <label class="category-item flex items-start justify-between cursor-pointer group transition-transform duration-300 hover:translate-x-1" data-name="{{ strtolower($category->name) }}">
                                    <div class="flex items-start gap-2.5 flex-1 pr-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" onchange="this.form.submit()"
                                            {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                                            class="w-3.5 h-3.5 mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer flex-shrink-0 transition-transform hover:scale-110">
                                        <span class="text-xs text-slate-600 group-hover:text-amber-600 font-medium leading-snug transition-colors">{{ $category->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-shrink-0 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <span class="text-[10px] font-bold bg-slate-50 text-slate-500 px-1.5 py-0.5 rounded-md border border-slate-100 shadow-sm">{{ $category->products_count ?? 0 }}</span>
                                        <a href="{{ route('category.detail', $category->slug) }}" class="text-slate-300 hover:text-amber-500 transition-colors transform hover:scale-110" title="View category">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </aside>

            {{-- Right Main Content --}}
            <div class="flex-1">
                {{-- Filter Bar --}}
                <form action="{{ route('products.all') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 pb-4 border-b border-slate-100">
                    @foreach($selectedCategories as $catId)
                        <input type="hidden" name="categories[]" value="{{ $catId }}">
                    @endforeach
                    @if(!empty($filters['in_stock']))
                        <input type="hidden" name="in_stock" value="1">
                    @endif
                    @if(request('price_range'))
                        <input type="hidden" name="price_range" value="{{ request('price_range') }}">
                    @endif
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="text-sm text-slate-500">
                        Showing <span class="font-bold text-slate-900">{{ $products->total() }}</span> products
                        @if(!empty($filters['search']))
                            for search "<span class="font-bold text-amber-600">{{ $filters['search'] }}</span>"
                        @endif
                        @if(!empty($selectedCategories))
                            <span class="text-amber-600 font-medium">(filtered)</span>
                        @endif
                    </div>
                    
                    {{-- Desktop Filter selectors (hidden on mobile) --}}
                    <div class="hidden lg:flex flex-row gap-3 sm:gap-4 items-center w-full sm:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <select name="sort" onchange="this.form.submit()"
                                class="w-full sm:w-44 pl-4 pr-10 py-2.5 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 bg-white cursor-pointer hover:border-slate-300 appearance-none outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
                                <option value="newest" {{ ($filters['sort'] ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ ($filters['sort'] ?? '') === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                            </select>
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <div class="relative">
                            <select name="price_range" onchange="this.form.submit()"
                                class="w-full sm:w-44 pl-4 pr-10 py-2.5 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 bg-white cursor-pointer hover:border-slate-300 appearance-none outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
                                <option value="">Price Range</option>
                                <option value="0-50" {{ request('price_range') === '0-50' ? 'selected' : '' }}>$0 - $50</option>
                                <option value="50-100" {{ request('price_range') === '50-100' ? 'selected' : '' }}>$50 - $100</option>
                                <option value="100-200" {{ request('price_range') === '100-200' ? 'selected' : '' }}>$100 - $200</option>
                                <option value="200+" {{ request('price_range') === '200+' ? 'selected' : '' }}>$200+</option>
                            </select>
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    {{-- Mobile Horizontal Scroll Filter Tags --}}
                    <div class="lg:hidden flex items-center gap-2 overflow-x-auto whitespace-nowrap scrollbar-none py-1.5 w-full">
                        <!-- Filters Tag -->
                        <button type="button" onclick="openFiltersDrawer('categories')" class="flex items-center gap-1.5 px-4.5 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition select-none flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.477 8 1.4V7a1 1 0 01-.293.707l-5.414 5.414A1 1 0 0014 13.828V18a1 1 0 01-.293.707l-2.929 2.929A1 1 0 019 20.93V13.83a1 1 0 00-.293-.708L3.293 7.707A1 1 0 013 7V4.4A19.98 19.98 0 0112 3z"></path>
                            </svg>
                            <span>Filters</span>
                        </button>

                        <!-- Sort Tag -->
                        <button type="button" onclick="openFiltersDrawer('sort')" class="flex items-center gap-1 px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition select-none flex-shrink-0">
                            <span>Sort by</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>

                        <!-- Price Tag -->
                        <button type="button" onclick="openFiltersDrawer('price')" class="flex items-center gap-1 px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition select-none flex-shrink-0">
                            <span>Price</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>

                        <!-- Availability Tag -->
                        <button type="button" onclick="openFiltersDrawer('availability')" class="flex items-center gap-1 px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition select-none flex-shrink-0">
                            <span>Availability</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                    </div>
                </form>

                {{-- Products Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-6 md:gap-8 mb-6">
                    @forelse($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 flex flex-col group">
                        {{-- Product Image Area --}}
                        <a href="{{ route('product.detail', $product->slug) }}" class="block relative bg-[#F8F9FA] h-32 sm:h-40 md:h-48 overflow-hidden">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-transform duration-700 ease-in-out {{ $product->stock <= 0 ? 'opacity-45 grayscale' : '' }}">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">No Image</div>
                            @endif
                            
                            @if($product->stock <= 0)
                            <div class="absolute top-4 right-4 bg-gray-500 text-white px-2 py-0.5 rounded text-[10px] font-sans font-bold uppercase tracking-wider shadow-md">
                                Sold Out
                            </div>
                            @endif
                            
                            {{-- Quick Add Overlay Button --}}
                            <div class="absolute bottom-4 left-4 right-4 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                @if($product->stock <= 0)
                                <button class="w-full bg-gray-200/90 text-gray-500 font-semibold py-3 rounded-lg shadow-lg cursor-not-allowed text-sm" disabled>
                                    Sold Out
                                </button>
                                @else
                                <button class="w-full bg-white/90 backdrop-blur-sm text-slate-900 font-semibold py-3 rounded-lg shadow-lg hover:bg-slate-900 hover:text-white transition-colors text-sm" onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)">
                                    Quick Add
                                </button>
                                @endif
                            </div>
                        </a>

                        {{-- Product Details --}}
                        <div class="p-4 flex flex-col flex-grow">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                <h3 class="font-bold text-slate-900 text-xs sm:text-sm md:text-base leading-snug mb-1 group-hover:text-amber-700 transition-colors line-clamp-2 break-words">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-1">
                                    <div class="flex text-amber-400 text-[10px] sm:text-xs">
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
                                <div class="text-[10px] sm:text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">
                                    {{ $product->purchased_count }}+ sold
                                </div>
                                @endif
                            </div>
                            @if($product->category)
                                <p class="text-xs text-amber-600 font-medium mb-2">{{ $product->category->name }}</p>
                            @endif


                            <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 mt-auto pt-4 border-t border-slate-100 w-full">
                                @if($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                    <span class="text-sm sm:text-lg font-sans font-bold text-slate-900 whitespace-nowrap">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</span>
                                    <span class="text-[10px] sm:text-sm font-sans text-gray-400 line-through whitespace-nowrap">{!! \App\Helpers\CurrencyHelper::format($product->compare_price) !!}</span>
                                    @if($product->discount_price && (float)$product->discount_price > 0)
                                        <span class="text-[10px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">Save {!! \App\Helpers\CurrencyHelper::format($product->discount_price) !!}</span>
                                    @else
                                        <span class="text-[10px] sm:text-xs font-sans font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">{{ round((1 - $product->price/$product->compare_price) * 100) }}% OFF</span>
                                    @endif
                                @else
                                    <span class="text-sm sm:text-lg font-sans font-bold text-slate-900 whitespace-nowrap">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-full text-center text-slate-500 py-10">
                            No products found.
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $products->links('partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
        {{-- 1. FEATURES / BENEFITS STRIP --}}
<section class="py-6 bg-white border-t border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-gray-100">
            
            {{-- Feature 1 --}}
            <div class="group flex flex-col items-center justify-center p-4 transition-transform duration-300 hover:-translate-y-1">
                <svg class="w-8 h-8 text-[#9b1c31] mb-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                <p class="text-[13px] md:text-sm text-gray-700 font-medium">Free Delivery on Orders {!! \App\Helpers\CurrencyHelper::format(43000) !!}+</p>
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

{{-- Mobile Filter Drawer (Bottom Sheet) --}}
<div id="filters-drawer-backdrop" onclick="closeFiltersDrawer()" class="fixed inset-0 bg-black/60 z-[90] hidden opacity-0 transition-opacity duration-300"></div>

<div id="filters-drawer" class="fixed bottom-0 left-0 right-0 h-[80vh] bg-white rounded-t-3xl shadow-2xl z-[100] flex flex-col transform translate-y-full transition-transform duration-300 ease-out overflow-hidden lg:hidden">
    <!-- Header of bottom sheet -->
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <span class="font-bold text-slate-900 text-sm tracking-wide">Filters & Sort</span>
        <button type="button" onclick="closeFiltersDrawer()" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Main split content -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Left Sidebar Tabs -->
        <div class="w-[120px] bg-[#f5f5f5] flex flex-col overflow-y-auto flex-shrink-0">
            <button type="button" onclick="switchFilterTab('categories')" id="drawer-tab-categories" class="drawer-tab px-4 py-4 text-left text-xs font-semibold text-slate-800 border-b border-slate-200 transition-colors bg-white border-l-4 border-l-[#ff470b]">
                Categories
            </button>
            <button type="button" onclick="switchFilterTab('price')" id="drawer-tab-price" class="drawer-tab px-4 py-4 text-left text-xs font-semibold text-slate-600 border-b border-slate-200 transition-colors hover:bg-white/50">
                Price Range
            </button>
            <button type="button" onclick="switchFilterTab('availability')" id="drawer-tab-availability" class="drawer-tab px-4 py-4 text-left text-xs font-semibold text-slate-600 border-b border-slate-200 transition-colors hover:bg-white/50">
                Availability
            </button>
            <button type="button" onclick="switchFilterTab('sort')" id="drawer-tab-sort" class="drawer-tab px-4 py-4 text-left text-xs font-semibold text-slate-600 border-b border-slate-200 transition-colors hover:bg-white/50">
                Sort By
            </button>
        </div>

        <!-- Right Content Panels -->
        <form id="mobile-filter-form" action="{{ route('products.all') }}" method="GET" class="flex-1 flex flex-col h-full m-0 overflow-hidden">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="flex-1 p-5 overflow-y-auto">
                <!-- Categories Panel -->
                <div id="drawer-panel-categories" class="drawer-panel block">
                    <h4 class="text-sm font-bold text-slate-900 mb-4">Select Categories</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <label class="mobile-pill-checkbox relative inline-flex items-center justify-center px-4 py-2 border border-slate-200 rounded-full text-xs font-medium cursor-pointer select-none transition-all duration-200 {{ in_array($category->id, $selectedCategories) ? 'bg-black border-black text-white' : 'bg-white text-slate-700 hover:border-slate-400' }}">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="hidden" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }} onchange="togglePillActive(this)">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Panel -->
                <div id="drawer-panel-price" class="drawer-panel hidden">
                    <h4 class="text-sm font-bold text-slate-900 mb-4">Select Price Range</h4>
                    <div class="flex flex-col gap-2">
                        @foreach([
                            '' => 'All Prices',
                            '0-50' => '$0 - $50',
                            '50-100' => '$50 - $100',
                            '100-200' => '$100 - $200',
                            '200+' => '$200+'
                        ] as $val => $lbl)
                            <label class="mobile-radio-row flex items-center justify-between p-3 border border-slate-200 rounded-xl text-xs font-medium cursor-pointer select-none {{ request('price_range') === $val ? 'bg-black/5 border-black' : 'bg-white text-slate-700' }}">
                                <span class="font-semibold text-slate-900">{{ $lbl }}</span>
                                <input type="radio" name="price_range" value="{{ $val }}" class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-slate-300" {{ request('price_range') === $val ? 'checked' : '' }} onchange="updateRadioRow(this)">
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Availability Panel -->
                <div id="drawer-panel-availability" class="drawer-panel hidden">
                    <h4 class="text-sm font-bold text-slate-900 mb-4">Availability</h4>
                    <div class="flex flex-col gap-2">
                        <label class="mobile-radio-row flex items-center justify-between p-3 border border-slate-200 rounded-xl text-xs font-medium cursor-pointer {{ !empty($filters['in_stock']) ? 'bg-black/5 border-black' : 'bg-white text-slate-700' }}">
                            <span class="font-semibold text-slate-900">In Stock Only</span>
                            <input type="radio" name="in_stock" value="1" class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-slate-300" {{ !empty($filters['in_stock']) ? 'checked' : '' }} onchange="updateRadioRow(this)">
                        </label>
                        <label class="mobile-radio-row flex items-center justify-between p-3 border border-slate-200 rounded-xl text-xs font-medium cursor-pointer {{ empty($filters['in_stock']) ? 'bg-black/5 border-black' : 'bg-white text-slate-700' }}">
                            <span class="font-semibold text-slate-900">Show All Products</span>
                            <input type="radio" name="in_stock" value="" class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-slate-300" {{ empty($filters['in_stock']) ? 'checked' : '' }} onchange="updateRadioRow(this)">
                        </label>
                    </div>
                </div>

                <!-- Sort By Panel -->
                <div id="drawer-panel-sort" class="drawer-panel hidden">
                    <h4 class="text-sm font-bold text-slate-900 mb-4">Sort Products</h4>
                    <div class="flex flex-col gap-2">
                        @foreach([
                            'newest' => 'Newest',
                            'price_asc' => 'Price: Low to High',
                            'price_desc' => 'Price: High to Low',
                            'name_asc' => 'Name A-Z'
                        ] as $val => $lbl)
                            <label class="mobile-radio-row flex items-center justify-between p-3 border border-slate-200 rounded-xl text-xs font-medium cursor-pointer select-none {{ ($filters['sort'] ?? 'newest') === $val ? 'bg-black/5 border-black' : 'bg-white text-slate-700' }}">
                                <span class="font-semibold text-slate-900">{{ $lbl }}</span>
                                <input type="radio" name="sort" value="{{ $val }}" class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-slate-300" {{ ($filters['sort'] ?? 'newest') === $val ? 'checked' : '' }} onchange="updateRadioRow(this)">
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sticky Action Bar -->
            <div class="flex items-center justify-between gap-4 p-4 border-t bg-white">
                <!-- Reset Button -->
                <a href="{{ route('products.all') }}" class="w-[30%] text-center py-3 border border-slate-300 text-slate-900 rounded-full text-sm font-bold hover:bg-slate-50 transition">
                    Reset
                </a>
                <!-- Submit / Apply Button -->
                <button type="submit" class="w-[65%] py-3 bg-[#ff470b] text-white rounded-full text-sm font-bold hover:bg-[#ff3300] shadow-md transition">
                    Show results
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Hide scrollbars but keep functionality */
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    document.getElementById('category-search')?.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('.category-item').forEach(item => {
            const name = item.dataset.name || '';
            item.style.display = name.includes(query) ? '' : 'none';
        });
    });

    function openFiltersDrawer(tabName = 'categories') {
        const drawer = document.getElementById('filters-drawer');
        const backdrop = document.getElementById('filters-drawer-backdrop');
        if (drawer && backdrop) {
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                drawer.classList.remove('translate-y-full');
                drawer.classList.add('translate-y-0');
            }, 10);
            switchFilterTab(tabName);
        }
    }

    function closeFiltersDrawer() {
        const drawer = document.getElementById('filters-drawer');
        const backdrop = document.getElementById('filters-drawer-backdrop');
        if (drawer && backdrop) {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            drawer.classList.remove('translate-y-0');
            drawer.classList.add('translate-y-full');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }
    }

    function switchFilterTab(tabName) {
        // 1. Reset all tabs
        document.querySelectorAll('.drawer-tab').forEach(tab => {
            tab.classList.remove('bg-white', 'text-slate-800', 'border-l-4', 'border-l-[#ff470b]');
            tab.classList.add('text-slate-600');
        });
        // 2. Set active tab
        const activeTab = document.getElementById('drawer-tab-' + tabName);
        if (activeTab) {
            activeTab.classList.remove('text-slate-600');
            activeTab.classList.add('bg-white', 'text-slate-800', 'border-l-4', 'border-l-[#ff470b]');
        }

        // 3. Hide all panels
        document.querySelectorAll('.drawer-panel').forEach(panel => {
            panel.classList.add('hidden');
            panel.classList.remove('block');
        });
        // 4. Show active panel
        const activePanel = document.getElementById('drawer-panel-' + tabName);
        if (activePanel) {
            activePanel.classList.remove('hidden');
            activePanel.classList.add('block');
        }
    }

    function togglePillActive(checkbox) {
        const label = checkbox.closest('.mobile-pill-checkbox');
        if (label) {
            if (checkbox.checked) {
                label.classList.add('bg-black', 'border-black', 'text-white');
                label.classList.remove('bg-white', 'text-slate-700');
            } else {
                label.classList.remove('bg-black', 'border-black', 'text-white');
                label.classList.add('bg-white', 'text-slate-700');
            }
        }
    }

    function updateRadioRow(radio) {
        const radioName = radio.name;
        document.querySelectorAll(`input[name="${radioName}"]`).forEach(input => {
            const row = input.closest('.mobile-radio-row');
            if (row) {
                if (input.checked) {
                    row.classList.add('bg-black/5', 'border-black');
                    row.classList.remove('bg-white', 'text-slate-700');
                } else {
                    row.classList.remove('bg-black/5', 'border-black');
                    row.classList.add('bg-white', 'text-slate-700');
                }
            }
        });
    }
</script>

@endsection