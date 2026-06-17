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
    </script>
</body>
</html>