@extends('layouts.app')

@section('content')

{{-- Custom Animations Style --}}
<style>
    .fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .stagger-1 { animation-delay: 100ms; }
    .stagger-2 { animation-delay: 200ms; }
    .stagger-3 { animation-delay: 300ms; }
    .stagger-4 { animation-delay: 400ms; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

{{-- Premium Shortened Hero Section with Image --}}
<section class="bg-[#0a0a0a] relative overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-stretch min-h-[350px] md:min-h-[400px]">
        
        {{-- Text Content (Left Side) --}}
        <div class="flex-1 py-12 md:py-16 px-4 md:px-6 lg:px-8 flex flex-col justify-center text-center md:text-left relative z-10">
            <span class="fade-in-up uppercase tracking-[0.3em] text-[10px] font-bold text-amber-500 mb-4 block">
                {{ $pageSettings['subtitle'] ?? 'Curated Collections' }}
            </span>
            <h1 class="fade-in-up stagger-1 text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-white mb-4">
                {{ $pageSettings['title'] ?? 'Elevate Your Skincare Ritual' }}
            </h1>
            <p class="fade-in-up stagger-2 text-slate-400 text-sm md:text-base max-w-md font-light leading-relaxed mx-auto md:mx-0">
                {{ $pageSettings['description'] ?? 'Explore our meticulously crafted categories of clinical-grade devices and potent formulations designed for transformative results.' }}
            </p>
        </div>

        {{-- Image Content (Right Side) --}}
        <div class="w-full md:w-1/2 lg:w-[55%] relative min-h-[250px] md:min-h-auto">
            {{-- Gradient overlay to blend the image smoothly into the black background --}}
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[#0a0a0a] via-[#0a0a0a]/60 to-transparent z-10"></div>
            
            @php
                $headerImage = !empty($pageSettings['image']) 
                    ? (Str::startsWith($pageSettings['image'], 'images/') ? asset($pageSettings['image']) : asset('storage/' . $pageSettings['image'])) 
                    : asset('images/categories/header-collection.jpg');
            @endphp
            <img src="{{ $headerImage }}" 
                 alt="Premium Skincare Devices and Serums" 
                 class="absolute inset-0 w-full h-full object-cover object-center fade-in-up stagger-3 opacity-90 mix-blend-lighten">
        </div>
    </div>
</section>

{{-- Interactive Category Grid --}}
<section class="py-16 md:py-24 bg-[#FDFBF6]">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        @if($categories->isEmpty())
            <div class="text-center py-20">
                <p class="text-slate-500 text-lg font-light">No categories available yet. Check back soon!</p>
            </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($categories as $index => $category)
            
            {{-- Category Card --}}
            <a href="{{ route('category.detail', $category->slug) }}" class="group relative block h-[250px] md:h-[300px] w-full rounded-2xl overflow-hidden fade-in-up" style="animation-delay: {{ ($index * 100) + 400 }}ms;">
                
                {{-- Background Image with slow zoom on hover --}}
                <div class="absolute inset-0 bg-slate-200">
                    <img src="{{ \App\Helpers\ImageHelper::getCategoryImage($category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-110">
                </div>

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>

                {{-- Content Container --}}
                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    
                    {{-- Top right item count badge --}}
                    <div class="absolute top-6 right-6 translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500 ease-out">
                        <span class="bg-white/10 backdrop-blur-md text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/20 shadow-sm">
                            {{ $category->products_count ?? 0 }} Products
                        </span>
                    </div>

                    {{-- Text Content --}}
                    <div class="relative z-10 transform translate-y-6 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                        <span class="text-amber-400 text-[10px] font-bold tracking-[0.2em] uppercase mb-2 block drop-shadow-md">
                            {{ $category->slug }}
                        </span>
                        
                        <h2 class="text-2xl md:text-3xl font-light text-white mb-3 tracking-wide drop-shadow-md">
                            {{ $category->name }}
                        </h2>
                        
                        {{-- Description fades in and slides up on hover --}}
                        @if($category->description)
                        <div class="h-0 opacity-0 overflow-hidden group-hover:h-auto group-hover:opacity-100 group-hover:mt-4 transition-all duration-500 ease-out">
                            <p class="text-slate-300 text-sm font-light leading-relaxed max-w-[90%]">
                                {{ $category->description }}
                            </p>
                            
                            {{-- Explore Link --}}
                            <div class="mt-5 flex items-center text-white text-xs font-bold tracking-widest uppercase">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</section>

{{-- Featured Banner --}}
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="relative rounded-2xl overflow-hidden bg-[#0f172a] flex flex-col md:flex-row items-center group">
            <div class="p-10 md:p-16 flex-1 z-10">
                <span class="text-amber-500 text-xs font-bold tracking-widest uppercase mb-4 block">Signature Collection</span>
                <h3 class="text-3xl md:text-4xl font-light text-white mb-4">The Anti-Aging Protocol</h3>
                <p class="text-slate-400 font-light max-w-md mb-8">A curated multi-step regimen combining LED therapy and potent serums for maximum cellular rejuvenation.</p>
                <button class="bg-white text-slate-900 px-8 py-3.5 rounded text-sm font-bold uppercase tracking-wide hover:bg-amber-500 hover:text-white transition-colors duration-300 shadow-lg shadow-white/10 hover:shadow-amber-500/20">
                    Shop The Protocol
                </button>
            </div>
            <div class="w-full md:w-1/2 h-64 md:h-full absolute md:relative right-0 opacity-40 md:opacity-100 overflow-hidden">
                <img src="{{ asset('images/categories/featured-protocol.jpg') }}" alt="Anti Aging Protocol" class="w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-[2s] ease-out">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f172a] to-transparent hidden md:block"></div>
            </div>
        </div>
    </div>
</section>

@endsection