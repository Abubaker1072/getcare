@extends('layouts.app')

@section('content')

<style>
    .fade-up { animation: fadeUpAnim 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(40px); }
    .float-smooth { animation: floatAnim 6s ease-in-out infinite; }
    .glow-breathe { animation: glowBreatheAnim 3s infinite alternate; }
    .btn-shine { position: relative; overflow: hidden; }
    .btn-shine::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg); animation: shineSweep 4s infinite;
    }
    .d-1 { animation-delay: 150ms; } .d-2 { animation-delay: 300ms; } .d-3 { animation-delay: 450ms; }
    @keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }
    @keyframes floatAnim { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-15px) scale(1.02); } }
    @keyframes glowBreatheAnim {
        from { box-shadow: 0 0 15px rgba(220, 38, 38, 0.05), inset 0 0 10px rgba(220, 38, 38, 0.02); }
        to { box-shadow: 0 0 30px rgba(220, 38, 38, 0.15), inset 0 0 20px rgba(220, 38, 38, 0.05); }
    }
    @keyframes shineSweep { 0% { left: -100%; } 20% { left: 200%; } 100% { left: 200%; } }
</style>

<div class="bg-[#FAFAFA] text-slate-900 py-10 md:py-16 relative overflow-hidden">
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-100/50 rounded-full blur-[100px] mix-blend-multiply animate-pulse duration-1000"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-amber-100/50 rounded-full blur-[120px] mix-blend-multiply glow-breathe"></div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-8 sm:mb-12">
            <div class="fade-up inline-flex items-center gap-3 px-4 py-1.5 rounded-full border border-red-200 bg-red-50/80 backdrop-blur-md mb-6 glow-breathe">
                <div class="w-2 h-2 rounded-full bg-red-600 animate-ping"></div>
                <span class="text-red-700 text-[10px] font-bold tracking-[0.3em] uppercase">The VIP Vault is Open</span>
            </div>
            <h1 class="fade-up d-1 text-5xl md:text-7xl font-light tracking-tight mb-6 text-slate-900">
                Exclusive <span class="italic font-serif text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-amber-400">Offers</span>
            </h1>
            <p class="fade-up d-2 text-slate-500 max-w-2xl mx-auto font-light text-lg">
                Strictly limited allocations of our most transformative tools. Secure your protocol before these prices vanish.
            </p>
        </div>



        @if($hotDealProducts->isEmpty())
            <div class="text-center py-20 text-slate-500">
                <p class="text-lg">Hot deals coming soon. Check back later!</p>
            </div>
        @else
            @php
                $featuredHotDeal = $hotDealProducts->first();
                $gridHotDeals = $hotDealProducts->slice(1);
                $featuredSale = $featuredHotDeal->price;
                $featuredCompare = $featuredHotDeal->is_on_sale ? $featuredHotDeal->compare_price : null;
                $featuredSavings = ($featuredCompare && $featuredCompare > $featuredSale) ? ($featuredHotDeal->discount_price && (float)$featuredHotDeal->discount_price > 0 ? (float)$featuredHotDeal->discount_price : $featuredCompare - $featuredSale) : 0;
            @endphp

            {{-- Featured: Clinical Renewal Bundle --}}
            <div class="fade-up d-3 relative rounded-[2rem] bg-white border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] hover:-translate-y-2 transition-all duration-500 overflow-hidden mb-12 sm:mb-16 group">
                <div class="flex flex-col-reverse sm:flex-row items-stretch">
                    <div class="w-full sm:w-1/2 p-6 sm:p-6 md:p-10 relative z-10 flex flex-col justify-center">
                        <span class="text-amber-600 text-[10px] sm:text-[10px] md:text-xs font-bold tracking-widest uppercase mb-2 sm:mb-3 block">Master Collection</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-light mb-2 sm:mb-4 text-slate-900">
                            {{ $featuredHotDeal->name }}
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4 sm:mb-6 max-w-md font-light line-clamp-3 pr-2 sm:pr-0">
                            {{ $featuredHotDeal->description ?? 'Premium selection of our top-rated products.' }}
                        </p>
                        <div class="flex flex-wrap items-center gap-3 mb-4 sm:mb-6">
                            <div>
                                @if($featuredCompare && $featuredCompare > $featuredSale)
                                    <span class="text-slate-400 line-through text-xs block mb-0.5 sm:mb-1">Standard Price {!! \App\Helpers\CurrencyHelper::format($featuredCompare) !!}</span>
                                @endif
                                <span class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($featuredSale) !!}</span>
                            </div>
                            @if($featuredSavings > 0)
                            <div class="bg-red-50 border border-red-100 px-3 py-1.5 rounded-lg w-fit mt-1 sm:mt-0">
                                <span class="text-red-600 font-bold tracking-wider uppercase text-xs">You Save {!! \App\Helpers\CurrencyHelper::format($featuredSavings) !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="mt-2 sm:mt-4">
                            <a href="{{ route('product.detail', $featuredHotDeal->slug ?? $featuredHotDeal->id) }}"
                               class="inline-block text-center bg-slate-900 text-white px-6 py-3 rounded-xl text-xs sm:text-sm font-bold tracking-[0.1em] sm:tracking-[0.2em] uppercase hover:scale-105 hover:shadow-xl transition-all duration-300 w-full sm:w-fit">
                                Claim Offer
                            </a>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 relative flex flex-col justify-center items-center p-6 bg-slate-50/50 sm:bg-transparent overflow-hidden rounded-t-[2rem] sm:rounded-none">
                        <div class="absolute w-[200px] sm:w-[250px] h-[200px] sm:h-[250px] bg-gradient-to-tr from-amber-300/40 to-rose-200/40 rounded-full blur-2xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-700"></div>
                        <div class="h-[200px] sm:h-[250px] lg:h-[300px] w-full flex items-center justify-center p-2 sm:p-0">
                            @if($featuredHotDeal->cover_image || $featuredHotDeal->image)
                                <img src="{{ asset('storage/' . ($featuredHotDeal->cover_image ?? $featuredHotDeal->image)) }}"
                                     alt="{{ $featuredHotDeal->name }}"
                                     class="relative z-10 w-full max-w-[250px] h-full object-contain drop-shadow-xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <img src="{{ asset('images/categories/hero-deal.jpg') }}"
                                     alt="{{ $featuredHotDeal->name }}"
                                     class="relative z-10 w-full max-w-[250px] h-full object-contain drop-shadow-xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Promo Video Banners --}}
            @if(isset($hotDealPromos) && $hotDealPromos->isNotEmpty())
                <div class="mt-6 mb-8 sm:mt-8 sm:mb-12">
                    @foreach($hotDealPromos as $promo)
                        <div class="fade-up relative rounded-[1.5rem] sm:rounded-[2rem] overflow-hidden mb-6 shadow-[0_15px_40px_rgba(0,0,0,0.05)] border border-slate-100 bg-[#f5ebe1] flex flex-col-reverse sm:flex-row items-stretch sm:h-[300px] md:h-[360px] lg:h-[400px]">
                             <!-- Product Details -->
                            <div class="w-full sm:w-1/2 flex flex-col items-center justify-center p-6 sm:p-8 md:p-12 lg:p-16 text-center">
                                @php
                                    $detailLink = $promo->product ? route('product.detail', $promo->product->slug ?? $promo->product->id) : ($promo->button_url ?: '#');
                                @endphp
                                
                                @if($promo->image_path || ($promo->product && ($promo->product->cover_image || $promo->product->image)))
                                    <a href="{{ $detailLink }}" class="block mb-3 sm:mb-4">
                                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-white p-3 flex items-center justify-center shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                                            @if($promo->image_path)
                                                <img src="{{ asset('storage/' . $promo->image_path) }}" alt="{{ $promo->title }}" class="max-w-full max-h-full object-contain">
                                            @else
                                                <img src="{{ asset('storage/' . ($promo->product->cover_image ?? $promo->product->image)) }}" alt="{{ $promo->title }}" class="max-w-full max-h-full object-contain">
                                            @endif
                                        </div>
                                    </a>
                                @endif
                                
                                <a href="{{ $detailLink }}" class="hover:text-amber-600 transition-colors">
                                    <h2 class="text-lg sm:text-2xl md:text-3xl lg:text-4xl font-serif font-light text-slate-900 mb-2 tracking-wide leading-tight line-clamp-2">
                                        {{ $promo->title }}
                                    </h2>
                                </a>
                                
                                @if($promo->description)
                                    <p class="text-slate-600 text-sm sm:text-xs md:text-sm lg:text-base font-light mb-4 max-w-sm line-clamp-3 sm:line-clamp-4">
                                        {{ $promo->description }}
                                    </p>
                                @endif
                                
                                @if($promo->product)
                                    <button onclick="event.preventDefault(); window.addToCart({{ $promo->product->id }}, 1)" class="inline-block bg-[#181818] hover:bg-black text-white px-6 py-2.5 sm:px-8 sm:py-3.5 rounded-full text-xs font-bold uppercase tracking-widest transition duration-300 transform active:scale-95 shadow-md whitespace-nowrap cursor-pointer">
                                        {{ $promo->button_text ?: 'Add to Cart' }}
                                    </button>
                                @else
                                    <a href="{{ $promo->button_url ?: '#' }}" class="inline-block bg-[#181818] hover:bg-black text-white px-6 py-2.5 sm:px-8 sm:py-3.5 rounded-full text-xs font-bold uppercase tracking-widest transition duration-300 transform active:scale-95 shadow-md whitespace-nowrap">
                                        {{ $promo->button_text ?: 'Learn More' }}
                                    </a>
                                @endif
                            </div>

                            <!-- Video Banner -->
                            <div class="w-full sm:w-1/2 relative bg-slate-950 h-[200px] sm:h-auto overflow-hidden">
                                @if($promo->video_path)
                                    <video src="{{ asset('storage/' . $promo->video_path) }}" class="promo-video w-full h-full object-cover" autoplay loop muted playsinline></video>
                                    
                                    <button class="promo-play-pause-btn absolute top-4 left-4 bg-black/40 hover:bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer backdrop-blur-sm transition-all duration-200 z-20 focus:outline-none">
                                        <svg class="pause-icon w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                        <svg class="play-icon w-4 h-4 fill-current hidden" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </button>
                                @else
                                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1000&q=80" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.promo-play-pause-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const container = this.closest('div');
                                const video = container.querySelector('.promo-video');
                                const playIcon = this.querySelector('.play-icon');
                                const pauseIcon = this.querySelector('.pause-icon');
                                
                                if (video) {
                                    if (video.paused) {
                                        video.play();
                                        playIcon.classList.add('hidden');
                                        pauseIcon.classList.remove('hidden');
                                    } else {
                                        video.pause();
                                        playIcon.classList.remove('hidden');
                                        pauseIcon.classList.add('hidden');
                                    }
                                }
                            });
                        });

                        document.querySelectorAll('.promo-video').forEach(video => {
                            video.addEventListener('click', function() {
                                const container = this.closest('div');
                                const btn = container.querySelector('.promo-play-pause-btn');
                                if (btn) {
                                    btn.click();
                                }
                            });
                        });
                    });
                </script>
            @endif

            @if($gridHotDeals->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($gridHotDeals as $index => $product)
                @php
                    $salePrice = $product->price;
                    $comparePrice = $product->is_on_sale ? $product->compare_price : null;
                    $savings = ($comparePrice && $comparePrice > $salePrice) ? ($product->discount_price && (float)$product->discount_price > 0 ? (float)$product->discount_price : $comparePrice - $salePrice) : 0;
                @endphp
                <div class="fade-up relative bg-white border border-slate-100 rounded-2xl overflow-hidden group hover:border-amber-200 hover:shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition-all duration-500 flex flex-col" style="animation-delay: {{ ($index * 150) + 600 }}ms;">
                    <a href="{{ route('product.detail', $product->slug) }}" class="block relative h-32 sm:h-40 md:h-48 overflow-hidden bg-[#F8F9FA]">
                        @if($product->cover_image || $product->image)
                            <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-all duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                        @endif
                        @if($savings > 0)
                        <div class="absolute top-2 sm:top-4 left-2 sm:left-4 bg-[#831b1b] text-white px-2 py-1 sm:px-3 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-bold tracking-widest uppercase shadow-md">
                            Save {!! \App\Helpers\CurrencyHelper::format($savings) !!}
                        </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 p-2 sm:p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out z-20">
                            <button class="w-full bg-white/95 backdrop-blur-sm border border-slate-200 text-slate-900 font-bold tracking-widest uppercase text-[10px] sm:text-xs py-2 sm:py-3.5 rounded-lg sm:rounded-xl hover:bg-slate-900 hover:text-white transition-colors duration-300 shadow-lg" onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)">
                                Quick Add
                            </button>
                        </div>
                    </a>
                    <div class="p-3 sm:p-6 relative z-20 flex-grow flex flex-col bg-white">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <h4 class="font-bold text-slate-900 text-[11px] sm:text-base mb-1 sm:mb-2 group-hover:text-amber-600 transition-colors line-clamp-2 leading-tight sm:line-clamp-1">{{ $product->name }}</h4>
                        </a>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm sm:text-2xl font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($salePrice) !!}</span>
                            @if($comparePrice && $comparePrice > $salePrice)
                                <span class="text-[10px] sm:text-sm text-slate-400 line-through">{!! \App\Helpers\CurrencyHelper::format($comparePrice) !!}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <div class="mt-8 sm:mt-10 flex justify-center">
                {{ $hotDealProducts->links('partials.pagination') }}
            </div>
        @endif
    </div>
</div>

@endsection
