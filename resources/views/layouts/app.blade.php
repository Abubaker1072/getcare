<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Landing</title>

    {{-- Tailwind CDN (for quick UI) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

</head>
<body class="bg-white text-gray-800">



    {{-- Header --}}
    @include('partials.header')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Premium Toasts --}}
    @include('partials.toasts')

    {{-- Side Cart Drawer --}}
    @include('partials.side-cart')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global Cart Logic
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
                return res.json();
            })
            .then(data => {
                // Show Aesthetic Toast
                SwiperToast.fire({
                    icon: 'success',
                    title: 'Added to your beautiful routine!'
                });
                
                // Fetch & Update Cart Data
                window.updateSideCart();
                
                // Open Side Cart
                window.openSideCart();
            })
            .catch(err => {
                SwiperToast.fire({
                    icon: 'error',
                    title: err.message
                });
            });
        };

        const SwiperToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-xl shadow-lg border border-gray-100 z-50',
                title: 'font-outfit text-sm font-medium'
            }
        });



        // 2. Scroll Reveal Intersection Observer
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal-on-scroll');
            if (reveals.length > 0 && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '0px 0px -40px 0px'
                });
                reveals.forEach(el => observer.observe(el));
            }

        });

        // 3. Place Order Success Confetti Burst
        @if(session('success') && str_contains(session('success'), 'Order placed successfully'))
            document.addEventListener('DOMContentLoaded', function() {
                var duration = 4 * 1000;
                var end = Date.now() + duration;

                (function frame() {
                    confetti({
                        particleCount: 4,
                        angle: 60,
                        spread: 60,
                        origin: { x: 0 },
                        colors: ['#f59e0b', '#fbbf24', '#ffffff', '#f43f5e']
                    });
                    confetti({
                        particleCount: 4,
                        angle: 120,
                        spread: 60,
                        origin: { x: 1 },
                        colors: ['#f59e0b', '#fbbf24', '#ffffff', '#f43f5e']
                    });

                    if (Date.now() < end) {
                        requestAnimationFrame(frame);
                    }
                }());
            });
        @endif

        // Review Modal Logic
        window.openReviewModal = function(productId, productName, productImageUrl) {
            const modal = document.getElementById('review-modal');
            const pIdInput = document.getElementById('review-product-id');
            const pNameHeader = document.getElementById('review-product-name');
            const pImg = document.getElementById('review-product-image');

            if (!modal) return;

            pIdInput.value = productId;
            pNameHeader.textContent = productName;
            pImg.src = productImageUrl || 'https://via.placeholder.com/150';

            // Reset Rating state
            window.setReviewRating(0);
            document.getElementById('review-title').value = '';
            document.getElementById('review-text').value = '';

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        };

        window.closeReviewModal = function() {
            const modal = document.getElementById('review-modal');
            if (!modal) return;

            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        // Interactive Star Rating Logic
        let currentRating = 0;
        window.setReviewRating = function(rating) {
            currentRating = rating;
            document.getElementById('review-rating-value').value = rating > 0 ? rating : '';
            updateStarsDisplay(rating);
        };

        function updateStarsDisplay(rating) {
            const stars = document.querySelectorAll('.review-star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-amber-400');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Attach Star Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.review-star-btn');
            stars.forEach(star => {
                const ratingValue = parseInt(star.getAttribute('data-rating'));
                
                star.addEventListener('mouseenter', () => {
                    updateStarsDisplay(ratingValue);
                });
                
                star.addEventListener('mouseleave', () => {
                    updateStarsDisplay(currentRating);
                });
                
                star.addEventListener('click', () => {
                    window.setReviewRating(ratingValue);
                });
            });
        });
    </script>

    {{-- Write Review Modal --}}
    <div id="review-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300" onclick="if(event.target === this) closeReviewModal();">
        <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-gray-100 relative transform scale-95 transition-all duration-300 flex flex-col max-h-[90vh]">
            
            <!-- Close Button -->
            <button type="button" onclick="closeReviewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-50 transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Modal Header / Product Preview -->
            <div class="bg-slate-50 p-6 border-b border-gray-100 flex items-center gap-4">
                <img id="review-product-image" src="" alt="Product" class="w-16 h-16 object-contain bg-white rounded-xl border border-gray-200 p-1 flex-shrink-0">
                <div>
                    <span class="text-[10px] font-bold text-amber-600 tracking-wider uppercase">WRITE A REVIEW FOR</span>
                    <h3 id="review-product-name" class="font-serif text-lg text-gray-900 leading-snug line-clamp-2 pr-6"></h3>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('review.store') }}" method="POST" class="p-6 sm:p-8 flex-1 overflow-y-auto space-y-4 m-0">
                @csrf
                <input type="hidden" name="product_id" id="review-product-id">

                <!-- Stars selection -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 tracking-wider uppercase mb-2">YOUR RATING</label>
                    <div class="flex items-center gap-1.5" id="review-stars-container">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-rating="{{ $i }}" class="review-star-btn text-gray-300 hover:scale-110 transition-transform duration-150 focus:outline-none">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="review-rating-value" required>
                </div>

                <!-- Name & Email Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="review-name" class="block text-xs font-bold text-gray-700 tracking-wider uppercase mb-1.5">NAME</label>
                        <input type="text" name="name" id="review-name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-black focus:ring-1 focus:ring-black outline-none transition-all placeholder:text-gray-400" placeholder="Your name">
                    </div>
                    <div>
                        <label for="review-email" class="block text-xs font-bold text-gray-700 tracking-wider uppercase mb-1.5">EMAIL</label>
                        <input type="email" name="email" id="review-email" required value="{{ auth()->check() ? auth()->user()->email : '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-black focus:ring-1 focus:ring-black outline-none transition-all placeholder:text-gray-400" placeholder="Your email address">
                    </div>
                </div>

                <!-- Review Title -->
                <div>
                    <label for="review-title" class="block text-xs font-bold text-gray-700 tracking-wider uppercase mb-1.5">REVIEW TITLE</label>
                    <input type="text" name="title" id="review-title" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-black focus:ring-1 focus:ring-black outline-none transition-all placeholder:text-gray-400" placeholder="e.g. Life changing device!">
                </div>

                <!-- Review Text -->
                <div>
                    <label for="review-text" class="block text-xs font-bold text-gray-700 tracking-wider uppercase mb-1.5">REVIEW DESCRIPTION</label>
                    <textarea name="text" id="review-text" rows="4" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-black focus:ring-1 focus:ring-black outline-none transition-all placeholder:text-gray-400 leading-relaxed" placeholder="Write your review here. What did you like? How was your transformation story?"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#1a1a1a] hover:bg-black text-white py-3.5 rounded-full font-semibold text-sm tracking-wider transition-colors shadow-md mt-2 flex items-center justify-center gap-2">
                    SUBMIT REVIEW
                </button>
            </form>
        </div>
    </div>
    {{-- Floating Stack: Back to Top, WhatsApp Chat, Virtual Concierge --}}
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>

    {{-- WhatsApp Chat Button (Bottom-Left) --}}
    @php
        $supportPhone = \App\Models\StoreSetting::getValue('support_phone', '');
        $cleanPhone = preg_replace('/[^0-9]/', '', $supportPhone);
        if (empty($cleanPhone)) {
            $cleanPhone = '923001234567'; // Fallback
        }
    @endphp
    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="fixed bottom-6 left-6 z-[95] w-12 h-12 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-105 active:scale-95 focus:outline-none animate-float" title="Chat on WhatsApp">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.413 9.863-9.83.001-2.624-1.013-5.091-2.859-6.937C16.638 1.993 14.183.98 11.55.979c-5.442 0-9.866 4.414-9.87 9.831-.001 1.714.453 3.39 1.316 4.873L2.005 20.3l4.642-1.146zm12.333-6.6c-.328-.164-1.94-.959-2.241-1.07-.302-.111-.521-.165-.74.165-.219.329-.85 1.07-1.041 1.289-.192.219-.383.247-.712.083a9.05 9.05 0 01-2.637-1.624 9.95 9.95 0 01-1.823-2.27c-.192-.329-.021-.507.143-.671.147-.148.328-.384.493-.575.164-.192.219-.329.328-.549.11-.219.055-.411-.027-.575-.083-.164-.74-1.78-.85-2.054-.3-.728-.606-.63-.829-.63-.219-.002-.47-.002-.72-.002-.25 0-.656.093-.997.466-.34.373-1.3 1.268-1.3 3.093 0 1.825 1.33 3.59 1.516 3.837.187.247 2.616 3.994 6.337 5.602.885.383 1.577.611 2.115.782.889.282 1.698.242 2.337.146.713-.107 1.94-.794 2.213-1.52.274-.728.274-1.352.192-1.488-.083-.137-.302-.219-.63-.383z"/>
        </svg>
    </a>

    <div class="fixed bottom-6 right-6 z-[95] flex flex-col gap-3.5 items-end font-sans">
        
        {{-- Floating Popover Card --}}
        <div id="concierge-popover" class="mb-2 w-72 sm:w-80 bg-white/95 dark:bg-slate-950/95 backdrop-blur-md rounded-2xl border border-gray-150 dark:border-white/10 shadow-2xl overflow-hidden hidden opacity-0 translate-y-4 transition-all duration-300 pointer-events-auto">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500 flex items-center justify-center text-lg select-none">
                    ✨
                </div>
                <div>
                    <h4 class="font-bold text-xs sm:text-sm tracking-wide">GetCare Concierge</h4>
                    <p class="text-[9px] sm:text-[10px] text-amber-400 font-medium">Beauty Advisor Online</p>
                </div>
            </div>
            
            {{-- Body Options --}}
            <div class="p-4 space-y-2.5">
                <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed font-medium mb-3">
                    {{ \App\Models\StoreSetting::getValue('concierge_welcome_text', 'Hello! How can we elevate your skincare and beauty routine today?') }}
                </p>
                
                @for($i = 1; $i <= 4; $i++)
                    @php
                        $title = \App\Models\StoreSetting::getValue("concierge_link_{$i}_title");
                        $url = \App\Models\StoreSetting::getValue("concierge_link_{$i}_url");
                        
                        // Default Fallbacks
                        if ($i === 1) {
                            $title = $title ?: 'Discover Devices';
                            $url = $url ?: route('products.all');
                        } elseif ($i === 2) {
                            $title = $title ?: 'My Routine Dashboard';
                            $url = $url ?: route('dashboard');
                        } elseif ($i === 3) {
                            $title = $title ?: 'Beauty Routine Bible';
                            $url = $url ?: route('blog');
                        } elseif ($i === 4) {
                            $title = $title ?: 'Track My Order';
                            $url = $url ?: route('dashboard') . '#orders';
                        }
                        
                        $emojis = [1 => '🛍️', 2 => '📅', 3 => '✨', 4 => '📦'];
                        $emoji = $emojis[$i] ?? '✨';
                    @endphp
                    @if($title)
                        <a href="{{ $url }}" class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-slate-900 hover:bg-amber-500/10 dark:hover:bg-amber-500/10 hover:text-amber-600 dark:hover:text-amber-400 rounded-xl text-xs font-bold text-gray-700 dark:text-slate-200 tracking-wide transition-all border border-transparent hover:border-amber-500/20">
                            <span class="flex items-center gap-2">{{ $emoji }} {{ $title }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @endif
                @endfor
            </div>

            {{-- Footer info --}}
            <div class="bg-slate-50 dark:bg-slate-900/55 p-2 text-center text-[9px] text-gray-400 border-t border-gray-100 dark:border-white/5">
                Powered by GetCare Beauty Concierge
            </div>

        </div>



        {{-- Floating Trigger Bubble --}}
        @php
            $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
            $isTheme2 = ($homepageTheme === 'theme_2');
        @endphp
        <button id="concierge-trigger" type="button" class="w-14 h-14 bg-gradient-to-tr from-slate-950 via-slate-900 to-slate-800 text-white rounded-full flex items-center justify-center shadow-2xl hover:shadow-[0_8px_30px_rgba(245,158,11,0.25)] border {{ $isTheme2 ? 'border-amber-500/30' : 'border-white/10' }} transition-all duration-300 animate-float hover:scale-105 active:scale-95 focus:outline-none">
            <svg class="w-6 h-6 text-amber-400 icon-chat" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <svg class="w-6 h-6 text-amber-400 icon-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

    </div>

    {{-- Widget Trigger Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('concierge-trigger');
            const popover = document.getElementById('concierge-popover');
            const scrollTopBtn = document.getElementById('scroll-top-btn');
            
            // 1. Concierge Popover Toggle
            if (trigger && popover) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = popover.classList.contains('hidden');
                    
                    if (isHidden) {
                        popover.classList.remove('hidden');
                        setTimeout(() => {
                            popover.classList.remove('opacity-0', 'translate-y-4');
                            popover.classList.add('opacity-100', 'translate-y-0');
                        }, 10);
                        trigger.querySelector('.icon-chat').classList.add('hidden');
                        trigger.querySelector('.icon-close').classList.remove('hidden');
                        trigger.classList.remove('animate-float');
                    } else {
                        closeConcierge();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (popover && !popover.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
                        closeConcierge();
                    }
                });

                function closeConcierge() {
                    popover.classList.remove('opacity-100', 'translate-y-0');
                    popover.classList.add('opacity-0', 'translate-y-4');
                    trigger.querySelector('.icon-chat').classList.remove('hidden');
                    trigger.querySelector('.icon-close').classList.add('hidden');
                    setTimeout(() => {
                        popover.classList.add('hidden');
                        trigger.classList.add('animate-float');
                    }, 300);
                }
            }
        });
    </script>
</body>
</html>