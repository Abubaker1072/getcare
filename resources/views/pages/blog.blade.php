@extends('layouts.app')

@section('content')

{{-- Custom Luxury Animations & Map Styles --}}
<style>
    /* Entrance Animations */
    .fade-up-contact {
        animation: fadeUpContactAnim 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    
    @keyframes fadeUpContactAnim {
        to { opacity: 1; transform: translateY(0); }
    }

    .delay-c1 { animation-delay: 150ms; }
    .delay-c2 { animation-delay: 300ms; }
    .delay-c3 { animation-delay: 450ms; }
    .delay-c4 { animation-delay: 600ms; }

    /* Custom Input Styling */
    .luxury-input {
        width: 100%;
        background-color: #F8F9FA;
        border: 1px solid #E2E8F0;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: #0f172a;
        transition: all 0.3s ease;
        outline: none;
    }
    .luxury-input:focus {
        background-color: #ffffff;
        border-color: #d97706; /* amber-600 */
        box-shadow: 0 0 0 1px #d97706;
    }
    .luxury-input::placeholder {
        color: #94a3b8;
        font-weight: 300;
    }

    /* Premium Map Filter */
    .premium-map {
        filter: grayscale(100%) contrast(1.1) opacity(0.85);
        transition: filter 0.5s ease;
    }
    .premium-map:hover {
        filter: grayscale(50%) contrast(1) opacity(1);
    }

    /* Star Rating Interaction */
    .star-rating svg {
        transition: transform 0.2s ease, color 0.2s ease;
        cursor: pointer;
    }
    .star-rating svg:hover,
    .star-rating svg:hover ~ svg {
        transform: scale(1.1);
    }
</style>

{{-- Contact & Map Section --}}
<section class="bg-white py-20 md:py-32 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="text-center mb-16 md:mb-20">
            <span class="fade-up-contact text-amber-600 text-[10px] font-bold tracking-[0.3em] uppercase mb-4 block">
                Concierge Services
            </span>
            <h1 class="fade-up-contact delay-c1 text-4xl md:text-5xl lg:text-6xl font-light tracking-tight text-slate-900 mb-6">
                Get in <span class="italic font-serif text-slate-500">Touch</span>
            </h1>
            <p class="fade-up-contact delay-c2 text-slate-500 max-w-2xl mx-auto font-light text-base md:text-lg">
                Our skincare experts and dedicated concierge team are here to assist you with personalized protocols, order inquiries, and technical support.
            </p>
        </div>

        {{-- Split Layout: Contact Form & Map --}}
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-stretch">
            
            {{-- Left: Contact Form --}}
            <div class="fade-up-contact delay-c3 w-full lg:w-5/12 flex flex-col justify-center">
                <div class="bg-white p-8 md:p-10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100">
                    <h3 class="text-2xl font-light text-slate-900 mb-6">Send a Message</h3>
                    
                    <form action="#" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <input type="text" placeholder="First Name" class="luxury-input" required>
                            </div>
                            <div>
                                <input type="text" placeholder="Last Name" class="luxury-input" required>
                            </div>
                        </div>
                        
                        <div>
                            <input type="email" placeholder="Email Address" class="luxury-input" required>
                        </div>
                        
                        <div>
                            <select class="luxury-input text-slate-500 appearance-none cursor-pointer">
                                <option value="" disabled selected>Select Inquiry Type</option>
                                <option value="support">Product Support</option>
                                <option value="order">Order Status</option>
                                <option value="consultation">Skincare Consultation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <textarea placeholder="How can we assist you today?" rows="4" class="luxury-input resize-none" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white px-8 py-4 rounded-xl text-xs font-bold tracking-[0.2em] uppercase hover:bg-amber-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            Send Inquiry
                        </button>
                    </form>

                    {{-- Direct Contact Info --}}
                    <div class="mt-10 pt-8 border-t border-slate-100 grid grid-cols-2 gap-6">
                        <div>
                            <span class="block text-[10px] font-bold tracking-widest uppercase text-slate-400 mb-2">Email Us</span>
                            <a href="mailto:concierge@brand.com" class="text-sm font-medium text-slate-900 hover:text-amber-600 transition-colors">concierge@brand.com</a>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold tracking-widest uppercase text-slate-400 mb-2">Call Us</span>
                            <a href="tel:+18001234567" class="text-sm font-medium text-slate-900 hover:text-amber-600 transition-colors">+1 (800) 123-4567</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Map & Location --}}
            <div class="fade-up-contact delay-c4 w-full lg:w-7/12 relative rounded-2xl overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100 group min-h-[400px]">
                
                {{-- Interactive Overlay (Disappears on hover for map interaction) --}}
                <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent pointer-events-none transition-colors duration-500 z-10"></div>
                
                {{-- Location Card Overlay --}}
                <div class="absolute top-6 left-6 right-6 md:right-auto md:w-80 bg-white/95 backdrop-blur-md p-6 rounded-xl shadow-xl z-20 border border-white/20">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Flagship Boutique</h4>
                            <span class="text-xs text-slate-500">Beverly Hills, CA</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        456 Luxury Avenue, Suite 100<br>
                        Beverly Hills, CA 90210
                    </p>
                    <a href="#" class="text-xs font-bold text-amber-600 uppercase tracking-widest hover:text-slate-900 transition-colors flex items-center gap-1">
                        Get Directions
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                {{-- Embedded Google Map (Premium Styled) --}}
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3304.3643799839934!2d-118.40306168478201!3d34.08579458059635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bc04d6d147ab%3A0xd6601fcb801a3556!2sBeverly%20Hills%2C%20CA%2090210!5e0!3m2!1sen!2sus!4v1655000000000!5m2!1sen!2sus" 
                    width="100%" 
                    height="100%" 
                    style="border:0; min-height: 500px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="premium-map absolute inset-0">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- Client Reviews & Add Review Section --}}
