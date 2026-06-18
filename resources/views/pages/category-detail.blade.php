@extends('layouts.app')

@section('content')
<div class="bg-slate-50 pt-32 pb-16 min-h-screen">
    
    {{-- Category Hero Banner --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="relative bg-white rounded-[2rem] p-8 md:p-12 overflow-hidden shadow-sm border border-slate-200">
            {{-- Abstract aesthetic background elements --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-50 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-slate-100 rounded-full blur-3xl opacity-50 translate-y-1/3 -translate-x-1/3"></div>
            
            <div class="relative z-10">
                <nav class="flex text-[11px] font-bold tracking-widest uppercase text-slate-400 mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center hover:text-amber-600 transition-colors"><a href="{{ route('home') }}">Home</a></li>
                        <li><span class="text-slate-300">/</span></li>
                        <li class="inline-flex items-center hover:text-amber-600 transition-colors"><a href="{{ route('categories') }}">Categories</a></li>
                        <li><span class="text-slate-300">/</span></li>
                        <li class="inline-flex items-center text-slate-800">{{ $category->name }}</li>
                    </ol>
                </nav>
                
                <h1 class="text-4xl md:text-5xl font-light text-slate-900 tracking-tight mb-4">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-slate-500 font-light text-base md:text-lg max-w-3xl leading-relaxed">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Filters (Left) --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="font-bold text-gray-900 mb-4 text-lg">Filters</h2>
                    
                    {{-- Categories --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm uppercase tracking-wider">Related Categories</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('category.detail', $cat->slug) }}"
                                   class="hover:text-amber-600 {{ $cat->id === $category->id ? 'text-amber-600 font-medium' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- Main Content / Product Grid (Right) --}}
            <div class="flex-1">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <span class="text-sm text-gray-600">{{ $category->products_count ?? 0 }} products in this category</span>
                </div>

                @if($products->isEmpty())
                <div class="bg-white p-12 rounded-xl shadow-sm border border-gray-100 text-center">
                    <p class="text-gray-500">No products in this category yet.</p>
                    <a href="{{ route('products.all') }}" class="inline-block mt-4 text-amber-600 font-medium hover:underline">Browse all products</a>
                </div>
                @else
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group flex flex-col">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block relative h-32 sm:h-40 md:h-48 overflow-hidden bg-gray-50">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <a href="{{ route('product.detail', $product->slug) }}" class="text-sm font-bold text-gray-900 hover:text-amber-600 line-clamp-2 mb-1">{{ $product->name }}</a>
                            
                            <div class="flex items-center justify-between mb-2 mt-auto">
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
                                <div class="text-[10px] sm:text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                                    {{ $product->purchased_count ?? 0 }}+ bought
                                </div>
                            </div>

                            <p class="text-lg font-extrabold text-amber-600 mt-2">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
