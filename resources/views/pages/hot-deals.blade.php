@extends('layouts.app')

@section('content')

{{-- Advanced Luxury & Urgency Animations (Light Theme Optimized) --}}
<style>
    /* Staggered Entrance */
    .fade-up {
        animation: fadeUpAnim 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(40px);
    }
    
    /* Continuous Floating for Featured Image */
    .float-smooth {
        animation: floatAnim 6s ease-in-out infinite;
    }

    /* Breathing Glow for Urgency (Softened for Light BG) */
    .glow-breathe {
        animation: glowBreatheAnim 3s infinite alternate;
    }

    /* Sweeping Shine across buttons */
    .btn-shine {
        position: relative;
        overflow: hidden;
    }
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg);
        animation: shineSweep 4s infinite;
    }

    /* Delays */
    .d-1 { animation-delay: 150ms; }
    .d-2 { animation-delay: 300ms; }
    .d-3 { animation-delay: 450ms; }
    .d-4 { animation-delay: 600ms; }

    /* Keyframes */
    @keyframes fadeUpAnim {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatAnim {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-15px) scale(1.02); }
    }
    @keyframes glowBreatheAnim {
        from { box-shadow: 0 0 15px rgba(220, 38, 38, 0.05), inset 0 0 10px rgba(220, 38, 38, 0.02); }
        to { box-shadow: 0 0 30px rgba(220, 38, 38, 0.15), inset 0 0 20px rgba(220, 38, 38, 0.05); }
    }
    @keyframes shineSweep {
        0% { left: -100%; }
        20% { left: 200%; }
        100% { left: 200%; }
    }
</style>

{{-- Premium Light Background Section --}}
<div class="bg-[#FAFAFA] text-slate-900 py-20 md:py-32 relative overflow-hidden">
    
    {{-- Animated Ambient Background Glows (Pastel for light theme) --}}
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-100/50 rounded-full blur-[100px] mix-blend-multiply animate-pulse duration-1000"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-amber-100/50 rounded-full blur-[120px] mix-blend-multiply glow-breathe"></div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10">
        
        {{-- Section Header --}}
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

       {{-- The Master Deal (Featured) --}}
<div class="fade-up d-3 relative rounded-[2rem] bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden mb-24 group">
    <div class="flex flex-col lg:flex-row items-center">
        
        {{-- Left Text Side --}}
        <div class="w-full lg:w-1/2 p-10 md:p-16 relative z-10">
            <span class="text-amber-600 text-xs font-bold tracking-widest uppercase mb-4 block">Master Collection</span>
            <h2 class="text-4xl md:text-5xl font-light mb-6 text-slate-900">
                The Clinical <br><span class="italic font-serif text-slate-700">Renewal Bundle</span>
            </h2>
            <p class="text-slate-500 leading-relaxed mb-10 max-w-md font-light">
                Our highest-tier LED mask paired with the potent 24K gold serum. A complete clinical protocol for unprecedented cellular rejuvenation.
            </p>
            
            <div class="flex items-end gap-6 mb-10">
                <div>
                    <span class="text-slate-400 line-through text-sm block mb-1">Standard Price $850</span>
                    <span class="text-5xl font-bold text-slate-900">$499</span>
                </div>
                <div class="bg-red-50 border border-red-100 px-4 py-2 rounded-lg">
                    <span class="text-red-600 font-bold tracking-wider uppercase text-xs">You Save $351</span>
                </div>
            </div>

            {{-- Button --}}
            <button class="btn-shine bg-slate-900 text-white px-10 py-4 rounded-xl text-sm font-bold tracking-[0.2em] uppercase hover:scale-105 hover:shadow-xl transition-all duration-300">
                Claim Offer
            </button>
        </div>

        {{-- Right Image Side --}}
        <div class="w-full lg:w-1/2 relative h-[400px] lg:h-[600px] flex items-center justify-center p-10 bg-slate-50/50">
            {{-- Decorative glow --}}
            <div class="absolute w-[300px] h-[300px] bg-gradient-to-tr from-amber-200/40 to-red-100/40 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
            
            {{-- Image with floating animation --}}
            <img src="{{ asset('images/categories/hero-deal.jpg') }}" 
                 alt="Renewal Bundle" 
                 class="relative z-10 w-full max-w-[400px] object-contain float-smooth drop-shadow-2xl">
        </div>
    </div>
</div> {{-- The Vault Grid --}}
        @php
            $hotDeals = [
                ['name' => 'Pro Micro-Infusion Needling', 'desc' => 'Clinical stamp system for plumping.', 'price' => 129, 'old' => 199, 'image' => 'deal-1.jpg'],
                ['name' => 'Ultrasonic Skin Scrubber', 'desc' => 'Deep pore extraction device.', 'price' => 89, 'old' => 140, 'image' => 'deal-2.jpg'],
                ['name' => 'Advanced Retinol Duo', 'desc' => 'Day and night potent protocol.', 'price' => 145, 'old' => 210, 'image' => 'deal-3.jpg'],
                ['name' => '24K Gold Sculpting Bar', 'desc' => 'Vibrating massager for lift.', 'price' => 65, 'old' => 95, 'image' => 'deal-4.jpg'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($hotDeals as $index => $deal)
            
            {{-- Light Aesthetic Animated Card --}}
            <div class="fade-up relative bg-white border border-slate-100 rounded-2xl overflow-hidden group hover:border-amber-200 hover:shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition-all duration-500 flex flex-col" style="animation-delay: {{ ($index * 150) + 600 }}ms;">
                
                {{-- Image Container --}}
                <a href="{{ route('product.detail', 11) }}" class="block relative h-64 overflow-hidden bg-[#F8F9FA]">
                    <img src="{{ asset('images/categories/' . $deal['image']) }}" alt="{{ $deal['name'] }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-all duration-700 ease-in-out">
                    
                    {{-- Luxury Discount Badge --}}
                    <div class="absolute top-4 left-4 bg-[#831b1b] text-white px-3 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase shadow-md">
                        Save ${{ $deal['old'] - $deal['price'] }}
                    </div>

                    {{-- Hover Glass Button --}}
                    <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out z-20">
                        <button class="w-full bg-white/95 backdrop-blur-sm border border-slate-200 text-slate-900 font-bold tracking-widest uppercase text-xs py-3.5 rounded-xl hover:bg-slate-900 hover:text-white transition-colors duration-300 shadow-lg" onclick="event.preventDefault(); window.openCart(event)">
                            Quick Add
                        </button>
                    </div>
                </a>

                {{-- Text Content --}}
                <div class="p-6 relative z-20 flex-grow flex flex-col bg-white">
                    <a href="{{ route('product.detail', 11) }}">
                        <h4 class="font-bold text-slate-900 mb-2 group-hover:text-amber-600 transition-colors line-clamp-1">
                            {{ $deal['name'] }}
                        </h4>
                    </a>
                    <p class="text-slate-500 text-xs font-light mb-6 flex-grow line-clamp-2">
                        {{ $deal['desc'] }}
                    </p>
                    
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-2xl font-bold text-slate-900">${{ $deal['price'] }}</span>
                        <span class="text-sm text-slate-400 line-through">${{ $deal['old'] }}</span>
                    </div>
                </div>
                
                {{-- Subtle Glow Effect on Hover --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-amber-50/0 via-amber-50/0 to-amber-50/0 group-hover:from-amber-50/50 group-hover:to-transparent pointer-events-none transition-all duration-500"></div>
            </div>
            
            @endforeach
        </div>
    </div>
</div>

@endsection