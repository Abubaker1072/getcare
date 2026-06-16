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
    </script>

    <form id="reset-defaults-form" action="{{ route('admin.store-manage.reset') }}" method="POST" class="hidden">
        @csrf
    </form>
@endsection