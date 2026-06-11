@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    {{-- Breadcrumb --}}
    <nav class="flex text-sm text-gray-500 mb-6 sm:mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="hover:text-amber-600 transition">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('categories') }}" class="hover:text-amber-600 transition">Health & Beauty</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-700 font-medium line-clamp-1" aria-current="page">EMS Foot Massager Mat</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-10 xl:gap-x-16">
            {{-- Image Gallery (Left) --}}
            <div class="flex flex-col-reverse lg:flex-row gap-4 lg:gap-6">
                {{-- Thumbnails --}}
                <div class="flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto lg:w-24 pb-2 lg:pb-0 hide-scrollbar">
                    @for($i=1; $i<=5; $i++)
                    <button class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-lg border-2 {{ $i==1 ? 'border-amber-500' : 'border-transparent hover:border-gray-300' }} overflow-hidden transition-all">
                        <img src="{{ asset('Products/Product Item 11/EMS Foot Massager ('.$i.').webp') }}" alt="Thumbnail" class="w-full h-full object-cover">
                    </button>
                    @endfor
                </div>
                
                {{-- Main Image --}}
                <div class="flex-1 w-full relative bg-gray-50 rounded-xl overflow-hidden aspect-square lg:aspect-auto">
                    <img src="{{ asset('Products/Product Item 11/EMS Foot Massager (1).webp') }}" alt="EMS Foot Massager" class="w-full h-full object-cover sm:object-contain object-center absolute inset-0">
                    <button class="absolute top-4 right-4 p-2 bg-white rounded-full shadow-md text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>

            {{-- Product Info (Right) --}}
            <div class="mt-8 lg:mt-0 pt-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight mb-2">EMS Foot Massager Mat - Muscle Stimulator</h1>
                
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
                    <div class="text-gray-600">Brand: <a href="#" class="text-blue-600 hover:underline">GetCare</a></div>
                </div>

                <hr class="my-4 border-gray-200">

                {{-- Price --}}
                <div class="mb-6">
                    <div class="flex items-end gap-3 mb-1">
                        <span class="text-3xl sm:text-4xl font-extrabold text-amber-600">₨ 2,500</span>
                        <span class="text-lg text-gray-500 line-through mb-1">₨ 4,000</span>
                        <span class="text-sm font-semibold text-green-600 mb-2">-37%</span>
                    </div>
                </div>

                {{-- Variants / Options --}}
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Color Family: <span class="text-gray-500 ml-1">Black</span></h3>
                    <div class="flex items-center gap-3">
                        <button class="w-12 h-12 rounded border-2 border-amber-500 p-0.5"><img src="{{ asset('Products/Product Item 11/EMS Foot Massager (1).webp') }}" class="w-full h-full object-cover rounded-sm"></button>
                        <button class="w-12 h-12 rounded border-2 border-gray-200 hover:border-amber-400 p-0.5 opacity-60"><img src="{{ asset('Products/Product Item 12/3 in 1 EMS Back Belt with Heating and RLT (1).webp') }}" class="w-full h-full object-cover rounded-sm"></button>
                    </div>
                </div>

                {{-- Quantity & Actions --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 mb-8 mt-8">
                    <div class="flex items-center border border-gray-300 rounded-md bg-white">
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">-</button>
                        <input type="number" value="1" min="1" class="w-12 text-center border-none focus:ring-0 text-gray-900 font-medium bg-transparent">
                        <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">+</button>
                    </div>
                    
                    <div class="flex-1 flex flex-col sm:flex-row gap-3 w-full">
                        <button class="flex-1 bg-amber-500 text-white px-6 py-3.5 rounded-md font-bold text-sm sm:text-base hover:bg-amber-600 transition shadow-lg shadow-amber-200 uppercase tracking-wide">
                            Buy Now
                        </button>
                        <button class="flex-1 bg-gray-900 text-white px-6 py-3.5 rounded-md font-bold text-sm sm:text-base hover:bg-gray-800 transition shadow-lg uppercase tracking-wide flex items-center justify-center gap-2" onclick="window.openCart(event)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Add to Cart
                        </button>
                    </div>
                </div>

                {{-- Highlights/Features List --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6">
                    <ul class="text-sm text-gray-700 space-y-2 list-disc list-inside">
                        <li>High quality EMS technology for muscle stimulation.</li>
                        <li>Portable and easy to clean.</li>
                        <li>Multiple massage modes and intensity levels.</li>
                        <li>USB rechargeable with long battery life.</li>
                        <li>1 Year Official GetCare Warranty.</li>
                    </ul>
                </div>
                
                {{-- Delivery Info --}}
                <div class="border-t border-gray-200 pt-4 text-sm text-gray-600 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Standard Delivery: <span class="font-semibold text-gray-900">3 - 5 Days</span> | ₨ 150</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Cash on Delivery Available</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>7 Days Return to Seller</span>
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
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm sm:text-base">
                    Ratings & Reviews (128)
                </a>
            </nav>
        </div>
        
        <div class="p-4 sm:p-6 lg:p-8 prose max-w-none text-gray-700 text-sm sm:text-base">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Detailed Description</h3>
            <p>Experience deep relaxation with the EMS Foot Massager Mat. Designed using cutting-edge Electrical Muscle Stimulation technology, this mat sends micro-currents through the soles of your feet to stimulate muscles, improve blood circulation, and relieve fatigue after a long day.</p>
            <p><strong>Key Benefits:</strong></p>
            <ul>
                <li>Promotes blood circulation.</li>
                <li>Relieves muscle tension and soreness.</li>
                <li>Compact design allows you to use it anywhere – at home, in the office, or while traveling.</li>
            </ul>
            <div class="my-6">
                <img src="{{ asset('Products/Product Item 11/EMS Foot Massager (2).webp') }}" alt="Detail Image" class="w-full max-w-2xl mx-auto rounded-lg shadow-sm">
            </div>
            <p>To use, simply place your bare feet on the mat, turn it on, and adjust the intensity to your comfort level. The mat is made from a soft, durable material that is easily wiped clean.</p>
        </div>
    </div>
</div>
@endsection