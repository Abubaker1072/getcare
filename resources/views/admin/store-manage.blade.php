@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.store-manage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Store Management</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Update your business details, landing page hero customization, and dynamic countdown timer settings.</p>
            </div>
            <div class="flex space-x-3 items-center">
                <button type="button" onclick="if(confirm('Are you sure you want to reset all customizations to defaults? (jesa pehle tha, image background ke sath wesa hi ho jaye ga)')) document.getElementById('reset-defaults-form').submit();" class="px-5 py-2.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-xl text-sm font-bold shadow-sm hover:bg-rose-100 transition-all">
                    Reset to Defaults
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all flex items-center">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
                    Save Settings
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 border border-emerald-100 p-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-50 text-rose-600 border border-rose-100 p-4 rounded-xl text-sm font-bold shadow-sm">
                <p class="font-extrabold mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-xs font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Setup Sidebar Nav Tabs -->
            <div class="lg:col-span-1">
                <nav class="space-y-1.5" id="settings-nav">
                    <button type="button" onclick="switchTab('tab-profile')" id="nav-tab-profile" class="tab-btn w-full flex items-center px-4 py-3 bg-indigo-600 border border-indigo-600 rounded-2xl text-sm font-bold text-white shadow-sm text-left transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Business Profile
                    </button>
                    <button type="button" onclick="switchTab('tab-hero')" id="nav-tab-hero" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors">
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Hero Customizer
                    </button>
                    <button type="button" onclick="switchTab('tab-timer')" id="nav-tab-timer" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors">
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Countdown Timer
                    </button>
                    <button type="button" onclick="switchTab('tab-shipping-payments')" id="nav-tab-shipping-payments" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors">
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Shipping & Payments
                    </button>
                    <button type="button" onclick="switchTab('tab-layout')" id="nav-tab-layout" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors">
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Theme & Layout Customizer
                    </button>
                    <button type="button" onclick="switchTab('tab-content')" id="nav-tab-content" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors">
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                        Main Page Content
                    </button>
                </nav>
            </div>

            <!-- Form Cards (Tabs Container) -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Tab: Business Profile -->
                <div id="tab-profile" class="tab-content space-y-6">
                    <!-- Block 1: Profile -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Company Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Legal Business Name</label>
                                <input type="text" name="company_name" value="{{ \App\Models\StoreSetting::getValue('company_name', 'GetCare Beauty') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Support Phone</label>
                                <input type="text" name="support_phone" value="{{ \App\Models\StoreSetting::getValue('support_phone', '+92 300 1234567') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
        
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Customer Facing Email</label>
                                <input type="email" name="support_email" value="{{ \App\Models\StoreSetting::getValue('support_email', 'support@getcarebeauty.com') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>
        
                    <!-- Block 2: Address -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </span>
                            Primary Address
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Street Address</label>
                                <input type="text" name="street_address" value="{{ \App\Models\StoreSetting::getValue('street_address') }}" placeholder="e.g. 123 Main St, Suite 100" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">City</label>
                                <input type="text" name="city" value="{{ \App\Models\StoreSetting::getValue('city') }}" placeholder="City" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
        
                            <div class="col-span-2 md:col-span-1 grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">State</label>
                                    <input type="text" name="state" value="{{ \App\Models\StoreSetting::getValue('state') }}" placeholder="State" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">ZIP Code</label>
                                    <input type="text" name="zip_code" value="{{ \App\Models\StoreSetting::getValue('zip_code') }}" placeholder="ZIP" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Hero Customizer -->
                <div id="tab-hero" class="tab-content hidden space-y-6">
                    <!-- Default Hero Info -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
                                <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                Default Hero Banner
                            </h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle-hero-default" class="sr-only peer" onchange="switchHeroMode('default')" {{ \App\Models\StoreSetting::getValue('hero_active_mode', 'default') === 'default' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-bold text-slate-700">Turn ON</span>
                            </label>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Main Heading Title</label>
                                    <input type="text" name="hero_title" value="{{ \App\Models\StoreSetting::getValue('hero_title', 'SEMI-ANNUAL SALE') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Subtitle / Description</label>
                                    <input type="text" name="hero_subtitle" value="{{ \App\Models\StoreSetting::getValue('hero_subtitle', 'Science Your Skin Deserves') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Hero Media Type</label>
                                    <select name="hero_media_type" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-semibold cursor-pointer focus:bg-white focus:ring-2 focus:ring-indigo-500/20 outline-none">
                                        <option value="image" {{ \App\Models\StoreSetting::getValue('hero_media_type', 'image') === 'image' ? 'selected' : '' }}>Image Background</option>
                                        <option value="video" {{ \App\Models\StoreSetting::getValue('hero_media_type') === 'video' ? 'selected' : '' }}>Video Background (MP4)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Upload Hero Media (Image or Video)</label>
                                    <input type="file" name="hero_media" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                                    <p class="text-xs text-slate-400 mt-2 font-medium">Replaces the background of the landing page hero section. Max size: 20MB.</p>
                                </div>
                            </div>

                            @if(\App\Models\StoreSetting::getValue('hero_media_path'))
                            <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50/50">
                                <p class="text-xs font-bold text-slate-500 uppercase mb-2">Current Hero Background Preview:</p>
                                <div class="w-full max-w-sm rounded-xl overflow-hidden shadow-inner h-40 bg-slate-200 flex items-center justify-center">
                                    @if(\App\Models\StoreSetting::getValue('hero_media_type', 'image') === 'video')
                                        <video src="{{ asset('storage/' . \App\Models\StoreSetting::getValue('hero_media_path')) }}" muted controls class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . \App\Models\StoreSetting::getValue('hero_media_path')) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Slider Hero Info -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
                                <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                Slider Hero Background
                            </h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle-hero-slider" class="sr-only peer" onchange="switchHeroMode('slider')" {{ \App\Models\StoreSetting::getValue('hero_active_mode') === 'slider' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-bold text-slate-700">Turn ON</span>
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mb-6 -mt-3">Auto-looping slider. When turned ON, the Default Hero Banner will be automatically turned OFF.</p>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Slider Transition (Secs)</label>
                                    <input type="number" name="hero_slider_interval" value="{{ \App\Models\StoreSetting::getValue('hero_slider_interval', 20) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-semibold focus:bg-white focus:ring-2 focus:ring-indigo-500/20 outline-none" min="5">
                                </div>
                            </div>

                            <input type="hidden" name="hero_active_mode" id="hero_active_mode" value="{{ \App\Models\StoreSetting::getValue('hero_active_mode', 'default') }}">
                            
                            <script>
                                function switchHeroMode(mode) {
                                    document.getElementById('hero_active_mode').value = mode;
                                    if (mode === 'default') {
                                        document.getElementById('toggle-hero-slider').checked = false;
                                        document.getElementById('toggle-hero-default').checked = true;
                                    } else {
                                        document.getElementById('toggle-hero-default').checked = false;
                                        document.getElementById('toggle-hero-slider').checked = true;
                                    }
                                }
                            </script>

                            @php
                                $heroSliders = \App\Models\HeroSlider::all()->keyBy('sort_order');
                            @endphp

                            <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50">
                                <h4 class="text-sm font-bold text-slate-800 mb-4">Auto-Looping Slider Media (Max 3 Images, 2 Videos)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                    
                                    <!-- Image 1 -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Image 1</label>
                                        @if(isset($heroSliders[1]))
                                            <div class="w-full h-24 mb-2 rounded-lg overflow-hidden bg-white border border-slate-200">
                                                <img src="{{ asset('storage/' . $heroSliders[1]->media_path) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <input type="file" name="hero_sch_image_1" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-600 cursor-pointer">
                                    </div>
                                    
                                    <!-- Image 2 -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Image 2</label>
                                        @if(isset($heroSliders[2]))
                                            <div class="w-full h-24 mb-2 rounded-lg overflow-hidden bg-white border border-slate-200">
                                                <img src="{{ asset('storage/' . $heroSliders[2]->media_path) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <input type="file" name="hero_sch_image_2" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-600 cursor-pointer">
                                    </div>

                                    <!-- Image 3 -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Image 3</label>
                                        @if(isset($heroSliders[3]))
                                            <div class="w-full h-24 mb-2 rounded-lg overflow-hidden bg-white border border-slate-200">
                                                <img src="{{ asset('storage/' . $heroSliders[3]->media_path) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <input type="file" name="hero_sch_image_3" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-600 cursor-pointer">
                                    </div>

                                    <!-- Video 1 -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Video 1 (MP4)</label>
                                        @if(isset($heroSliders[4]))
                                            <div class="w-full h-24 mb-2 rounded-lg overflow-hidden bg-white border border-slate-200 relative">
                                                <video src="{{ asset('storage/' . $heroSliders[4]->media_path) }}" muted class="w-full h-full object-cover"></video>
                                                <span class="absolute bottom-1 right-1 bg-black/50 text-white text-[10px] px-1 rounded">VID</span>
                                            </div>
                                        @endif
                                        <input type="file" name="hero_sch_video_1" accept="video/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-rose-50 file:text-rose-600 cursor-pointer">
                                    </div>

                                    <!-- Video 2 -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Video 2 (MP4)</label>
                                        @if(isset($heroSliders[5]))
                                            <div class="w-full h-24 mb-2 rounded-lg overflow-hidden bg-white border border-slate-200 relative">
                                                <video src="{{ asset('storage/' . $heroSliders[5]->media_path) }}" muted class="w-full h-full object-cover"></video>
                                                <span class="absolute bottom-1 right-1 bg-black/50 text-white text-[10px] px-1 rounded">VID</span>
                                            </div>
                                        @endif
                                        <input type="file" name="hero_sch_video_2" accept="video/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-rose-50 file:text-rose-600 cursor-pointer">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Countdown Timer -->
                <div id="tab-timer" class="tab-content hidden space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Countdown Banner Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Timer Banner Status</label>
                                <select name="countdown_is_active" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-semibold cursor-pointer focus:bg-white focus:ring-2 focus:ring-indigo-500/20 outline-none">
                                    <option value="1" {{ \App\Models\StoreSetting::getValue('countdown_is_active', '1') === '1' ? 'selected' : '' }}>Active (Show Banner)</option>
                                    <option value="0" {{ \App\Models\StoreSetting::getValue('countdown_is_active') === '0' ? 'selected' : '' }}>Inactive (Hide Banner)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Countdown End Target Date/Time</label>
                                <input type="datetime-local" name="countdown_end_time" value="{{ \App\Models\StoreSetting::getValue('countdown_end_time') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-semibold focus:bg-white focus:ring-2 focus:ring-indigo-500/20 outline-none">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Discount Coupon / Promo Banner Text</label>
                                <input type="text" name="countdown_text" value="{{ \App\Models\StoreSetting::getValue('countdown_text', 'Up to 20% Off | Code REFRESH20') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                <p class="text-xs text-slate-400 mt-2 font-medium">This is the text that will be displayed in the red/amber banner at the top of the header, next to the ticking clock.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Shipping & Payments Settings -->
                <div id="tab-shipping-payments" class="tab-content hidden space-y-6">
                    <!-- Shipping Configuration -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </span>
                            Shipping Fee Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Shipping Status</label>
                                <select name="shipping_is_active" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-semibold cursor-pointer focus:bg-white focus:ring-2 focus:ring-indigo-500/20 outline-none">
                                    <option value="1" {{ \App\Models\StoreSetting::getValue('shipping_is_active', '1') === '1' ? 'selected' : '' }}>Active (Charge Shipping Fee)</option>
                                    <option value="0" {{ \App\Models\StoreSetting::getValue('shipping_is_active') === '0' ? 'selected' : '' }}>Inactive (Free Shipping)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Shipping Fee Amount (₨ in PKR)</label>
                                <input type="number" name="shipping_fee" step="0.01" value="{{ \App\Models\StoreSetting::getValue('shipping_fee', '150.00') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-bold focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Fee in store base currency (PKR). Will convert dynamically to other currencies.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Configuration -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            Payment Options
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- COD Config -->
                            <div class="border-b pb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-extrabold text-slate-800">Cash on Delivery (COD)</h4>
                                    <select name="cod_is_active" class="bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-3 py-1.5 text-xs font-bold cursor-pointer focus:bg-white focus:ring-1 focus:ring-indigo-500 outline-none">
                                        <option value="1" {{ \App\Models\StoreSetting::getValue('cod_is_active', '1') === '1' ? 'selected' : '' }}>Enabled</option>
                                        <option value="0" {{ \App\Models\StoreSetting::getValue('cod_is_active') === '0' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">COD Description / Help Text</label>
                                    <input type="text" name="cod_description" value="{{ \App\Models\StoreSetting::getValue('cod_description', 'Pay in cash when your order is delivered to your doorstep.') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>
                            </div>

                            <!-- Bank Transfer Config -->
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-extrabold text-slate-800">Direct Bank Transfer</h4>
                                    <select name="bank_is_active" class="bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-3 py-1.5 text-xs font-bold cursor-pointer focus:bg-white focus:ring-1 focus:ring-indigo-500 outline-none">
                                        <option value="1" {{ \App\Models\StoreSetting::getValue('bank_is_active', '1') === '1' ? 'selected' : '' }}>Enabled</option>
                                        <option value="0" {{ \App\Models\StoreSetting::getValue('bank_is_active', '0') === '0' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Bank Details (Shown at Checkout)</label>
                                    <textarea name="bank_details" rows="4" placeholder="Bank Name: Al Baraka Bank&#10;Account Number: 1234-5678-9012&#10;IBAN: PK12ALBK0000001234567890&#10;Account Title: GetCare Beauty Store" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('bank_details', "Bank Name: Al Baraka Bank\nAccount Number: 1234-5678-9012\nIBAN: PK12ALBK0000001234567890\nAccount Title: GetCare Beauty Store") }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Theme & Layout Customizer -->
                <div id="tab-layout" class="tab-content hidden space-y-6">
                    <!-- Theme Selection -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-2 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            </span>
                            Select Storefront Theme
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 font-medium pl-11">Choose a theme to redefine the visual aesthetic of your entire homepage, header, and footer.</p>
                        
                        @php
                            $selectedTheme = \App\Models\StoreSetting::getValue('homepage_theme', 'theme_1');
                        @endphp
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-11">
                            <!-- Theme 1 Card -->
                            <label class="relative flex flex-col p-6 bg-white border-2 {{ $selectedTheme === 'theme_1' ? 'border-indigo-600 ring-2 ring-indigo-500/20 shadow-md' : 'border-slate-200 hover:border-slate-300' }} rounded-2xl cursor-pointer transition-all group">
                                <input type="radio" name="homepage_theme" value="theme_1" class="sr-only" {{ $selectedTheme === 'theme_1' ? 'checked' : '' }} onchange="updateThemeSelection(this)">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-base font-bold text-slate-800">Theme 1: Classic Light</span>
                                    <span class="w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all theme-radio-outer {{ $selectedTheme === 'theme_1' ? 'border-indigo-600 bg-indigo-600' : '' }}">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white theme-radio-dot {{ $selectedTheme === 'theme_1' ? 'block' : 'hidden' }}"></span>
                                    </span>
                                </div>
                                <div class="w-full h-32 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden relative shadow-inner flex flex-col">
                                    <div class="h-6 bg-white border-b flex items-center px-3 justify-between">
                                        <div class="w-10 h-2 bg-slate-200 rounded"></div>
                                        <div class="flex gap-1">
                                            <div class="w-2.5 h-2.5 bg-slate-200 rounded-full"></div>
                                            <div class="w-2.5 h-2.5 bg-slate-200 rounded-full"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 p-3 flex flex-col justify-center items-center gap-1.5">
                                        <div class="w-2/3 h-3.5 bg-indigo-100 rounded"></div>
                                        <div class="w-1/2 h-2.5 bg-slate-200 rounded"></div>
                                        <div class="w-12 h-4 bg-indigo-600 rounded-full mt-1.5"></div>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-500 mt-3 font-medium">Warm, clean light background with elegant fonts and responsive collections.</span>
                            </label>

                            <!-- Theme 2 Card -->
                            <label class="relative flex flex-col p-6 bg-slate-900 border-2 {{ $selectedTheme === 'theme_2' ? 'border-amber-500 ring-2 ring-amber-500/20 shadow-md shadow-amber-950/20' : 'border-slate-800 hover:border-slate-700' }} rounded-2xl cursor-pointer transition-all group">
                                <input type="radio" name="homepage_theme" value="theme_2" class="sr-only" {{ $selectedTheme === 'theme_2' ? 'checked' : '' }} onchange="updateThemeSelection(this)">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-base font-bold text-amber-500">Theme 2: Midnight Luxury Dark</span>
                                    <span class="w-5 h-5 rounded-full border-2 border-slate-700 flex items-center justify-center transition-all theme-radio-outer {{ $selectedTheme === 'theme_2' ? 'border-amber-500 bg-amber-500' : '' }}">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900 theme-radio-dot {{ $selectedTheme === 'theme_2' ? 'block' : 'hidden' }}"></span>
                                    </span>
                                </div>
                                <div class="w-full h-32 rounded-xl bg-slate-950 border border-slate-850 overflow-hidden relative shadow-inner flex flex-col">
                                    <div class="h-6 bg-slate-900 border-b border-slate-800 flex items-center px-3 justify-between">
                                        <div class="w-10 h-2 bg-slate-700 rounded"></div>
                                        <div class="flex gap-1">
                                            <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div>
                                            <div class="w-2.5 h-2.5 bg-slate-700 rounded-full"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 p-3 flex flex-col justify-center items-center gap-1.5 bg-gradient-to-b from-slate-950 to-slate-900">
                                        <div class="w-2/3 h-3.5 bg-amber-500/20 border border-amber-500/30 rounded"></div>
                                        <div class="w-1/2 h-2.5 bg-slate-700 rounded"></div>
                                        <div class="w-12 h-4 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full mt-1.5"></div>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 mt-3 font-medium">Ultra-premium dark aesthetic, metallic gold/bronze gradients, and glowing accents.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Layout Customization -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-2 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </span>
                            Reorder & Customize Sections
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 font-medium pl-11">Reorder homepage elements using the Up/Down controls, or toggle their visibility using the hide/show button.</p>
                        
                        @php
                            $homepageLayout = \App\Models\StoreSetting::getHomepageLayout();
                        @endphp
                        
                        <input type="hidden" name="homepage_layout" id="homepage_layout_input" value="{{ json_encode($homepageLayout) }}">
                        
                        <div class="space-y-3 pl-11" id="sections-container">
                            @foreach($homepageLayout as $section)
                            <div class="section-item flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:shadow-sm transition-all" data-id="{{ $section['id'] }}" data-name="{{ $section['name'] }}">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 text-slate-400 flex items-center justify-center flex-shrink-0 cursor-default">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16"></path></svg>
                                    </span>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800 leading-none section-title">{{ $section['name'] }}</h4>
                                        <span class="text-[10px] uppercase tracking-widest font-bold mt-1 inline-block section-visibility-status {{ $section['visible'] ? 'text-slate-400' : 'text-rose-400' }}">{{ $section['visible'] ? 'Visible' : 'Hidden' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <!-- Visibility Toggle -->
                                    <button type="button" onclick="toggleSectionVisibility(this)" class="visibility-btn p-2 rounded-lg border {{ $section['visible'] ? 'bg-indigo-50 border-indigo-100 text-indigo-600 hover:bg-indigo-100' : 'bg-slate-100 border-slate-200 text-slate-400 hover:bg-slate-200' }} transition-colors animate-all" title="Toggle visibility">
                                        <svg class="w-4 h-4 eye-icon {{ $section['visible'] ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg class="w-4 h-4 eye-off-icon {{ $section['visible'] ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path></svg>
                                    </button>
                                    
                                    <!-- Order Buttons -->
                                    <button type="button" onclick="moveSection(this, 'up')" class="p-2 rounded-lg border bg-white border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors" title="Move Up">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    </button>
                                    <button type="button" onclick="moveSection(this, 'down')" class="p-2 rounded-lg border bg-white border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors" title="Move Down">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tab: Main Page Content -->
                <div id="tab-content" class="tab-content hidden space-y-6">
                    <!-- Complete Routine Section Images -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012-2.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            Complete Routine Section Customizer
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Side: Product Image -->
                            <div class="border border-slate-100 rounded-2xl p-6 bg-slate-50/50">
                                <h4 class="text-sm font-bold text-slate-800 mb-3">Left Side (Product Image)</h4>
                                
                                @if(\App\Models\StoreSetting::getValue('routine_product_image_path'))
                                    <div class="w-full h-48 mb-4 rounded-xl overflow-hidden shadow-inner bg-slate-200">
                                        <img src="{{ asset('storage/' . \App\Models\StoreSetting::getValue('routine_product_image_path')) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Upload Custom Image</label>
                                <input type="file" name="routine_product_image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                                <p class="text-xs text-slate-400 mt-2 font-medium">Replaces the product/routine steps image. Max size: 5MB.</p>
                            </div>

                            <!-- Right Side: Lifestyle Image -->
                            <div class="border border-slate-100 rounded-2xl p-6 bg-slate-50/50">
                                <h4 class="text-sm font-bold text-slate-800 mb-3">Right Side (Lifestyle Image)</h4>
                                
                                @if(\App\Models\StoreSetting::getValue('routine_lifestyle_image_path'))
                                    <div class="w-full h-48 mb-4 rounded-xl overflow-hidden shadow-inner bg-slate-200">
                                        <img src="{{ asset('storage/' . \App\Models\StoreSetting::getValue('routine_lifestyle_image_path')) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Upload Custom Image</label>
                                <input type="file" name="routine_lifestyle_image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                                <p class="text-xs text-slate-400 mt-2 font-medium">Replaces the right lifestyle background image. Max size: 5MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- The Skin Edit Articles Customizer -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-2 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-5a2 2 0 00-2-2z"></path></svg>
                            </span>
                            "The Skin Edit" (Articles Section)
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 font-medium pl-11">Customize the title, text, destination URL, and cover image for all three skin care articles shown on the homepage.</p>
                        
                        <div class="space-y-8 pl-11">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50">
                                    <h4 class="text-base font-extrabold text-slate-800 mb-4 pb-2 border-b border-slate-200/60">Article {{ $i }}</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Left column: Title, Text, Link -->
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Article Title</label>
                                                <input type="text" name="article_{{ $i }}_title" value="{{ \App\Models\StoreSetting::getValue('article_' . $i . '_title') }}" placeholder="Enter article title" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Description / Body Text</label>
                                                <textarea name="article_{{ $i }}_text" rows="3" placeholder="Enter article summary/description" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('article_' . $i . '_text') }}</textarea>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Button / CTA Link (URL)</label>
                                                <input type="text" name="article_{{ $i }}_link" value="{{ \App\Models\StoreSetting::getValue('article_' . $i . '_link') }}" placeholder="/blog/skincare-routine or https://..." class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                            </div>
                                        </div>
                                        
                                        <!-- Right column: Image upload and preview -->
                                        <div class="flex flex-col justify-between">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Cover Image</label>
                                                <input type="file" name="article_{{ $i }}_image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                                                <p class="text-[11px] text-slate-400 mt-1 font-medium">Upload custom image. Max size: 5MB.</p>
                                            </div>
                                            
                                            <div class="mt-4 md:mt-0">
                                                <span class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Active Cover Image:</span>
                                                <div class="w-full h-32 rounded-xl overflow-hidden bg-slate-200 shadow-inner border border-slate-200">
                                                    @if(\App\Models\StoreSetting::getValue('article_' . $i . '_image_path'))
                                                        <img src="{{ asset('storage/' . \App\Models\StoreSetting::getValue('article_' . $i . '_image_path')) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                                            <span class="text-xs font-semibold">Using Default Placeholder</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Why Choose Us Customizer -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8 mt-6">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-2 flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            "Why Choose Us" Section Customizer
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 font-medium pl-11">Customize the section title, subtitle, and the details for each of the three philosophy cards.</p>
                        
                        <div class="space-y-6 pl-11">
                            <!-- Section Heading Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border border-slate-200 rounded-2xl bg-slate-50">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Section Subtitle</label>
                                    <input type="text" name="why_choose_us_subtitle" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_subtitle', 'Our Philosophy') }}" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Section Title</label>
                                    <input type="text" name="why_choose_us_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_title', 'Why Choose Us') }}" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Card 1 -->
                                <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50">
                                    <h4 class="text-sm font-extrabold text-slate-800 mb-4 pb-1.5 border-b border-slate-200/60 flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-pink-500 mr-2"></span> Card 1 (Advanced Tech)
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Title</label>
                                            <input type="text" name="why_choose_us_card1_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_title', 'Advanced Tech') }}" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Description</label>
                                            <textarea name="why_choose_us_card1_desc" rows="3" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_desc', 'FDA-cleared devices and premium formulations engineered for visible results.') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2 -->
                                <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50">
                                    <h4 class="text-sm font-extrabold text-slate-800 mb-4 pb-1.5 border-b border-slate-200/60 flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span> Card 2 (Expert Care)
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Title</label>
                                            <input type="text" name="why_choose_us_card2_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_title', 'Expert Care') }}" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Description</label>
                                            <textarea name="why_choose_us_card2_desc" rows="3" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_desc', 'Professional guidance and fully customized skincare routines for your unique needs.') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50">
                                    <h4 class="text-sm font-extrabold text-slate-800 mb-4 pb-1.5 border-b border-slate-200/60 flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Card 3 (Guaranteed Results)
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Title</label>
                                            <input type="text" name="why_choose_us_card3_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_title', 'Guaranteed Results') }}" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card Description</label>
                                            <textarea name="why_choose_us_card3_desc" rows="3" class="w-full bg-white border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_desc', 'Experience visible transformations driven by our proven, high-end beauty solutions.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            // Show requested tab content
            document.getElementById(tabId).classList.remove('hidden');

            // Reset navigation button classes
            document.querySelectorAll('#settings-nav button').forEach(btn => {
                btn.className = "tab-btn w-full flex items-center px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium text-left transition-colors";
                if (btn.querySelector('svg')) {
                    btn.querySelector('svg').classList.add('opacity-70');
                }
            });

            // Set active button styles
            const activeBtn = document.getElementById('nav-' + tabId);
            if(activeBtn) {
                activeBtn.className = "tab-btn w-full flex items-center px-4 py-3 bg-indigo-600 border border-indigo-600 rounded-2xl text-sm font-bold text-white shadow-sm text-left transition-all";
                if (activeBtn.querySelector('svg')) {
                    activeBtn.querySelector('svg').classList.remove('opacity-70');
                }
            }
        }

        function updateThemeSelection(input) {
            const cards = input.closest('.grid').querySelectorAll('label');
            cards.forEach(card => {
                const isTheme1 = card.querySelector('input').value === 'theme_1';
                const outerSpan = card.querySelector('.theme-radio-outer');
                const dotSpan = card.querySelector('.theme-radio-dot');
                if (isTheme1) {
                    card.className = "relative flex flex-col p-6 bg-white border-2 border-slate-200 hover:border-slate-300 rounded-2xl cursor-pointer transition-all group";
                    outerSpan.className = "w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all theme-radio-outer";
                } else {
                    card.className = "relative flex flex-col p-6 bg-slate-900 border-2 border-slate-800 hover:border-slate-700 rounded-2xl cursor-pointer transition-all group";
                    outerSpan.className = "w-5 h-5 rounded-full border-2 border-slate-700 flex items-center justify-center transition-all theme-radio-outer";
                }
                dotSpan.classList.add('hidden');
            });

            const activeCard = input.closest('label');
            const outerActiveSpan = activeCard.querySelector('.theme-radio-outer');
            const dotActiveSpan = activeCard.querySelector('.theme-radio-dot');
            const isTheme1Selected = input.value === 'theme_1';
            if (isTheme1Selected) {
                activeCard.className = "relative flex flex-col p-6 bg-white border-2 border-indigo-600 ring-2 ring-indigo-500/20 shadow-md rounded-2xl cursor-pointer transition-all group";
                outerActiveSpan.className = "w-5 h-5 rounded-full border-2 border-indigo-600 bg-indigo-600 flex items-center justify-center transition-all theme-radio-outer";
            } else {
                activeCard.className = "relative flex flex-col p-6 bg-slate-900 border-2 border-amber-500 ring-2 ring-amber-500/20 shadow-md shadow-amber-950/20 rounded-2xl cursor-pointer transition-all group";
                outerActiveSpan.className = "w-5 h-5 rounded-full border-2 border-amber-500 bg-amber-500 flex items-center justify-center transition-all theme-radio-outer";
            }
            dotActiveSpan.classList.remove('hidden');
        }

        function moveSection(btn, direction) {
            const item = btn.closest('.section-item');
            const container = document.getElementById('sections-container');
            
            if (direction === 'up') {
                const prev = item.previousElementSibling;
                if (prev) {
                    container.insertBefore(item, prev);
                }
            } else if (direction === 'down') {
                const next = item.nextElementSibling;
                if (next) {
                    container.insertBefore(next, item);
                }
            }
            
            serializeLayout();
        }

        function toggleSectionVisibility(btn) {
            const item = btn.closest('.section-item');
            const eyeIcon = btn.querySelector('.eye-icon');
            const eyeOffIcon = btn.querySelector('.eye-off-icon');
            const statusSpan = item.querySelector('.section-visibility-status');
            
            const isVisible = eyeIcon.classList.contains('hidden');
            
            if (isVisible) {
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
                btn.className = "visibility-btn p-2 rounded-lg border bg-indigo-50 border-indigo-100 text-indigo-600 hover:bg-indigo-100 transition-colors animate-all";
                statusSpan.innerText = "Visible";
                statusSpan.className = "text-[10px] uppercase tracking-widest font-bold mt-1 inline-block section-visibility-status text-slate-400";
            } else {
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
                btn.className = "visibility-btn p-2 rounded-lg border bg-slate-100 border-slate-200 text-slate-400 hover:bg-slate-200 transition-colors animate-all";
                statusSpan.innerText = "Hidden";
                statusSpan.className = "text-[10px] uppercase tracking-widest font-bold mt-1 inline-block section-visibility-status text-rose-400";
            }
            
            serializeLayout();
        }

        function serializeLayout() {
            const items = document.querySelectorAll('#sections-container .section-item');
            const layout = [];
            
            items.forEach(item => {
                const id = item.getAttribute('data-id');
                const name = item.getAttribute('data-name');
                const isVisible = !item.querySelector('.eye-icon').classList.contains('hidden');
                
                layout.push({
                    id: id,
                    name: name,
                    visible: isVisible
                });
            });
            
            document.getElementById('homepage_layout_input').value = JSON.stringify(layout);
        }
    </script>

    <form id="reset-defaults-form" action="{{ route('admin.store-manage.reset') }}" method="POST" class="hidden">
        @csrf
    </form>
@endsection