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

<div class="bg-[#FAFAFA] text-slate-900 py-20 md:py-32 relative overflow-hidden">
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-100/50 rounded-full blur-[100px] mix-blend-multiply animate-pulse duration-1000"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-amber-100/50 rounded-full blur-[120px] mix-blend-multiply glow-breathe"></div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 md:mb-24">
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
                $featuredCompare = $featuredHotDeal->compare_price;
                $featuredSavings = ($featuredCompare && $featuredCompare > $featuredSale) ? ($featuredHotDeal->discount_price && (float)$featuredHotDeal->discount_price > 0 ? (float)$featuredHotDeal->discount_price : $featuredCompare - $featuredSale) : 0;
            @endphp

            {{-- Featured: Clinical Renewal Bundle --}}
            <div class="fade-up d-3 relative rounded-[2rem] bg-white border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] hover:-translate-y-2 transition-all duration-500 overflow-hidden mb-24 group">
                <div class="flex flex-col lg:flex-row items-stretch">
                    <div class="w-full lg:w-1/2 p-6 md:p-10 relative z-10 flex flex-col justify-center">
                        <span class="text-amber-600 text-[10px] md:text-xs font-bold tracking-widest uppercase mb-3 block">Master Collection</span>
                        <h2 class="text-3xl md:text-4xl font-light mb-4 text-slate-900">
                            The Clinical <br><span class="italic font-serif text-slate-700">Renewal Bundle</span>
                        </h2>
                        <p class="text-slate-500 leading-relaxed mb-3 max-w-md font-light text-sm">{{ $featuredHotDeal->name }}</p>
                        <p class="text-slate-500 leading-relaxed mb-6 max-w-md font-light text-sm line-clamp-3">
                            {{ $featuredHotDeal->description ?? 'A complete clinical protocol for unprecedented cellular rejuvenation.' }}
                        </p>
                        <div class="flex items-end gap-5 mb-6">
                            <div>
                                @if($featuredCompare && $featuredCompare > $featuredSale)
                                    <span class="text-slate-400 line-through text-xs block mb-1">Standard Price {!! \App\Helpers\CurrencyHelper::format($featuredCompare) !!}</span>
                                @endif
                                <span class="text-3xl md:text-4xl font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($featuredSale) !!}</span>
                            </div>
                            @if($featuredSavings > 0)
                            <div class="bg-red-50 border border-red-100 px-4 py-2 rounded-lg">
                                <span class="text-red-600 font-bold tracking-wider uppercase text-xs">You Save {!! \App\Helpers\CurrencyHelper::format($featuredSavings) !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('product.detail', $featuredHotDeal->slug) }}"
                               class="btn-shine inline-block bg-slate-900 text-white px-8 py-3 rounded-xl text-xs md:text-sm font-bold tracking-[0.2em] uppercase hover:scale-105 hover:shadow-xl transition-all duration-300">
                                Claim Offer
                            </a>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 relative h-[250px] lg:h-[300px] flex items-center justify-center p-6 bg-slate-50/50 overflow-hidden rounded-b-[2rem] lg:rounded-r-[2rem] lg:rounded-bl-none">
                        <div class="absolute w-[250px] h-[250px] bg-gradient-to-tr from-amber-300/40 to-rose-200/40 rounded-full blur-3xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-700"></div>
                        @if($featuredHotDeal->cover_image || $featuredHotDeal->image)
                            <img src="{{ asset('storage/' . ($featuredHotDeal->cover_image ?? $featuredHotDeal->image)) }}"
                                 alt="{{ $featuredHotDeal->name }}"
                                 class="relative z-10 w-full max-w-[250px] object-contain float-smooth drop-shadow-2xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @else
                            <img src="{{ asset('images/categories/hero-deal.jpg') }}"
                                 alt="{{ $featuredHotDeal->name }}"
                                 class="relative z-10 w-full max-w-[250px] object-contain float-smooth drop-shadow-2xl group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @endif
                    </div>
                </div>
            </div>

            @if($gridHotDeals->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($gridHotDeals as $index => $product)
                @php
                    $salePrice = $product->price;
                    $comparePrice = $product->compare_price;
                    $savings = ($comparePrice && $comparePrice > $salePrice) ? ($product->discount_price && (float)$product->discount_price > 0 ? (float)$product->discount_price : $comparePrice - $salePrice) : 0;
                @endphp
                <div class="fade-up relative bg-white border border-slate-100 rounded-2xl overflow-hidden group hover:border-amber-200 hover:shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition-all duration-500 flex flex-col" style="animation-delay: {{ ($index * 150) + 600 }}ms;">
                    <a href="{{ route('product.detail', $product->slug) }}" class="block relative h-64 overflow-hidden bg-[#F8F9FA]">
                        @if($product->cover_image || $product->image)
                            <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-all duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                        @endif
                        @if($savings > 0)
                        <div class="absolute top-4 left-4 bg-[#831b1b] text-white px-3 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase shadow-md">
                            Save {!! \App\Helpers\CurrencyHelper::format($savings) !!}
                        </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out z-20">
                            <button class="w-full bg-white/95 backdrop-blur-sm border border-slate-200 text-slate-900 font-bold tracking-widest uppercase text-xs py-3.5 rounded-xl hover:bg-slate-900 hover:text-white transition-colors duration-300 shadow-lg" onclick="event.preventDefault(); window.openCart(event)">
                                Quick Add
                            </button>
                        </div>
                    </a>
                    <div class="p-6 relative z-20 flex-grow flex flex-col bg-white">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <h4 class="font-bold text-slate-900 mb-2 group-hover:text-amber-600 transition-colors line-clamp-1">{{ $product->name }}</h4>
                        </a>
                        <p class="text-slate-500 text-xs font-light mb-6 flex-grow line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-2xl font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($salePrice) !!}</span>
                            @if($comparePrice && $comparePrice > $salePrice)
                                <span class="text-sm text-slate-400 line-through">{!! \App\Helpers\CurrencyHelper::format($comparePrice) !!}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <div class="mt-16 flex justify-center">
                {{ $hotDealProducts->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
