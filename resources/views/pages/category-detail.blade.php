@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb & Title --}}
        <div class="mb-8">
            <nav class="flex text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center"><a href="{{ route('products.index') }}" class="hover:text-amber-600">Home</a></li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-gray-700">Health & Beauty</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 capitalize">{{ str_replace('-', ' ', $slug ?? 'Health & Beauty') }}</h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Filters (Left) --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="font-bold text-gray-900 mb-4 text-lg">Filters</h2>
                    
                    {{-- Categories --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm uppercase tracking-wider">Related Categories</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-amber-600 text-amber-600 font-medium">Massagers & Relaxers</a></li>
                            <li><a href="#" class="hover:text-amber-600">Skin Care Tools</a></li>
                            <li><a href="#" class="hover:text-amber-600">Hair Care</a></li>
                            <li><a href="#" class="hover:text-amber-600">Personal Care</a></li>
                        </ul>
                    </div>

                    <hr class="border-gray-100 my-4">

                    {{-- Brand --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm uppercase tracking-wider">Brand</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                <span class="text-sm text-gray-600">GetCare</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                                <span class="text-sm text-gray-600">No Brand</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    {{-- Price --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm uppercase tracking-wider">Price</h3>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="Min" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:border-amber-500 outline-none">
                            <span class="text-gray-400">-</span>
                            <input type="number" placeholder="Max" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:border-amber-500 outline-none">
                            <button class="bg-gray-200 p-1.5 rounded hover:bg-gray-300 transition"><svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content / Product Grid (Right) --}}
            <div class="flex-1">
                {{-- Toolbar --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-sm text-gray-600">Showing 1-12 of 124 items</span>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Sort by:</span>
                        <select class="border-gray-300 rounded-md text-sm focus:ring-amber-500 focus:border-amber-500 outline-none cursor-pointer">
                            <option>Best Match</option>
                            <option>Price Low to High</option>
                            <option>Price High to Low</option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @php
                        $products = [
                            ['id' => 11, 'name' => 'EMS Foot Massager Mat', 'price' => '2,500', 'old_price' => '4,000', 'rating' => 4.5, 'reviews' => 128, 'image' => 'Product Item 11/EMS Foot Massager (1).webp'],
                            ['id' => 12, 'name' => '3 IN 1 Lower Back Brace Belt', 'price' => '4,200', 'old_price' => '6,000', 'rating' => 4.8, 'reviews' => 84, 'image' => 'Product Item 12/3 in 1 EMS Back Belt with Heating and RLT (1).webp'],
                            ['id' => 13, 'name' => 'Back Belt Stimulator with Heating', 'price' => '3,800', 'old_price' => '5,500', 'rating' => 4.2, 'reviews' => 45, 'image' => 'Product Item 13/3 IN 1 Lower Back Brace Belt Stimulator with Heating and Red Light Therapy (1).webp'],
                            ['id' => 14, 'name' => 'Back Belt with Tourmaline', 'price' => '4,500', 'old_price' => '6,500', 'rating' => 4.9, 'reviews' => 210, 'image' => 'Product Item 14/3 IN 1 Lower Back Brace Belt Stimulator with Heating and Tourmaline (1).webp'],
                            ['id' => 10, 'name' => 'EMS Foot Massage Pad', 'price' => '2,200', 'old_price' => '3,500', 'rating' => 4.0, 'reviews' => 32, 'image' => 'Product Item 10/EMS Foot Massage Mat (1).webp'],
                            ['id' => 1, 'name' => 'Premium Skin Care Device', 'price' => '5,000', 'old_price' => '7,500', 'rating' => 4.7, 'reviews' => 156, 'image' => 'Product Item 1/1.webp'],
                        ];
                    @endphp

                    @foreach($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
                        {{-- Image --}}
                        <a href="{{ route('product.detail', $product['id']) }}" class="relative aspect-square block overflow-hidden bg-gray-50">
                            <img src="{{ asset('Products/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-2 right-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded">-37%</div>
                        </a>
                        
                        {{-- Info --}}
                        <div class="p-3 sm:p-4 flex flex-col flex-1">
                            <a href="{{ route('product.detail', $product['id']) }}" class="text-sm sm:text-base font-medium text-gray-900 line-clamp-2 mb-1 hover:text-amber-600 transition">{{ $product['name'] }}</a>
                            
                            <div class="mt-auto pt-2">
                                <div class="flex items-end gap-2 mb-1">
                                    <span class="text-lg font-bold text-amber-600">₨ {{ $product['price'] }}</span>
                                    <span class="text-xs text-gray-400 line-through mb-0.5">₨ {{ $product['old_price'] }}</span>
                                </div>
                                
                                <div class="flex items-center gap-1 mb-3">
                                    <div class="flex text-amber-400">
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </div>
                                    <span class="text-[10px] text-gray-500">({{ $product['reviews'] }})</span>
                                </div>
                                
                                <button class="w-full py-2 border border-amber-500 text-amber-600 rounded text-sm font-medium hover:bg-amber-50 transition" onclick="window.openCart(event)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center gap-2">
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-gray-50" disabled>&lt;</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-amber-500 text-white font-medium">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</button>
                        <span class="text-gray-500">...</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&gt;</button>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection