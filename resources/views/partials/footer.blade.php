<footer class="bg-gray-900 text-gray-300">
    {{-- Main Footer Content --}}
    <div class="px-4 sm:px-6 lg:px-8 py-12 md:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto">
            {{-- Footer Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-8 md:gap-6 mb-12 md:mb-16">
                
                {{-- About Us Section --}}
                <div class="lg:col-span-1">
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">ABOUT US</h3>
                    <p class="text-xs md:text-sm leading-relaxed text-gray-400">
                        Our mission is simple: to transform traditional approaches to skincare with science-backed solutions. We want to empower people from all communities to find confidence and joy through better beauty routines
                    </p>
                </div>

                {{-- Explore Section --}}
                <div>
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">EXPLORE</h3>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Sitemap</a></li>
                        <li><a href="{{ route('blog') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Events</a></li>
                    </ul>
                </div>

                {{-- Resources Section --}}
                <div>
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">RESOURCES</h3>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">FSA/HSA</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Skin Quiz</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Collab with Us</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Business Inquiries</a></li>
                    </ul>
                </div>

                {{-- Support Section --}}
                <div>
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">SUPPORT</h3>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Payment</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Shipping Information</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Track Your Order</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Warranty Registration</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Returns & Warranty</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>

                {{-- Terms & Policy Section --}}
                <div>
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">TERMS & POLICY</h3>
                    <ul class="space-y-2 md:space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Terms of Service</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Refund policy</a></li>
                    </ul>
                </div>

                {{-- Subscribe Section --}}
                <div class="lg:col-span-1">
                    <h3 class="text-white font-bold text-sm md:text-base mb-4">SUBSCRIBE</h3>
                    <p class="text-xs md:text-sm leading-relaxed text-gray-400 mb-4">
                        Sign up to get the latest skincare news, discounts, and early access to new launches
                    </p>
                    
                    {{-- Email Input --}}
                    <input 
                        type="email" 
                        placeholder="Email (required)" 
                        class="w-full px-3 md:px-4 py-2.5 md:py-3 bg-gray-800 text-white text-xs md:text-sm border border-gray-700 rounded mb-3 md:mb-4 placeholder-gray-500 focus:outline-none focus:border-gray-600 transition"
                    >
                    
                    {{-- Phone Input with Country Selector --}}
                    <div class="flex gap-2 md:gap-3 mb-4 md:mb-5">
                        <select class="w-16 md:w-20 px-2 md:px-3 py-2.5 md:py-3 bg-gray-800 text-white text-xs md:text-sm border border-gray-700 rounded focus:outline-none focus:border-gray-600 transition">
                            <option>🇵🇰 +92</option>
                            <option>🇺🇸 +1</option>
                            <option>🇬🇧 +44</option>
                            <option>🇨🇦 +1</option>
                            <option>🇦🇺 +61</option>
                            <option>🇮🇳 +91</option>
                        </select>
                        <input 
                            type="tel" 
                            placeholder="Phone (Optional)" 
                            class="flex-1 px-3 md:px-4 py-2.5 md:py-3 bg-gray-800 text-white text-xs md:text-sm border border-gray-700 rounded placeholder-gray-500 focus:outline-none focus:border-gray-600 transition"
                        >
                    </div>
                    
                    {{-- Subscribe Button --}}
                    <button class="w-full px-4 md:px-6 py-2.5 md:py-3 bg-black text-white text-xs md:text-sm font-bold rounded hover:bg-gray-800 transition touch-none active:bg-gray-900 mb-4">
                        SUBSCRIBE
                    </button>
                    
                    {{-- Privacy Notice --}}
                    <p class="text-xs text-gray-500 leading-relaxed">
                        By signing up, you agree to receive marketing emails and text messages. View our <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition">privacy policy</a> and <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition">terms of service</a> for more info
                    </p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-700 pt-8 md:pt-10"></div>

            {{-- Footer Bottom --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 md:gap-6">
                {{-- Logo/Brand --}}
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-white">ProjecteBeauty</h2>
                </div>

                {{-- Social Links --}}
                <div class="flex items-center gap-4 md:gap-6">
                    <a href="#" class="text-gray-400 hover:text-white transition text-lg md:text-xl" aria-label="Facebook">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-lg md:text-xl" aria-label="Instagram">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.322a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-lg md:text-xl" aria-label="Twitter">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.6 10.6 0 01-9-5.5z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-lg md:text-xl" aria-label="YouTube">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136c.5-1.884.5-5.814.5-5.814s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>

                {{-- Copyright --}}
                <div class="text-xs md:text-sm text-gray-500">
                    © {{ date('Y') }} ProjecteBeauty. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>