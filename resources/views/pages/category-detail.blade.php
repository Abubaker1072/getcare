@extends('layouts.app')

@section('content')
<div class="bg-slate-50 pt-20 sm:pt-24 pb-16 min-h-screen">
    
    {{-- Top Category Navigation & Browse Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        {{-- Horizontal Scrollable Categories List --}}
        <div class="mb-6">
            <span class="block text-[10px] font-extrabold tracking-widest uppercase text-slate-400 mb-3">Browse Categories</span>
            <div class="flex overflow-x-auto flex-nowrap gap-2.5 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 hide-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .hide-scrollbar::-webkit-scrollbar { display: none; }
                </style>
                @foreach($categories as $cat)
                    <a href="{{ route('category.detail', $cat->slug) }}" 
                       class="inline-block whitespace-nowrap px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider transition-all duration-300 {{ $cat->id === $category->id ? 'bg-slate-900 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-950' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Lightweight Title Block --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <nav class="flex text-[10px] font-bold tracking-widest uppercase text-slate-400 mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center hover:text-amber-600 transition-colors"><a href="{{ route('home') }}">Home</a></li>
                        <li><span class="text-slate-300">/</span></li>
                        <li class="inline-flex items-center hover:text-amber-600 transition-colors"><a href="{{ route('categories') }}">Categories</a></li>
                        <li><span class="text-slate-300">/</span></li>
                        <li class="inline-flex items-center text-slate-800">{{ $category->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ $category->name }}</h1>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs text-slate-500 font-medium w-fit">
                <span>{{ $products->total() ?? ($category->products_count ?? 0) }} products available</span>
            </div>
        </div>
    </div>

    {{-- Main Products List --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full">
            @if($products->isEmpty())
            <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
                <p class="text-gray-500">No products in this category yet.</p>
                <a href="{{ route('products.all') }}" class="inline-block mt-4 text-amber-600 font-medium hover:underline">Browse all products</a>
            </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg transition-all duration-300 group flex flex-col p-3">
                    {{-- Product Image with contain and centered layout --}}
                    <a href="{{ route('product.detail', $product->slug) }}" class="block relative h-32 sm:h-40 md:h-48 overflow-hidden rounded-xl bg-slate-50/50 flex items-center justify-center p-3 sm:p-4">
                        @if($product->cover_image || $product->image)
                            <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-700 ease-out {{ $product->stock <= 0 ? 'opacity-45 grayscale' : '' }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                        @endif
                        
                        @if($product->stock <= 0)
                        <div class="absolute top-3 right-3 bg-gray-500 text-white px-2.5 py-0.5 rounded-full text-[9px] font-sans font-bold uppercase tracking-wider shadow-sm z-10">
                            Sold Out
                        </div>
                        @elseif($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                        <div class="absolute top-3 right-3 bg-red-600 text-white px-2.5 py-0.5 rounded-full text-[9px] font-sans font-bold uppercase tracking-wider shadow-sm z-10">
                            Sale
                        </div>
                        @endif
                    </a>
                    
                    {{-- Product Info --}}
                    <div class="p-2 pt-3 flex flex-col flex-grow">
                        {{-- Title --}}
                        <a href="{{ route('product.detail', $product->slug) }}" class="text-xs sm:text-sm font-bold text-gray-900 hover:text-amber-600 line-clamp-2 leading-tight mb-1 min-h-[2rem]">
                            {{ $product->name }}
                        </a>
                        
                        {{-- Description --}}
                        @if($product->description)
                            <p class="text-[11px] text-slate-500 font-light mt-1 mb-2 line-clamp-2 leading-relaxed flex-grow">
                                {{ strip_tags($product->description) }}
                            </p>
                        @endif
                        
                        {{-- Rating and reviews count --}}
                        <div class="flex items-center justify-between mb-2 mt-auto gap-1">
                            <div class="flex items-center gap-1 flex-shrink-0">
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
                                <span class="text-[9px] sm:text-xs text-gray-500">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            @if(($product->purchased_count ?? 0) > 0)
                            <div class="text-[9px] sm:text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">
                                {{ $product->purchased_count }}+ sold
                            </div>
                            @endif
                        </div>

                        {{-- Price --}}
                        <div class="flex flex-wrap items-center gap-1.5 mb-3">
                            <span class="text-sm sm:text-base font-sans font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</span>
                            @if($product->is_on_sale && $product->compare_price && $product->compare_price > $product->price)
                                <span class="text-[10px] sm:text-xs text-slate-400 line-through font-sans">{!! \App\Helpers\CurrencyHelper::format($product->compare_price) !!}</span>
                            @endif
                        </div>

                        {{-- Add to Cart --}}
                        <div class="mt-auto">
                            @if($product->stock <= 0)
                                <button class="w-full bg-slate-100 text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider py-2.5 rounded-xl cursor-not-allowed" disabled>
                                    Sold Out
                                </button>
                            @else
                                <button onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)" class="w-full bg-slate-900 hover:bg-black text-white text-[10px] sm:text-xs font-bold uppercase tracking-wider py-2.5 rounded-xl transition duration-300 transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">{{ $products->links('partials.pagination') }}</div>
            @endif

            {{-- Category Description Box (Positioned at the bottom) --}}
            @if($category->description)
            <div class="mt-12 bg-white rounded-[2rem] p-6 sm:p-8 overflow-hidden shadow-sm border border-slate-200 relative">
                <div class="absolute top-0 right-0 w-80 h-80 bg-amber-50/60 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-slate-100/50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mb-3">About {{ $category->name }}</h2>
                    <p class="text-slate-500 font-light text-sm sm:text-base max-w-3xl leading-relaxed">{{ $category->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
