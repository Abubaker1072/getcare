@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-1 sm:gap-2 mt-8">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-gray-100 text-gray-300 text-xs sm:text-sm font-medium cursor-not-allowed select-none bg-gray-50/50">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-gray-200 text-gray-700 hover:text-amber-600 hover:border-amber-600 hover:bg-amber-50/30 text-xs sm:text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 mr-1 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center gap-1">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-8 h-8 sm:w-10 sm:h-10 inline-flex items-center justify-center text-gray-400 text-xs sm:text-sm">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-full bg-black text-white text-xs sm:text-sm font-bold shadow-md shadow-black/10 select-none" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 sm:w-10 sm:h-10 inline-flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-amber-600 hover:border-amber-600 hover:bg-amber-50/30 text-xs sm:text-sm font-medium transition duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-gray-200 text-gray-700 hover:text-amber-600 hover:border-amber-600 hover:bg-amber-50/30 text-xs sm:text-sm font-medium transition duration-200">
                Next
                <svg class="w-4 h-4 ml-1 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-gray-100 text-gray-300 text-xs sm:text-sm font-medium cursor-not-allowed select-none bg-gray-50/50">
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </nav>
@endif
