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
                <div class="bg-white rounded-xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden sticky top-6">
                    
                    {{-- Filter Header --}}
                    <div class="bg-[#0f172a] px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-400 font-bold text-sm tracking-widest uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            FILTERS
                        </div>
                        <button class="text-xs text-slate-300 hover:text-white transition-colors font-medium">Clear all</button>
                    </div>

                    <div class="p-5">
                        {{-- Availability Section --}}
                        <div class="mb-6">
                            <button class="flex items-center justify-between w-full text-left mb-4 group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">AVAILABILITY</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform duration-300 transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center gap-3 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer transition-colors">
                                        <span class="font-medium">In Stock</span>
                                    </div>
                                    <span class="text-[11px] font-medium bg-slate-50 text-slate-500 px-2 py-0.5 rounded-full border border-slate-100">5040</span>
                                </label>
                            </div>
                        </div>

                        <hr class="border-slate-100 mb-6">

                        {{-- Categories Section --}}
                        <div>
                            <button class="flex items-center justify-between w-full text-left mb-4 group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">CATEGORIES</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform duration-300 transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Search Categories --}}
                            <div class="relative mb-5">
                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" placeholder="Search categories..." class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-all placeholder:text-slate-400">
                            </div>

                            {{-- Categories List --}}
                            <div class="space-y-3.5 max-h-[400px] overflow-y-auto pr-3 custom-scrollbar">
                                @php
                                    $categories = [
                                        ['name' => 'Playbook - Corporate Fun in the Sun Events', 'count' => 31],
                                        ['name' => 'ANSI Class 2', 'count' => 47],
                                        ['name' => 'ANSI Class 3', 'count' => 31],
                                        ['name' => 'Accessories', 'count' => 563],
                                        ['name' => 'Acid Washed', 'count' => 16],
                                        ['name' => 'Acrylic', 'count' => 10],
                                        ['name' => 'Activewear', 'count' => 673],
                                        ['name' => 'Activewear & Loungewear', 'count' => 129],
                                        ['name' => 'Adjustable', 'count' => 129],
                                        ['name' => 'Adjustable Hats', 'count' => 358],
                                        ['name' => 'Adult', 'count' => 1602],
                                        ['name' => 'All Responsible Materials', 'count' => 885],
                                        ['name' => 'AllPro Pro-Lock', 'count' => 17],
                                        ['name' => 'Antimicrobial', 'count' => 298],
                                    ];
                                @endphp

                                @foreach($categories as $category)
                                <label class="flex items-start justify-between cursor-pointer group">
                                    <div class="flex items-start gap-3 flex-1 pr-2">
                                        <input type="checkbox" class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500 cursor-pointer flex-shrink-0 transition-colors">
                                        <span class="text-sm text-slate-600 group-hover:text-slate-900 leading-snug transition-colors">{{ $category['name'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span class="text-[11px] font-medium bg-slate-50 text-slate-500 px-2 py-0.5 rounded-full border border-slate-100">{{ $category['count'] }}</span>
                                        <a href="#" class="text-slate-300 hover:text-amber-500 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Right Main Content --}}
            <div class="flex-1">
                {{-- Filter Bar --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
                    <div class="text-sm text-slate-500">
                        Showing <span class="font-bold text-slate-900">16</span> products
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        {{-- Sort By --}}
                        <div class="relative">
                            <select class="w-full sm:w-44 pl-4 pr-10 py-2.5 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 bg-white cursor-pointer hover:border-slate-300 appearance-none outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
                                <option>Sort By</option>
                                <option>Newest</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Best Selling</option>
                            </select>
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        {{-- Price Range --}}
                        <div class="relative">
                            <select class="w-full sm:w-44 pl-4 pr-10 py-2.5 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 bg-white cursor-pointer hover:border-slate-300 appearance-none outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
                                <option>Price Range</option>
                                <option>$0 - $50</option>
                                <option>$50 - $100</option>
                                <option>$100 - $200</option>
                                <option>$200+</option>
                            </select>
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @php
                        // Reusing the same product array from before
                        $allProducts = [
                            [
                                'name' => 'CurrentBody Skin LED Red Light Therapy Face Mask: Series 2',
                                'description' => 'FDA cleared LED face mask for advanced anti-aging',
                                'price' => 469.99,
                                'original_price' => 549.99,
                                'rating' => 4.8,
                                'reviews' => 1175,
                                'image' => 'product-1.jpg',
                            ],
                            // ... add rest of your products here ...
                            [
                                'name' => 'Anti-Aging Serum Pro',
                                'description' => 'Professional grade anti-aging serum with hyaluronic acid',
                                'price' => 79.99,
                                'original_price' => 99.99,
                                'rating' => 4.9,
                                'reviews' => 567,
                                'image' => 'product-6.jpg',
                            ],
                            [
                                'name' => 'Premium LED Mask Pro',
                                'description' => 'Advanced LED face mask with multiple light frequencies',
                                'price' => 399.99,
                                'original_price' => 499.99,
                                'rating' => 4.8,
                                'reviews' => 245,
                                'image' => 'product-5.jpg',
                            ]
                        ];
                    @endphp

                    @foreach($allProducts as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 flex flex-col group">
                        {{-- Product Image Area --}}
                        <a href="{{ route('product.detail', 11) }}" class="block relative bg-[#F8F9FA] aspect-[4/5] overflow-hidden">
                            <img src="{{ ImageHelper::getProductImage($product['image']) }}" 
                                 alt="{{ $product['name'] }}" 
                                 class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-transform duration-700 ease-in-out">
                            
                            {{-- Sale Badge --}}
                            <div class="absolute top-3 right-3 bg-[#831b1b] text-white px-3 py-1 rounded-sm text-[10px] font-bold tracking-widest uppercase shadow-md">
                                Sale
                            </div>

                            {{-- Quick Add Overlay Button --}}
                            <div class="absolute bottom-4 left-4 right-4 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                <button class="w-full bg-white/90 backdrop-blur-sm text-slate-900 font-semibold py-3 rounded-lg shadow-lg hover:bg-slate-900 hover:text-white transition-colors text-sm" onclick="event.preventDefault(); window.openCart(event)">
                                    Quick Add
                                </button>
                            </div>
                        </a>

                        {{-- Product Details --}}
                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Rating --}}
                            <div class="flex items-center gap-2 mb-3">
                                <div class="flex gap-0.5">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($product['rating']))
                                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-slate-400 font-medium">({{ $product['reviews'] }})</span>
                            </div>

                            <a href="{{ route('product.detail', 11) }}">
                                <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug mb-2 group-hover:text-amber-700 transition-colors">
                                    {{ $product['name'] }}
                                </h3>
                            </a>

                            <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2 flex-grow">
                                {{ $product['description'] }}
                            </p>

                            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-slate-100">
                                <span class="text-lg font-extrabold text-slate-900">${{ number_format($product['price'], 2) }}</span>
                                <span class="text-sm font-medium text-slate-400 line-through">${{ number_format($product['original_price'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Premium Pagination --}}
                <div class="flex items-center justify-center gap-2 mt-12 border-t border-slate-100 pt-8">
                    <button class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="w-10 h-10 bg-slate-900 text-white rounded-lg text-sm font-bold shadow-md">1</button>
                    <button class="w-10 h-10 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">2</button>
                    <button class="w-10 h-10 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">3</button>
                    <span class="px-2 text-slate-400 tracking-widest">...</span>
                    <button class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
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
    /* Elegant Custom Scrollbar for the Categories List */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

@endsection