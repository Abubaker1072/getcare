<!-- Overlay -->
<div id="side-cart-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300" onclick="window.closeSideCart()"></div>

<!-- Drawer -->
<div id="side-cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-500 ease-in-out flex flex-col font-outfit">
    <!-- Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-white">
        <h2 class="text-xl font-bold text-gray-900 tracking-wide font-serif">Your Bag</h2>
        <button onclick="window.closeSideCart()" class="text-gray-400 hover:text-black transition-colors rounded-full p-2 hover:bg-gray-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Content (Cart Items) -->
    <div id="side-cart-items" class="flex-1 overflow-y-auto p-6 space-y-6">
        <!-- Loader -->
        <div class="flex justify-center items-center h-full text-gray-400">
            <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-100 p-6 bg-gray-50/50">
        <div class="flex justify-between items-center mb-4 text-gray-900 font-medium">
            <span>Subtotal</span>
            <span id="side-cart-total" class="font-sans font-bold text-lg text-slate-900">...</span>
        </div>
        <p class="text-xs text-gray-500 mb-6 text-center">Shipping, taxes, and discount codes calculated at checkout.</p>
        <a href="{{ route('checkout.index') }}" class="block w-full bg-black text-white text-center py-4 rounded-full font-bold text-sm tracking-widest hover:bg-gray-900 transition-colors shadow-lg">
            CHECKOUT
        </a>
        <a href="{{ route('cart') }}" class="block w-full text-center py-3 mt-2 text-sm text-gray-600 hover:text-black font-medium underline decoration-gray-300 underline-offset-4">
            View Cart
        </a>
    </div>
</div>

<script>
    window.openSideCart = function() {
        const overlay = document.getElementById('side-cart-overlay');
        const drawer = document.getElementById('side-cart-drawer');
        overlay.classList.remove('hidden');
        // Small delay to allow display block to apply before opacity transition
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            drawer.classList.remove('translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    };

    window.closeSideCart = function() {
        const overlay = document.getElementById('side-cart-overlay');
        const drawer = document.getElementById('side-cart-drawer');
        overlay.classList.add('opacity-0');
        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 300); // match duration
        document.body.style.overflow = '';
    };

    window.updateSideCart = function() {
        const itemsContainer = document.getElementById('side-cart-items');
        const totalContainer = document.getElementById('side-cart-total');
        
        fetch('/api/cart/summary')
            .then(res => res.json())
            .then(data => {
                const badges = document.querySelectorAll('#cart-badge-count');
                badges.forEach(badge => {
                    badge.innerText = data.cart_count;
                    if (data.cart_count > 0) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                });

                if(!data.items || data.items.length === 0) {
                    itemsContainer.innerHTML = '<div class="text-center text-gray-500 py-10">Your bag is empty.</div>';
                    totalContainer.innerText = data.formatted_subtotal || '{!! \App\Helpers\CurrencyHelper::format(0) !!}';
                    return;
                }

                let html = '';
                data.items.forEach(item => {
                    html += `
                        <div class="flex gap-4 group">
                            <div class="w-20 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="${item.image_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="${item.name}">
                            </div>
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="text-sm font-semibold text-gray-900 pr-4 leading-tight">${item.name}</h3>
                                    <button onclick="removeCartItem(${item.id})" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                <div class="text-sm font-medium text-gray-500 mb-3">${item.formatted_price}</div>
                                <div class="flex items-center border border-gray-200 rounded-full bg-white h-8 w-24 justify-between px-2">
                                    <button onclick="updateCartQty(${item.id}, ${item.quantity - 1})" class="text-gray-400 hover:text-black">−</button>
                                    <span class="text-xs font-semibold">${item.quantity}</span>
                                    <button onclick="updateCartQty(${item.id}, ${item.quantity + 1})" class="text-gray-400 hover:text-black">+</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                itemsContainer.innerHTML = html;
                totalContainer.innerText = data.formatted_subtotal;
            })
            .catch(err => {
                console.error('Failed to update side cart:', err);
                itemsContainer.innerHTML = '<div class="text-center text-red-500 py-10">Failed to load cart.</div>';
            });
    };

    window.updateCartQty = function(id, qty) {
        if(qty < 1) return;
        fetch('/cart/update/' + id, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: qty })
        }).then(() => {
            window.updateSideCart();
            if (window.location.pathname === '/cart' || window.location.pathname === '/checkout') {
                window.location.reload();
            }
        });
    };

    window.removeCartItem = function(id) {
        fetch('/cart/remove/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            window.updateSideCart();
            if (window.location.pathname === '/cart' || window.location.pathname === '/checkout') {
                window.location.reload();
            }
        });
    };
</script>
