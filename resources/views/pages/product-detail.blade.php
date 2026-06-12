@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    {{-- Breadcrumb --}}
    <nav class="flex text-sm text-gray-500 mb-6 sm:mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-amber-600 transition">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('products.all') }}" class="hover:text-amber-600 transition">Shop</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-700 font-medium line-clamp-1" aria-current="page">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-10 xl:gap-x-16">
            {{-- Image Gallery (Left) --}}
            <div class="flex flex-col-reverse lg:flex-row gap-4 lg:gap-6">
                {{-- Thumbnails --}}
                <div class="flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto lg:w-24 pb-2 lg:pb-0 hide-scrollbar" id="product-thumbnails">
                    @foreach(['image', 'image_1', 'image_2', 'image_3', 'image_4'] as $imgField)
                        @if($product->$imgField)
                        <button onclick="document.getElementById('main-product-image').src='{{ asset('storage/' . $product->$imgField) }}'" class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-lg border-2 border-transparent hover:border-amber-500 focus:border-amber-500 overflow-hidden transition-all">
                            <img src="{{ asset('storage/' . $product->$imgField) }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </button>
                        @endif
                    @endforeach
                </div>
                
                {{-- Main Image --}}
                <div class="flex-1 w-full relative bg-gray-50 rounded-xl overflow-hidden aspect-square lg:aspect-auto">
                    @if($product->cover_image || $product->image)
                        <img id="main-product-image" src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover sm:object-contain object-center absolute inset-0">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 absolute inset-0">No Image Available</div>
                    @endif
                </div>
            </div>

            {{-- Product Info (Right) --}}
            <div class="mt-8 lg:mt-0 pt-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight mb-2">{{ $product->name }}</h1>
                
                {{-- Ratings & Brand --}}
                <div class="flex flex-wrap items-center gap-4 mb-4 text-sm">
                    <div class="flex items-center">
                        <div class="flex text-amber-400">
                            @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 {{ $i<4 ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <a href="#" class="ml-2 text-blue-600 hover:underline">128 Ratings</a>
                    </div>
                    <span class="text-gray-300">|</span>
                    <div class="text-gray-600">Stock: <span class="text-gray-900 font-semibold">{{ $product->stock }}</span></div>
                </div>

                <hr class="my-4 border-gray-200">

                {{-- Price --}}
                <div class="mb-6">
                    <div class="flex flex-wrap items-end gap-3 mb-1">
                        <span class="text-3xl sm:text-4xl font-extrabold text-amber-600">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="text-xl text-gray-400 line-through mb-1">${{ number_format($product->compare_price, 2) }}</span>
                        @endif
                        @if($product->discount_price && $product->discount_price > 0)
                            <span class="text-sm font-bold text-green-600 bg-green-100 px-2 py-1 rounded-md mb-2">Save ${{ number_format($product->discount_price, 2) }}</span>
                        @elseif($product->compare_price && $product->compare_price > $product->price)
                            <span class="text-sm font-bold text-green-600 bg-green-100 px-2 py-1 rounded-md mb-2">{{ round((1 - $product->price / $product->compare_price) * 100) }}% OFF</span>
                        @endif
                    </div>
                </div>

                {{-- Quantity & Actions --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 mb-8 mt-8">
                    <div class="flex items-center border border-gray-300 rounded-md bg-white">
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">-</button>
                        <input type="number" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-none focus:ring-0 text-gray-900 font-medium bg-transparent">
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">+</button>
                    </div>
                    
                    <div class="flex-1 flex flex-col sm:flex-row gap-3 w-full">
                        <button class="flex-1 bg-amber-500 text-white px-6 py-3.5 rounded-md font-bold text-sm sm:text-base hover:bg-amber-600 transition shadow-lg shadow-amber-200 uppercase tracking-wide" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            Buy Now
                        </button>
                        <button class="flex-1 bg-gray-900 text-white px-6 py-3.5 rounded-md font-bold text-sm sm:text-base hover:bg-gray-800 transition shadow-lg uppercase tracking-wide flex items-center justify-center gap-2" onclick="window.openCart(event)" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Add to Cart
                        </button>
                    </div>
                    @if($product->stock <= 0)
                        <div class="text-red-500 font-bold mt-2">Out of Stock</div>
                    @endif
                </div>
                
                {{-- Delivery Info --}}
                <div class="border-t border-gray-200 pt-4 text-sm text-gray-600 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Standard Delivery: <span class="font-semibold text-gray-900">3 - 5 Days</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs: Description / Reviews --}}
    <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px px-4 sm:px-6 lg:px-8" aria-label="Tabs">
                <a href="#" class="border-amber-500 text-amber-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm sm:text-base mr-8">
                    Product Description
                </a>
            </nav>
        </div>
        
        <div class="p-4 sm:p-6 lg:p-8 prose max-w-none text-gray-700 text-sm sm:text-base">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Detailed Description</h3>
            <p>{{ $product->description ?? 'No description available for this product.' }}</p>
        </div>
    </div>
</div>
@endsection