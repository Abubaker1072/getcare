@extends('layouts.app')

@section('content')
<style>
    /* Add smooth transitions for accordions */
    details > summary { list-style: none; }
    details > summary::-webkit-details-marker { display: none; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .reel-swiper { padding: 40px 0; }
    .swiper-slide { transition: transform 0.3s ease, opacity 0.3s ease; opacity: 0.5; transform: scale(0.85); }
    .swiper-slide-active { opacity: 1; transform: scale(1); }
    .swiper-button-next, .swiper-button-prev { color: #fff; background-color: rgba(0, 0, 0, 0.2); border-radius: 50%; width: 40px; height: 40px; }
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 16px; }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

{{-- Added pb-24 to accommodate the sticky bottom bar --}}
<div class="w-full pb-24 font-sans text-gray-800">
    
    {{-- Main Product Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb (Preserved) --}}
        <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
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
                        <span class="text-gray-900 font-medium line-clamp-1" aria-current="page">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            
            {{-- Image Gallery (Left) --}}
            <div class="flex flex-col gap-4 lg:gap-6">
                {{-- Main Image --}}
                <div class="w-11/12 sm:w-4/5 xl:w-3/4 mx-auto relative bg-gray-50 rounded-2xl overflow-hidden aspect-[4/5] sm:aspect-square flex items-center justify-center p-8">
                    @if($product->cover_image || $product->image)
                        <img id="main-product-image" src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-contain object-center transition-transform duration-500 hover:scale-125 cursor-zoom-in">
                    @else
                        <div class="text-gray-400">No Image Available</div>
                    @endif
                </div>

                {{-- Thumbnails --}}
                <div class="flex justify-center gap-4 overflow-x-auto pb-2 hide-scrollbar" id="product-thumbnails">
                    @foreach(['image', 'image_1', 'image_2', 'image_3', 'image_4'] as $imgField)
                        @if($product->$imgField)
                        <button onclick="document.getElementById('main-product-image').src='{{ asset('storage/' . $product->$imgField) }}'" class="flex-shrink-0 w-20 h-20 rounded-lg border border-gray-200 hover:border-gray-800 focus:border-gray-800 overflow-hidden transition-all bg-gray-50 p-2">
                            <img src="{{ asset('storage/' . $product->$imgField) }}" alt="Thumbnail" class="w-full h-full object-contain">
                        </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Product Info (Right) --}}
            <div class="mt-10 lg:mt-0">
                
                {{-- Tags (Dynamic) --}}
                @if($product->tags)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach(explode(',', $product->tags) as $tag)
                        @if(trim($tag) !== '')
                            <span class="border border-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full">{{ trim($tag) }}</span>
                        @endif
                    @endforeach
                </div>
                @endif

                <h1 class="text-3xl sm:text-4xl font-serif text-gray-900 tracking-tight mb-3">{{ $product->name }}</h1>
                
                {{-- Ratings & Stock (Preserved) --}}
                <div class="flex flex-wrap items-center gap-3 mb-6 text-sm">
                    <div class="flex items-center">
                        <div class="flex text-amber-400">
                            @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 {{ $i<4 ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <a href="#reviews" class="ml-2 text-gray-500 hover:text-gray-900 underline decoration-gray-300">{{ $product->reviews->count() }} Ratings</a>
                    </div>
                    <span class="text-gray-300">|</span>
                    <div class="text-gray-500">Stock: <span class="text-gray-900 font-medium">{{ $product->stock }}</span></div>
                </div>

                {{-- Price Logic (Preserved) --}}
                <div class="mb-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-2xl font-serif text-gray-900">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                        @if($product->compare_price)
                            <span class="text-lg text-gray-400 line-through">{{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}</span>
                        @endif
                        
                        @if($product->discount_price && (float)$product->discount_price > 0)
                            <span class="text-xs font-bold text-[#c45a49] bg-[#f8f0ec] px-2 py-1 rounded">Save {{ \App\Helpers\CurrencyHelper::format($product->discount_price) }}</span>
                        @elseif($product->compare_price && $product->compare_price > $product->price)
                            <span class="text-xs font-bold text-[#c45a49] bg-[#f8f0ec] px-2 py-1 rounded">{{ round((1 - $product->price / $product->compare_price) * 100) }}% OFF</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Tax included.</p>
                </div>

                {{-- Add to Cart & Buy Now Actions (Preserved functionality, updated design) --}}
                <div class="flex flex-col gap-3 mb-6 mt-6">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        {{-- Quantity --}}
                        <div class="flex items-center border border-gray-300 rounded-full bg-white h-12 px-2 w-full sm:w-32 justify-between">
                            <button type="button" onclick="let input = document.getElementById('product-qty'); if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black transition">−</button>
                            <input type="number" id="product-qty" value="1" min="1" max="{{ $product->stock }}" class="w-10 text-center border-none focus:ring-0 text-gray-900 font-medium bg-transparent p-0 m-0 appearance-none">
                            <button type="button" onclick="let input = document.getElementById('product-qty'); if(parseInt(input.value) < {{ $product->stock }}) input.value = parseInt(input.value) + 1;" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black transition">+</button>
                        </div>
                        
                        {{-- Add to Cart --}}
                        <button class="flex-1 w-full bg-[#1a1a1a] text-white h-12 rounded-full font-semibold text-sm tracking-widest hover:bg-black transition flex items-center justify-center" onclick="window.addToCart({{ $product->id }}, parseInt(document.getElementById('product-qty').value))" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            ADD TO CART
                        </button>
                    </div>

                    {{-- Buy Now (Kept as requested) --}}
                    <button onclick="window.buyNow({{ $product->id }})" class="w-full border border-[#1a1a1a] text-[#1a1a1a] h-12 rounded-full font-semibold text-sm tracking-widest hover:bg-gray-50 transition flex items-center justify-center" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        BUY IT NOW
                    </button>
                    
                    @if($product->stock <= 0)
                        <div class="text-red-500 font-bold mt-1 text-center">Out of Stock</div>
                    @endif
                </div>

                {{-- Promo Banner (Dynamic) --}}
                @if($product->promo_text)
                <div class="bg-[#fcf5f3] text-[#b35e53] text-sm text-center py-3 rounded-md mb-8 font-medium">
                    {{ $product->promo_text }}
                </div>
                @endif

                {{-- Bullet Points (Dynamic) --}}
                @if($product->bullet_points && is_array($product->bullet_points) && count(array_filter($product->bullet_points)) > 0)
                <ul class="text-gray-700 space-y-2 mb-8 text-sm">
                    @foreach($product->bullet_points as $point)
                        @if(trim($point) !== '')
                            <li class="flex items-start"><span class="mr-2">•</span> {{ $point }}</li>
                        @endif
                    @endforeach
                </ul>
                @endif

                {{-- Feature Icons (Dynamic) --}}
                @if($product->features && is_array($product->features) && count($product->features) > 0)
                <div class="flex flex-wrap gap-6 py-6 border-y border-gray-200 mb-8">
                    @foreach($product->features as $feature)
                        @if($feature === 'Cruelty-free')
                        <div class="flex flex-col items-center text-center">
                            <svg class="w-8 h-8 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            <span class="text-[10px] text-gray-500 uppercase tracking-wider">Cruelty-free</span>
                        </div>
                        @elseif($feature === 'Gluten-free')
                        <div class="flex flex-col items-center text-center">
                            <svg class="w-8 h-8 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-[10px] text-gray-500 uppercase tracking-wider">Gluten-free</span>
                        </div>
                        @elseif($feature === 'Recyclable')
                        <div class="flex flex-col items-center text-center">
                            <svg class="w-8 h-8 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span class="text-[10px] text-gray-500 uppercase tracking-wider">Recyclable</span>
                        </div>
                        @elseif($feature === 'Vegan')
                        <div class="flex flex-col items-center text-center">
                            <svg class="w-8 h-8 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <span class="text-[10px] text-gray-500 uppercase tracking-wider">Vegan</span>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif

                {{-- Accordions (Dynamic) --}}
                <div class="border-t border-gray-200">
                    <details class="group py-4 border-b border-gray-200 cursor-pointer" open>
                        <summary class="flex justify-between items-center font-serif text-lg text-gray-900 outline-none">
                            Description
                            <span class="transition duration-300 group-open:-rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <div class="pt-4 text-gray-600 text-sm leading-relaxed">
                            {!! $product->description ?? 'No description available for this product.' !!}
                        </div>
                    </details>

                    @if($product->how_to_use)
                    <details class="group py-4 border-b border-gray-200 cursor-pointer">
                        <summary class="flex justify-between items-center font-serif text-lg text-gray-900 outline-none">
                            How to use
                            <span class="transition duration-300 group-open:-rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <div class="pt-4 text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {!!$product->how_to_use !!} 

                        </div>
                    </details>
                    @endif

                    @if($product->ingredients)
                    <details class="group py-4 border-b border-gray-200 cursor-pointer">
                        <summary class="flex justify-between items-center font-serif text-lg text-gray-900 outline-none">
                            Ingredients
                            <span class="transition duration-300 group-open:-rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <div class="pt-4 text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {!! nl2br(e($product->ingredients)) !!}
                        </div>
                    </details>
                    @endif
                </div>



            </div>
        </div>
    </div>

    {{-- Banner Section: Created in Harmony --}}
    <div class="w-full h-96 relative mt-16 flex items-center justify-center text-center">
        @if($product->banner_image)
            <img src="{{ asset('storage/' . $product->banner_image) }}" alt="Natural Ingredients" class="absolute inset-0 w-full h-full object-cover">
        @else
            <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?auto=format&fit=crop&w=1920&q=80" alt="Natural Ingredients" class="absolute inset-0 w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="relative z-10 px-4">
            <p class="text-white text-sm sm:text-base mb-2 tracking-wide">Created In Harmony with Nature</p>
            <h2 class="text-4xl sm:text-6xl font-serif text-white leading-tight">100% Natural<br>Ingredients</h2>
        </div>
    </div>

    {{-- Daily Routine / Testimonials Section --}}
    @if($product->testimonials && $product->testimonials->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
        <h2 class="text-3xl sm:text-4xl font-serif text-gray-900 mb-8">Your Daily Routine</h2>
        
        <div class="flex overflow-x-auto gap-6 hide-scrollbar snap-x pb-8 justify-center">
            @foreach($product->testimonials as $testimonial)
            <div class="min-w-[240px] w-full max-w-[280px] flex-shrink-0 snap-center">
                <div class="relative rounded-2xl overflow-hidden aspect-[4/5] mb-4 shadow-md group">
                    <img src="{{ asset('storage/' . $testimonial->image_path) }}" alt="Daily Routine Testimonial" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                @if($testimonial->caption)
                <h3 class="font-bold text-gray-900 mb-2">{{ $testimonial->caption }}</h3>
                @endif
                @if($testimonial->short_description)
                <p class="text-sm text-gray-600 px-4">{{ $testimonial->short_description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- PROFESSIONAL REELS SECTION --}}
    @if($product->reviewVideos && $product->reviewVideos->count() > 0)
    <section class="py-16 bg-white overflow-hidden mt-12">
        <div class="text-center mb-10 px-4">
            <h2 class="text-3xl md:text-4xl font-light text-gray-800">Used by the professionals</h2>
            <p class="text-sm md:text-base text-gray-500 mt-3">See our product in action</p>
        </div>
        @if($product->reviewVideos->count() < 3)
            <div class="flex flex-wrap justify-center gap-6 max-w-7xl mx-auto px-4 relative">
                @foreach($product->reviewVideos as $video)
                <div class="w-64 sm:w-72 md:w-80 flex flex-col items-center group/slide">
                    <div class="relative w-full h-[360px] sm:h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg cursor-pointer">
                        <video src="{{ asset('storage/' . $video->video_path) }}" 
                               class="reel-video object-cover w-full h-full opacity-80" 
                               loop muted playsinline>
                        </video>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="play-btn bg-black/50 p-4 rounded-full text-white opacity-0 group-hover/slide:opacity-100 transition duration-300">
                                <svg class="w-8 h-8 play-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <svg class="w-8 h-8 pause-icon hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4 flex flex-col gap-2 text-white z-20">
                            <button class="mute-btn bg-black/40 p-2 rounded-full backdrop-blur-sm hover:bg-black/60 transition pointer-events-auto">
                                <svg class="w-4 h-4 mute-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <svg class="w-4 h-4 sound-icon hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                    </div>
                    @if($video->caption)
                    <p class="mt-4 text-sm font-medium text-gray-800 text-center">{{ $video->caption }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="swiper reel-swiper w-full max-w-7xl mx-auto relative">
                <div class="swiper-wrapper">
                    @foreach($product->reviewVideos as $video)
                    <div class="swiper-slide w-64 sm:w-72 md:w-80 flex flex-col items-center group/slide">
                        <div class="relative w-full h-[360px] sm:h-[450px] rounded-2xl overflow-hidden bg-gray-900 shadow-lg cursor-pointer">
                            <video src="{{ asset('storage/' . $video->video_path) }}" 
                                   class="reel-video object-cover w-full h-full opacity-80" 
                                   loop muted playsinline>
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="play-btn bg-black/50 p-4 rounded-full text-white opacity-0 group-hover/slide:opacity-100 transition duration-300">
                                    <svg class="w-8 h-8 play-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <svg class="w-8 h-8 pause-icon hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                </div>
                            </div>
                            <div class="absolute top-4 right-4 flex flex-col gap-2 text-white z-20">
                                <button class="mute-btn bg-black/40 p-2 rounded-full backdrop-blur-sm hover:bg-black/60 transition pointer-events-auto">
                                    <svg class="w-4 h-4 mute-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    <svg class="w-4 h-4 sound-icon hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </div>
                        @if($video->caption)
                        <p class="mt-4 text-sm font-medium text-gray-800">{{ $video->caption }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev !left-4 lg:!left-10"></div>
                <div class="swiper-button-next !right-4 lg:!right-10"></div>
            </div>
        @endif
    </section>
    @endif



    {{-- TEXT REVIEWS SECTION --}}
    @if($product->reviews && $product->reviews->count() > 0)
    <section class="py-16 bg-white overflow-hidden" id="reviews">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-light text-gray-900 mb-4">Customer Reviews</h2>
                <div class="w-16 h-0.5 bg-amber-600 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($product->reviews as $review)
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col">
                    <div class="flex gap-1 mb-3 text-amber-400">
                        @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 {{ $i < $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ $review->title }}</h4>
                    <p class="text-gray-600 text-sm italic mb-4 flex-grow">"{{ $review->text }}"</p>
                    <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                            {{ substr($review->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs">{{ $review->name }}</h4>
                            <span class="text-[10px] text-gray-500">Verified Buyer</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ Section (Dynamic) --}}
    @if($product->faqs && is_array($product->faqs) && count($product->faqs) > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl sm:text-4xl font-serif text-gray-900 text-center mb-12">Got questions? We've got answers</h2>
        
        <div class="lg:grid lg:grid-cols-2 gap-12 items-center">
            {{-- Accordions --}}
            <div class="space-y-4">
                @foreach($product->faqs as $faq)
                <details class="group bg-[#faf9f6] rounded-md">
                    <summary class="flex justify-between items-center font-medium text-gray-800 cursor-pointer p-5 outline-none">
                        {{ $faq['question'] }}
                        <span class="text-xl font-light transition-transform duration-300 group-open:rotate-45">+</span>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-gray-600">
                        {{ $faq['answer'] }}
                    </div>
                </details>
                @endforeach
            </div>
            
            {{-- Image --}}
            <div class="hidden lg:flex justify-center mt-10 lg:mt-0">
                <div class="bg-[#f5ece3] rounded-full p-8 w-full max-w-md aspect-square flex items-center justify-center relative">
                    <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="Products" class="w-3/4 object-contain shadow-2xl rounded-lg z-10" onerror="this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=600&q=80'">
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Related Products Section --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100 mt-8">
        <h2 class="text-3xl font-serif text-gray-900 mb-8 text-center">You May Also Like</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            @foreach($relatedProducts as $relProduct)
            <div class="product-card group cursor-pointer">
                <div class="relative h-full rounded-2xl overflow-hidden bg-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                    <a href="{{ route('product.detail', $relProduct->id) }}" class="block relative bg-gray-50 h-48 overflow-hidden flex items-center justify-center p-6 shrink-0">
                        <img src="{{ asset('storage/' . ($relProduct->cover_image ?? $relProduct->image)) }}" 
                             alt="{{ $relProduct->name }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 ease-out">
                    </a>

                    <div class="p-4 text-center flex-grow flex flex-col justify-between border-t border-gray-50">
                        <div>
                            <a href="{{ route('product.detail', $relProduct->id) }}">
                                <h3 class="font-bold text-gray-900 text-sm line-clamp-2 mb-2 group-hover:text-amber-600 transition-colors">
                                    {{ $relProduct->name }}
                                </h3>
                            </a>

                            <div class="mb-4">
                                <span class="text-lg font-bold text-gray-900">{{ \App\Helpers\CurrencyHelper::format($relProduct->price) }}</span>
                                @if($relProduct->compare_price && $relProduct->compare_price > $relProduct->price)
                                    <span class="text-xs text-gray-400 line-through ml-2">{{ \App\Helpers\CurrencyHelper::format($relProduct->compare_price) }}</span>
                                @endif
                            </div>
                        </div>

                        <button onclick="window.location.href='{{ route('product.detail', $relProduct->id) }}'" class="w-full border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white rounded-full py-2 text-xs font-bold tracking-widest transition-colors mt-auto">
                            VIEW DETAILS
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- Sticky Bottom Bar --}}
<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_10px_rgba(0,0,0,0.05)] z-50 transform translate-y-0 transition-transform duration-300" id="sticky-cart-bar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            @if($product->cover_image || $product->image)
                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="Mini" class="w-12 h-12 object-contain bg-gray-50 rounded border border-gray-100 hidden sm:block">
            @endif
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-900 line-clamp-1">{{ $product->name }}</span>
                <span class="text-sm text-gray-600">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
            </div>
        </div>
        
        <div>
            <button onclick="window.addToCart({{ $product->id }}, 1)" class="bg-[#1a1a1a] text-white px-6 sm:px-8 py-2.5 rounded-full font-semibold text-xs sm:text-sm tracking-widest hover:bg-black transition whitespace-nowrap" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                ADD TO CART
            </button>
        </div>
    </div>
</div>

{{-- Original Backend Script Maintained --}}
<script>
    window.buyNow = function(productId) {
        const qty = parseInt(document.getElementById('product-qty')?.value || 1);
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: qty
            })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => { throw new Error(err.error || 'Failed to add item to cart'); });
            }
            window.location.href = '/checkout';
        })
        .catch(err => {
            alert(err.message);
        });
    };

    // Assuming window.addToCart is defined globally elsewhere, or define it here if needed
    if(typeof window.addToCart !== 'function') {
        window.addToCart = function(productId, qty) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: qty
                })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw new Error(err.error || 'Failed to add item to cart'); });
                }
                alert('Added to cart successfully!');
                // Optional: trigger mini-cart open or update cart count here
            })
            .catch(err => {
                alert(err.message);
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.querySelector('.reel-swiper')) {
            new Swiper('.reel-swiper', {
                slidesPerView: 'auto',
                centeredSlides: true,
                centerInsufficientSlides: true,
                spaceBetween: 20,
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: { slidesPerView: 1.2, spaceBetween: 10 },
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 30 }
                }
            });

            // Video Controls
            const slides = document.querySelectorAll('.group\\/slide');
            slides.forEach(slide => {
                const video = slide.querySelector('video');
                const playBtn = slide.querySelector('.play-btn');
                const muteBtn = slide.querySelector('.mute-btn');
                
                if(!video) return;

                slide.addEventListener('click', (e) => {
                    if (e.target.closest('.mute-btn')) return;
                    if (video.paused) {
                        video.play();
                        playBtn.querySelector('.play-icon').classList.add('hidden');
                        playBtn.querySelector('.pause-icon').classList.remove('hidden');
                    } else {
                        video.pause();
                        playBtn.querySelector('.play-icon').classList.remove('hidden');
                        playBtn.querySelector('.pause-icon').classList.add('hidden');
                    }
                });

                muteBtn?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    video.muted = !video.muted;
                    muteBtn.querySelector('.mute-icon').classList.toggle('hidden');
                    muteBtn.querySelector('.sound-icon').classList.toggle('hidden');
                });
            });
        }
    });
</script>

@endsection