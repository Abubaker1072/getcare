@extends('layouts.app')

@push('styles')
{{-- Custom Brand Animations --}}
<style>
    /* Seamless Infinite Marquee */
    .marquee-container {
        display: flex;
        width: 200%; /* Double width to accommodate duplicated content */
        animation: marqueeScroll 40s linear infinite;
        will-change: transform;
    }
    
    .marquee-container:hover {
        animation-play-state: paused;
    }

    @keyframes marqueeScroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); } 
    }

    /* 1. Base State: Hidden and shifted down */
    .fade-up-brand {
        opacity: 0;
        transform: translateY(40px);
        visibility: hidden; 
    }

    /* 2. Active State: Triggered by JS when scrolled into view */
    .fade-up-brand.is-visible {
        visibility: visible;
        animation: fadeUpBrandAnim 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeUpBrandAnim {
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Animation Delays */
    .delay-b1 { animation-delay: 150ms; }
    .delay-b2 { animation-delay: 300ms; }
    .delay-b3 { animation-delay: 450ms; }
</style>
@endpush

@section('content')

{{-- Premium Brands Section --}}
<section class="bg-white py-20 md:py-32 border-t border-slate-100 overflow-hidden relative">

    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 relative z-10 text-center mb-16 md:mb-24">
        <span class="fade-up-brand text-amber-600 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
            Our Partners
        </span>
        <h2 class="fade-up-brand delay-b1 text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-slate-900 mb-6">
            The World's Finest <br> <span class="italic font-serif text-slate-500">Clinical Brands</span>
        </h2>
        <p class="fade-up-brand delay-b2 text-slate-500 max-w-2xl mx-auto font-light text-base md:text-lg">
            We partner exclusively with industry-leading pioneers in beauty technology and active skincare formulations to bring you proven, professional-grade results.
        </p>
    </div>

    {{-- 1. Infinite Brand Logo Marquee --}}
    <div class="fade-up-brand delay-b3 relative w-full border-y border-slate-50 bg-[#FAFAFA] py-10 mb-24 overflow-hidden flex">
        
        {{-- Left/Right Gradient Fades for seamless looping look --}}
        <div class="absolute left-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-r from-[#FAFAFA] to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-l from-[#FAFAFA] to-transparent z-10 pointer-events-none"></div>

        @php
            // Array of brand logos
            $brandLogos = [
                'brand-1.png', 'brand-2.png', 'brand-3.png', 'brand-4.png', 'brand-5.png', 'brand-6.png'
            ];
            
            // Duplicate array for seamless infinite scrolling
            $scrollingLogos = array_merge($brandLogos, $brandLogos);
        @endphp

        <div class="marquee-container items-center justify-around gap-12 md:gap-24 px-12">
            @foreach($scrollingLogos as $logo)
                <div class="flex-shrink-0 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-500 cursor-pointer flex items-center justify-center w-32 md:w-48">
                    <img src="{{ asset('images/brands/' . $logo) }}" alt="Luxury Brand Logo" class="max-h-12 w-auto object-contain hidden">
                    
                    {{-- Placeholder Text Logo --}}
                    <span class="text-xl md:text-2xl font-serif tracking-widest uppercase text-slate-800">
                        Brand<span class="font-sans font-light">Name</span>
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 2. Featured Brand Boutiques --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-10 border-b border-slate-100 pb-4">
            <h3 class="text-2xl font-light text-slate-900"><span class="font-bold">Featured</span> Boutiques</h3>
            <a href="#" class="text-sm font-bold text-amber-600 hover:text-amber-800 tracking-wider uppercase transition-colors">View All Brands →</a>
        </div>

        @php
            $featuredBrands = [
                [
                    'name' => 'Lumière Clinical',
                    'tagline' => 'Pioneers in LED Technology',
                    'description' => 'Award-winning light therapy devices trusted by dermatologists worldwide for cellular repair.',
                    'image' => 'brand-feature-1.jpg'
                ],
                [
                    'name' => 'Aura Sculpt',
                    'tagline' => 'The Microcurrent Experts',
                    'description' => 'Non-invasive facial toning devices that lift, contour, and instantly rejuvenate tired skin.',
                    'image' => 'brand-feature-2.jpg'
                ],
                [
                    'name' => 'NuGold Formulations',
                    'tagline' => 'Potent Active Ingredients',
                    'description' => 'Clinical-strength serums engineered to penetrate deeply and complement your device protocols.',
                    'image' => 'brand-feature-3.jpg'
                ]
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($featuredBrands as $index => $brand)
            
            <a href="#" class="fade-up-brand group relative h-[450px] md:h-[500px] rounded-2xl overflow-hidden block shadow-sm hover:shadow-xl transition-all duration-500" style="animation-delay: {{ ($index * 150) + 200 }}ms;">
                
                {{-- Brand Lifestyle Background Image --}}
                <div class="absolute inset-0 bg-slate-100">
                    <img src="{{ asset('images/brands/' . $brand['image']) }}" alt="{{ $brand['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[1.5s] ease-out mix-blend-multiply">
                </div>

                {{-- Smooth Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>

                {{-- Content Container --}}
                <div class="absolute inset-0 p-8 flex flex-col justify-end text-white">
                    
                    {{-- Decorative Line --}}
                    <div class="w-8 h-px bg-amber-500 mb-6 transform origin-left group-hover:scale-x-150 transition-transform duration-500"></div>
                    
                    <span class="text-amber-400 text-[10px] font-bold tracking-[0.2em] uppercase mb-2 block">
                        {{ $brand['tagline'] }}
                    </span>
                    
                    <h3 class="text-3xl font-light tracking-wide mb-3 group-hover:text-amber-50 transition-colors">
                        {{ $brand['name'] }}
                    </h3>
                    
                    {{-- Revealing Description --}}
                    <div class="h-0 opacity-0 overflow-hidden group-hover:h-auto group-hover:opacity-100 group-hover:mt-2 transition-all duration-500 ease-out">
                        <p class="text-slate-300 text-sm font-light leading-relaxed mb-6">
                            {{ $brand['description'] }}
                        </p>
                        
                        <div class="inline-flex items-center text-xs font-bold tracking-widest uppercase bg-white text-slate-900 px-6 py-3 rounded hover:bg-amber-500 hover:text-white transition-colors">
                            Shop Brand
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- Scroll Reveal JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15 // Triggers when 15% of element is visible
        };

        const brandObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); 
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.fade-up-brand');
        animatedElements.forEach(el => brandObserver.observe(el));
    });
</script>
@endpush