<section class="bg-[#FAFAFA] py-20 md:py-32 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        <div class="text-center mb-16 md:mb-20">
            <span class="fade-up-contact text-amber-600 text-[10px] font-bold tracking-[0.3em] uppercase mb-4 block">
                Client Experiences
            </span>
            <h2 class="fade-up-contact delay-c1 text-3xl md:text-5xl font-light tracking-tight text-slate-900">
                Stories of <span class="italic font-serif text-slate-500">Transformation</span>
            </h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
            
            {{-- Left: Display Reviews Grid --}}
            <div class="w-full lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $reviews = [
                        [
                            'name' => 'Eleanor R.',
                            'product' => 'Clinical Renewal Bundle',
                            'title' => 'Absolutely Transformative',
                            'text' => 'Within three weeks of using the LED protocol alongside the 24K serum, my fine lines have visibly diminished. The clinical quality is undeniable.'
                        ],
                        [
                            'name' => 'Sophia M.',
                            'product' => 'Microcurrent Device',
                            'title' => 'My Secret Weapon',
                            'text' => 'I no longer need professional facials. This device provides an instant lift that lasts all day. The packaging and experience are pure luxury.'
                        ],
                        [
                            'name' => 'Claire T.',
                            'product' => 'Advanced Retinol Duo',
                            'title' => 'Gentle yet Powerful',
                            'text' => 'Finally, a retinol formulation that doesn\'t irritate my sensitive skin. Waking up to a glowing, plump complexion has become my new normal.'
                        ],
                        [
                            'name' => 'Isabella L.',
                            'product' => 'Ultrasonic Skin Scrubber',
                            'title' => 'Spa Results at Home',
                            'text' => 'The extraction mode cleared my pores in a way I didn\'t think was possible outside of a dermatologist\'s office. Worth every penny.'
                        ]
                    ];
                @endphp

                @foreach($reviews as $index => $review)
                <div class="fade-up-contact bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-500" style="animation-delay: {{ ($index * 150) + 200 }}ms;">
                    {{-- Stars --}}
                    <div class="flex gap-1 text-amber-400 mb-4">
                        @for($i=0; $i<5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    
                    <h4 class="font-bold text-slate-900 mb-3 text-lg">{{ $review['title'] }}</h4>
                    <p class="text-slate-500 text-sm font-light leading-relaxed mb-6 italic">"{{ $review['text'] }}"</p>
                    
                    <div class="border-t border-slate-50 pt-4 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ $review['name'] }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $review['product'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Right: Add a Review Form --}}
            <div class="fade-up-contact delay-c4 w-full lg:w-1/3 sticky top-10">
                <div class="bg-slate-900 text-white p-8 md:p-10 rounded-2xl shadow-2xl relative overflow-hidden">
                    {{-- Decorative Blur --}}
                    <div class="absolute top-0 right-0 w-48 h-48 bg-amber-500/20 rounded-full blur-[60px] pointer-events-none"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-light mb-2 text-white">Share Your Journey</h3>
                        <p class="text-slate-400 text-sm font-light mb-8">Your experience inspires others. Leave a review to help our community discover their perfect protocol.</p>
                        
                        <form action="#" method="POST" class="space-y-5">
                            
                            {{-- Interactive Star Rating Mockup --}}
                            <div class="mb-6">
                                <span class="block text-xs text-slate-400 uppercase tracking-widest mb-3">Overall Rating</span>
                                <div class="flex gap-2 star-rating text-slate-600 hover:text-amber-400">
                                    @for($i=0; $i<5; $i++)
                                    <svg class="w-8 h-8 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <input type="text" placeholder="Your Name" class="w-full bg-white/5 border border-white/10 p-4 rounded-lg text-sm text-white focus:border-amber-500 focus:bg-white/10 outline-none transition-all placeholder:text-slate-500" required>
                            </div>

                            <div>
                                <input type="text" placeholder="Review Title" class="w-full bg-white/5 border border-white/10 p-4 rounded-lg text-sm text-white focus:border-amber-500 focus:bg-white/10 outline-none transition-all placeholder:text-slate-500" required>
                            </div>

                            <div>
                                <textarea placeholder="Tell us about your experience..." rows="4" class="w-full bg-white/5 border border-white/10 p-4 rounded-lg text-sm text-white focus:border-amber-500 focus:bg-white/10 outline-none transition-all placeholder:text-slate-500 resize-none" required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-amber-600 text-white px-8 py-4 rounded-xl text-xs font-bold tracking-[0.2em] uppercase hover:bg-white hover:text-slate-900 transition-all duration-300">
                                Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection