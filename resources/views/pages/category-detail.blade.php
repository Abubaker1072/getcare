@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb & Title --}}
        <div class="mb-8">
            <nav class="flex text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center"><a href="{{ route('home') }}" class="hover:text-amber-600">Home</a></li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <a href="{{ route('categories') }}" class="hover:text-amber-600">Categories</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-gray-700">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-500 mt-2 max-w-2xl">{{ $category->description }}</p>
            @endif
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
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-gray-50">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>
                        <div class="p-4">
                            <a href="{{ route('product.detail', $product->slug) }}" class="text-sm font-medium text-gray-900 hover:text-amber-600 line-clamp-2">{{ $product->name }}</a>
                            <p class="text-lg font-bold text-amber-600 mt-2">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</p>
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
