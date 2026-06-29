@php
    $homepageTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
    $isTheme2 = ($homepageTheme === 'theme_2');
@endphp

<footer class="{{ $isTheme2 ? 'bg-[#08080a] text-slate-300 border-t border-white/5' : 'bg-[#FAF6F2] text-[#3D352E] border-t border-[#EAE2DB]' }} font-sans">
    {{-- Main Footer Content --}}
    <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto">
            {{-- Footer Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-5 sm:mb-8">
                
                {{-- About Us Section --}}
                <div class="lg:col-span-1">
                    <h3 class="font-serif font-bold text-[13px] tracking-[0.25em] uppercase {{ $isTheme2 ? 'text-white' : 'text-[#3D352E]' }} mb-2.5">ABOUT US</h3>
                    <p class="text-xs leading-relaxed {{ $isTheme2 ? 'text-slate-400' : 'text-[#6B5E53]' }} font-medium mb-2.5">
                        {{ \App\Models\StoreSetting::getValue('footer_about_text', 'Our mission is simple: to transform traditional approaches to skincare with science-backed solutions. We want to empower people from all communities to find confidence and joy through better beauty routines.') }}
                    </p>
                    
                    @if(\App\Models\StoreSetting::getValue('footer_contact_email') || \App\Models\StoreSetting::getValue('footer_contact_phone'))
                    <div class="space-y-1.5 mt-2.5 pt-2.5 border-t {{ $isTheme2 ? 'border-white/10' : 'border-[#EAE2DB]' }}">
                        @if(\App\Models\StoreSetting::getValue('footer_contact_email'))
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 {{ $isTheme2 ? 'text-amber-500' : 'text-[#B76E79]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:{{ \App\Models\StoreSetting::getValue('footer_contact_email') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors">
                                {{ \App\Models\StoreSetting::getValue('footer_contact_email') }}
                            </a>
                        </div>
                        @endif
                        @if(\App\Models\StoreSetting::getValue('footer_contact_phone'))
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 {{ $isTheme2 ? 'text-amber-500' : 'text-[#B76E79]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <a href="tel:{{ \App\Models\StoreSetting::getValue('footer_contact_phone') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors">
                                {{ \App\Models\StoreSetting::getValue('footer_contact_phone') }}
                            </a>
                        </div>
                        @endif
                        @if(\App\Models\StoreSetting::getValue('footer_contact_address'))
                        <div class="flex items-start gap-2 pt-1">
                            <svg class="w-4 h-4 mt-0.5 {{ $isTheme2 ? 'text-amber-500' : 'text-[#B76E79]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400' : 'text-[#6B5E53]' }}">
                                {{ \App\Models\StoreSetting::getValue('footer_contact_address') }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Quick Links Section --}}
                <div>
                    <h3 class="font-serif font-bold text-[13px] tracking-[0.25em] uppercase {{ $isTheme2 ? 'text-white' : 'text-[#3D352E]' }} mb-2.5">QUICK LINKS</h3>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('home') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Home</a></li>
                        <li><a href="{{ route('products.all') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Shop All</a></li>
                        <li><a href="{{ route('categories') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Categories</a></li>
                        <li><a href="{{ route('hot-deals') }}" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Hot Deals</a></li>
                    </ul>
                </div>

                {{-- Terms & Policy Section --}}
                <div>
                    <h3 class="font-serif font-bold text-[13px] tracking-[0.25em] uppercase {{ $isTheme2 ? 'text-white' : 'text-[#3D352E]' }} mb-2.5">TERMS & POLICY</h3>
                    <ul class="space-y-1.5">
                        <li><a href="#" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Privacy Policy</a></li>
                        <li><a href="#" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Terms of Service</a></li>
                        <li><a href="#" class="text-xs font-semibold {{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors tracking-wider">Refund Policy</a></li>
                    </ul>
                </div>

                {{-- Subscribe Section --}}
                <div class="lg:col-span-1">
                    <h3 class="font-serif font-bold text-[13px] tracking-[0.25em] uppercase {{ $isTheme2 ? 'text-white' : 'text-[#3D352E]' }} mb-2.5">SUBSCRIBE</h3>
                    <p class="text-xs leading-relaxed {{ $isTheme2 ? 'text-slate-400' : 'text-[#6B5E53]' }} mb-2.5 font-medium">
                        Sign up to get the latest skincare news, discounts, and early access to new launches.
                    </p>
                    
                    {{-- Email Input --}}
                    <input 
                        type="email" 
                        placeholder="Email (required)" 
                        class="w-full px-4 py-2 {{ $isTheme2 ? 'bg-slate-900 text-white border-white/5 focus:border-amber-400' : 'bg-white text-[#3D352E] border-[#EAE2DB] focus:border-[#B76E79]' }} text-xs border placeholder-gray-400 focus:outline-none transition"
                    >
                    
                    {{-- Phone Input with Country Selector --}}
                    <div class="flex gap-2 mb-2.5 mt-1.5">
                        <select class="w-20 px-2 py-2 {{ $isTheme2 ? 'bg-slate-900 text-white border-white/5 focus:border-amber-400' : 'bg-white text-[#3D352E] border-[#EAE2DB] focus:border-[#B76E79]' }} text-xs border focus:outline-none transition select-none">
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇵🇰 +92</option>
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇺🇸 +1</option>
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇬🇧 +44</option>
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇨🇦 +1</option>
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇦🇺 +61</option>
                            <option class="{{ $isTheme2 ? 'bg-slate-950 text-white' : '' }}">🇮🇳 +91</option>
                        </select>
                        <input 
                            type="tel" 
                            placeholder="Phone (Optional)" 
                            class="flex-1 px-4 py-2 {{ $isTheme2 ? 'bg-slate-900 text-white border-white/5 focus:border-amber-400' : 'bg-white text-[#3D352E] border-[#EAE2DB] focus:border-[#B76E79]' }} text-xs border placeholder-gray-400 focus:outline-none transition"
                        >
                    </div>
                    
                    {{-- Subscribe Button --}}
                    <button class="w-full px-4 py-2 {{ $isTheme2 ? 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-slate-950 font-bold' : 'bg-[#3D352E] text-white hover:bg-[#B76E79]' }} text-xs tracking-[0.2em] hover:shadow-lg transition duration-300 uppercase">
                        SUBSCRIBE
                    </button>
                    
                    {{-- Privacy Notice --}}
                    <p class="text-[10px] text-gray-500 leading-relaxed mt-2.5 font-medium">
                        By signing up, you agree to receive marketing emails and text messages. View our <a href="{{ route('home') }}" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors underline">privacy policy</a> and <a href="{{ route('home') }}" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#6B5E53] hover:text-[#B76E79]' }} transition-colors underline">terms of service</a> for more info.
                    </p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t {{ $isTheme2 ? 'border-white/5' : 'border-[#EAE2DB]' }} pt-4 sm:pt-6"></div>

            {{-- Footer Bottom --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                {{-- Logo/Brand --}}
                <div class="text-center sm:text-left">
                    <a href="{{ route('home') }}" class="text-lg font-serif font-bold tracking-[0.25em] {{ $isTheme2 ? 'text-amber-500' : 'text-[#3D352E]' }} uppercase leading-none">
                        GetCare
                        <span class="block text-[8px] font-sans font-light tracking-[0.3em] mt-0.5 opacity-90 {{ $isTheme2 ? 'text-slate-400' : '' }}">BEAUTY</span>
                    </a>
                </div>

                {{-- Social Links --}}
                <div class="flex items-center gap-6">
                    @if(\App\Models\StoreSetting::getValue('footer_facebook'))
                    <a href="{{ \App\Models\StoreSetting::getValue('footer_facebook') }}" target="_blank" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#3D352E] hover:text-[#B76E79]' }} transition-colors" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if(\App\Models\StoreSetting::getValue('footer_instagram'))
                    <a href="{{ \App\Models\StoreSetting::getValue('footer_instagram') }}" target="_blank" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#3D352E] hover:text-[#B76E79]' }} transition-colors" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.322a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/></svg>
                    </a>
                    @endif
                    @if(\App\Models\StoreSetting::getValue('footer_twitter'))
                    <a href="{{ \App\Models\StoreSetting::getValue('footer_twitter') }}" target="_blank" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#3D352E] hover:text-[#B76E79]' }} transition-colors" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.6 10.6 0 01-9-5.5z"/></svg>
                    </a>
                    @endif
                    @if(\App\Models\StoreSetting::getValue('footer_youtube'))
                    <a href="{{ \App\Models\StoreSetting::getValue('footer_youtube') }}" target="_blank" class="{{ $isTheme2 ? 'text-slate-400 hover:text-amber-400' : 'text-[#3D352E] hover:text-[#B76E79]' }} transition-colors" aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136c.5-1.884.5-5.814.5-5.814s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif
                </div>

                {{-- Copyright --}}
                <div class="text-[10px] text-gray-500 font-semibold tracking-wider">
                    © {{ date('Y') }} GetCare Beauty. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>