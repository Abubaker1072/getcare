@extends('layouts.app')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')

{{-- Top Promotional Banner --}}
<div class="bg-[#831b1b] text-white py-2.5 px-4">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 text-sm font-medium tracking-wide">
        <a href="#" class="hover:underline underline-offset-4 decoration-white/70 transition-all">
            Up to 20% Off | Code REFRESH20
        </a>
        
        {{-- Simulated Countdown Timer --}}
        <div class="flex items-center gap-4 text-xs font-bold font-mono">
            <div class="flex flex-col items-center">
                <span class="text-lg leading-none">23</span>
                <span class="text-[10px] uppercase text-white/80 mt-0.5">HRS</span>
            </div>
            <span class="text-lg leading-none pb-3">:</span>
            <div class="flex flex-col items-center">
                <span class="text-lg leading-none">59</span>
                <span class="text-[10px] uppercase text-white/80 mt-0.5">MIN</span>
            </div>
            <span class="text-lg leading-none pb-3">:</span>
            <div class="flex flex-col items-center">
                <span class="text-lg leading-none">42</span>
                <span class="text-[10px] uppercase text-white/80 mt-0.5">SEC</span>
            </div>
        </div>
    </div>
</div>

{{-- Premium Products Header --}}
<section class="bg-[#FDFBF6] py-10 md:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <h1 class="text-3xl md:text-5xl font-extrabold text-[#0B132B] mb-3 tracking-tight">All Products</h1>
        <p class="text-base md:text-lg text-slate-500 font-medium">Discover our complete collection of premium beauty & skincare devices</p>
    </div>
</section>

{{-- Main Content Area with Sidebar --}}
<section class="py-8 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            
            {{-- Left Sidebar Filters --}}
            <aside class="w-full lg:w-[280px] flex-shrink-0">
                <form id="shop-filters" action="{{ route('products.all') }}" method="GET" class="bg-white rounded-xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden sticky top-6">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if(request('price_range'))
                        <input type="hidden" name="price_range" value="{{ request('price_range') }}">
                    @endif

                    <div class="bg-[#0f172a] px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-400 font-bold text-sm tracking-widest uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            FILTERS
                        </div>
                        <a href="{{ route('products.all') }}" class="text-xs text-slate-300 hover:text-white transition-colors font-medium">Clear all</a>
                    </div>

                    <div class="p-5">
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">AVAILABILITY</span>
                            </div>
                            <label class="flex items-center justify-between cursor-pointer group">
                                <div class="flex items-center gap-3 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                                    <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()"
                                        {{ !empty($filters['in_stock']) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                    <span class="font-medium">In Stock</span>
                                </div>
                            </label>
                        </div>

                        <hr class="border-slate-100 mb-6">

                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">CATEGORIES</span>
                            </div>

                            <div class="relative mb-5">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="category-search" placeholder="Search categories..."
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-all placeholder:text-slate-400">
                            </div>

                            @if($categories->isEmpty())
                                <p class="text-sm text-slate-400">No categories available.</p>
                            @else
                            <div id="category-list" class="space-y-3.5 max-h-[400px] overflow-y-auto pr-3 custom-scrollbar">
                                @foreach($categories as $category)
                                <label class="category-item flex items-start justify-between cursor-pointer group" data-name="{{ strtolower($category->name) }}">
                                    <div class="flex items-start gap-3 flex-1 pr-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" onchange="this.form.submit()"
                                            {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                                            class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer flex-shrink-0">
                                        <span class="text-sm text-slate-600 group-hover:text-slate-900 leading-snug transition-colors">{{ $category->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span class="text-[11px] font-medium bg-slate-50 text-slate-500 px-2 py-0.5 rounded-full border border-slate-100">{{ $category->products_count ?? 0 }}</span>
                                        <a href="{{ route('category.detail', $category->slug) }}" class="text-slate-300 hover:text-amber-500 transition-colors" title="View category">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
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
                <form action="{{ route('products.all') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
                    @foreach($selectedCategories as $catId)
                        <input type="hidden" name="categories[]" value="{{ $catId }}">
                    @endforeach
                    @if(!empty($filters['in_stock']))
                        <input type="hidden" name="in_stock" value="1">
                    @endif
                    @if(request('price_range'))
                        <input type="hidden" name="price_range" value="{{ request('price_range') }}">
                    @endif

                    <div class="text-sm text-slate-500">
                        Showing <span class="font-bold text-slate-900">{{ $products->total() }}</span> products
                        @if(!empty($selectedCategories))
                            <span class="text-amber-600 font-medium">(filtered)</span>
                        @endif
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <div class="relative">
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
                </form>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @forelse($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 flex flex-col group">
                        {{-- Product Image Area --}}
                        <a href="{{ route('product.detail', $product->slug) }}" class="block relative bg-[#F8F9FA] aspect-[4/5] overflow-hidden">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">No Image</div>
                            @endif
                            
                            {{-- Quick Add Overlay Button --}}
                            <div class="absolute bottom-4 left-4 right-4 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                <button class="w-full bg-white/90 backdrop-blur-sm text-slate-900 font-semibold py-3 rounded-lg shadow-lg hover:bg-slate-900 hover:text-white transition-colors text-sm" onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)">
                                    Quick Add
                                </button>
                            </div>
                        </a>

                        {{-- Product Details --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug mb-1 group-hover:text-amber-700 transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            @if($product->category)
                                <p class="text-xs text-amber-600 font-medium mb-2">{{ $product->category->name }}</p>
                            @endif

                            <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2 flex-grow">
                                {{ $product->description }}
                            </p>

                            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-slate-100">
                                <span class="text-lg font-extrabold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</span>
                                @if($product->compare_price)
                                    <span class="text-sm text-slate-400 line-through">{!! \App\Helpers\CurrencyHelper::format($product->compare_price) !!}</span>
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
                <div class="mt-12 border-t border-slate-100 pt-8">
                    {{ $products->links() }}
                </div>
            </div>
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

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<script>
    document.getElementById('category-search')?.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('.category-item').forEach(item => {
            const name = item.dataset.name || '';
            item.style.display = name.includes(query) ? '' : 'none';
        });
    });
</script>

@endsection