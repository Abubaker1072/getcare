@php
    $bgColors = ['bg-[#f0eef6]', 'bg-[#eef5ef]', 'bg-[#f8f6f0]', 'bg-[#f7f0eb]'];
    $bgColor = $isTheme2 ? 'bg-[#121218]' : $bgColors[$index % count($bgColors)];
    
    // Parse tags to render as badges
    $badges = [];
    if (!empty($product->tags)) {
        $badges = array_map('trim', explode(',', $product->tags));
    } else {
        if ($product->stock < 5 && $product->stock > 0) {
            $badges[] = 'Limited';
        }
        if ($product->compare_price && $product->compare_price > $product->price) {
            $badges[] = 'Sale';
        }
    }
@endphp

<div class="swiper-slide w-[280px] sm:w-[320px] md:w-[340px] flex flex-col group h-auto">
    <div class="flex flex-col h-full">
        {{-- Image Area with custom rounded and pastel background --}}
        <a href="{{ route('product.detail', $product->id) }}" class="block relative {{ $bgColor }} aspect-[3/4] rounded-[2rem] overflow-hidden flex items-center justify-center p-6 transition-all duration-500 {{ $isTheme2 ? 'border border-white/5 hover:border-amber-500/30' : 'hover:shadow-2xl' }} group/img">
            
            @if($product->cover_image || $product->image)
                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-contain mix-blend-multiply group-hover/img:scale-105 transition-transform duration-700 ease-out {{ $isTheme2 ? 'brightness-110 contrast-105' : '' }}">
            @else
                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">No Image</div>
            @endif

            {{-- Badges Top-Left --}}
            @if(!empty($badges))
            <div class="absolute top-6 left-6 flex flex-col gap-1.5 z-10">
                @foreach($badges as $badge)
                    @php
                        $badgeStyle = 'bg-slate-900 text-white';
                        if (strtolower($badge) === 'limited') {
                            $badgeStyle = $isTheme2 ? 'bg-amber-950/40 text-amber-400 border border-amber-500/30' : 'bg-blue-50 text-blue-700 border border-blue-100';
                        } elseif (strtolower($badge) === 'top rated') {
                            $badgeStyle = $isTheme2 ? 'bg-amber-500/10 text-amber-300 border border-amber-500/30' : 'bg-amber-50 text-amber-700 border border-amber-100';
                        } elseif (strtolower($badge) === 'new') {
                            $badgeStyle = $isTheme2 ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30' : 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                        } elseif (strtolower($badge) === 'sale') {
                            $badgeStyle = 'bg-rose-50 text-rose-700 border border-rose-100';
                        }
                    @endphp
                    <span class="rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest {{ $badgeStyle }} shadow-sm">
                        {{ $badge }}
                    </span>
                @endforeach
            </div>
            @endif

            {{-- Quick Add Overlay --}}
            <div class="absolute inset-x-0 bottom-6 flex justify-center opacity-0 translate-y-3 group-hover/img:opacity-100 group-hover/img:translate-y-0 transition-all duration-300 z-20">
                <button class="bg-white/95 backdrop-blur-sm hover:bg-slate-900 hover:text-white text-slate-900 font-extrabold py-3 px-8 rounded-full shadow-lg transition-all text-xs uppercase tracking-wider" onclick="event.preventDefault(); window.addToCart({{ $product->id }}, 1)">
                    Quick Add
                </button>
            </div>
        </a>

        {{-- Product Details Centered --}}
        <div class="p-4 flex flex-col flex-grow text-center">
            {{-- Brand / Subtitle --}}
            <span class="text-[10px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                {{ !empty($product->promo_text) ? $product->promo_text : ($product->category->name ?? 'GETCARE') }}
            </span>
            
            {{-- Title --}}
            <a href="{{ route('product.detail', $product->id) }}">
                <h3 class="font-serif text-[#0b132b] dark:text-slate-200 text-base md:text-lg font-medium mt-2 leading-tight group-hover:text-amber-500 transition-colors line-clamp-2 min-h-[2.5rem] px-2">
                    {{ $product->name }}
                </h3>
            </a>

            {{-- Price --}}
            <div class="mt-2 text-slate-900 dark:text-slate-100 font-bold text-sm">
                @if($product->discount_price && $product->discount_price < $product->price)
                    <span class="text-amber-600 dark:text-amber-400 font-extrabold text-base">{{ \App\Helpers\CurrencyHelper::format($product->discount_price) }}</span>
                    <span class="text-slate-400 dark:text-slate-500 line-through text-xs ml-1">{{ \App\Helpers\CurrencyHelper::format($product->price) }}</span>
                @else
                    <span>{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</span>
                @endif
            </div>
        </div>
    </div>
</div>
