@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Store Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Configure global business preferences and convert currency rates.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40 p-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-455 border border-rose-100 dark:border-rose-900/40 p-4 rounded-xl text-sm font-bold shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-455 border border-rose-100 dark:border-rose-900/40 p-4 rounded-xl text-sm font-bold shadow-sm">
            <p class="font-extrabold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-xs font-semibold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation for Forms -->
        <div class="lg:col-span-1">
            <nav class="space-y-1.5" id="settings-tabs-nav">
                <button type="button" onclick="switchSettingsTab('tab-general')" id="nav-tab-general" class="tab-btn w-full flex items-center px-4 py-3 bg-indigo-600 dark:bg-indigo-700 border border-indigo-600 dark:border-indigo-700 rounded-2xl text-sm font-bold text-white shadow-sm text-left transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 3m0-3a2 2 0 110 3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    General details
                </button>
                <button type="button" onclick="switchSettingsTab('tab-homepage')" id="nav-tab-homepage" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-2xl text-sm font-medium text-left transition-colors">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Homepage Settings
                </button>
                <button type="button" onclick="switchSettingsTab('tab-footer')" id="nav-tab-footer" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-2xl text-sm font-medium text-left transition-colors">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    Footer Settings
                </button>
                <button type="button" onclick="switchSettingsTab('tab-currencies')" id="nav-tab-currencies" class="tab-btn w-full flex items-center px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-2xl text-sm font-medium text-left transition-colors">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Currencies Settings
                </button>
            </nav>
        </div>

        <!-- Forms Container -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Tab 1: General Settings -->
            <div id="tab-general" class="settings-tab-content space-y-6">
                <form action="{{ route('admin.settings.general') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <div class="flex items-center justify-between border-b dark:border-slate-800 pb-4 mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Store Global Details</h3>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors">
                                Save Details
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Store Public Name</label>
                                <input type="text" name="company_name" value="{{ \App\Models\StoreSetting::getValue('company_name', 'GetCare Beauty') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Support Email</label>
                                <input type="email" name="support_email" value="{{ \App\Models\StoreSetting::getValue('support_email', 'support@getcarebeauty.com') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Store Description / About</label>
                                <textarea name="store_description" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('store_description', 'Premium beauty and clinical skincare devices delivered to your home.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab: Homepage Settings -->
            <div id="tab-homepage" class="settings-tab-content hidden space-y-6">
                <form action="{{ route('admin.settings.homepage') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <div class="flex items-center justify-between border-b dark:border-slate-800 pb-4 mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Homepage: Why Choose Us</h3>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors">
                                Save Details
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Section Subtitle</label>
                                <input type="text" name="why_choose_us_subtitle" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_subtitle', 'Our Philosophy') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Section Title</label>
                                <input type="text" name="why_choose_us_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_title', 'Why Choose Us') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                        </div>

                        <!-- Card 1 -->
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Feature Card 1</h4>
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Title</label>
                                <input type="text" name="why_choose_us_card1_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_title', 'Advanced Tech') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Description</label>
                                <textarea name="why_choose_us_card1_desc" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card1_desc', 'FDA-cleared devices and premium formulations engineered for visible results.') }}</textarea>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Feature Card 2</h4>
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Title</label>
                                <input type="text" name="why_choose_us_card2_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_title', 'Expert Care') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Description</label>
                                <textarea name="why_choose_us_card2_desc" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card2_desc', 'Professional guidance and fully customized skincare routines for your unique needs.') }}</textarea>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Feature Card 3</h4>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Title</label>
                                <input type="text" name="why_choose_us_card3_title" value="{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_title', 'Guaranteed Results') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Description</label>
                                <textarea name="why_choose_us_card3_desc" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('why_choose_us_card3_desc', 'Experience visible transformations driven by our proven, high-end beauty solutions.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab: Footer Settings -->
            <div id="tab-footer" class="settings-tab-content hidden space-y-6">
                <form action="{{ route('admin.settings.footer') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                        <div class="flex items-center justify-between border-b dark:border-slate-800 pb-4 mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Footer & Social Settings</h3>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors">
                                Save Details
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">About Us Text</label>
                                <textarea name="footer_about_text" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ \App\Models\StoreSetting::getValue('footer_about_text', 'Our mission is simple: to transform traditional approaches to skincare with science-backed solutions. We want to empower people from all communities to find confidence and joy through better beauty routines.') }}</textarea>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Contact Email</label>
                                <input type="email" name="footer_contact_email" value="{{ \App\Models\StoreSetting::getValue('footer_contact_email') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Contact Phone</label>
                                <input type="text" name="footer_contact_phone" value="{{ \App\Models\StoreSetting::getValue('footer_contact_phone') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Contact Address</label>
                                <input type="text" name="footer_contact_address" value="{{ \App\Models\StoreSetting::getValue('footer_contact_address') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                        </div>

                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Social Media Links</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Facebook URL</label>
                                <input type="url" name="footer_facebook" value="{{ \App\Models\StoreSetting::getValue('footer_facebook') }}" placeholder="https://facebook.com/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Instagram URL</label>
                                <input type="url" name="footer_instagram" value="{{ \App\Models\StoreSetting::getValue('footer_instagram') }}" placeholder="https://instagram.com/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Twitter/X URL</label>
                                <input type="url" name="footer_twitter" value="{{ \App\Models\StoreSetting::getValue('footer_twitter') }}" placeholder="https://twitter.com/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">YouTube URL</label>
                                <input type="url" name="footer_youtube" value="{{ \App\Models\StoreSetting::getValue('footer_youtube') }}" placeholder="https://youtube.com/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="tab-currencies" class="settings-tab-content hidden space-y-8">
                <!-- Currencies List Table -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
                    <div class="p-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-slate-900 dark:text-white text-base">Active Currencies</h3>
                            <p class="text-xs text-slate-450 dark:text-slate-400 font-medium mt-0.5">Edit rates or toggle default currencies. PKR is base currency (rate = 1.0).</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
                                    <th class="p-5 font-bold">Currency Code</th>
                                    <th class="p-5 font-bold text-center">Symbol</th>
                                    <th class="p-5 font-bold text-center">Exchange Rate</th>
                                    <th class="p-5 font-bold text-center">Is Default</th>
                                    <th class="p-5 font-bold text-center">Is Active</th>
                                    <th class="p-5 font-bold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-800/60">
                                @forelse($currencies as $curr)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="p-5 font-extrabold text-slate-900 dark:text-white uppercase">
                                            {{ $curr->code }}
                                            @if($curr->is_default)
                                                <span class="ml-2 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-md text-[10px] tracking-wide font-extrabold uppercase border border-indigo-100 dark:border-indigo-900/40">Default</span>
                                            @endif
                                        </td>
                                        <td class="p-5 text-center">
                                            <form id="update-form-{{ $curr->id }}" action="{{ route('admin.settings.currencies.update', $curr->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="symbol" value="{{ $curr->symbol }}" class="w-12 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg px-2 py-1 text-center font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-1 focus:ring-indigo-500">
                                            </form>
                                        </td>
                                        <td class="p-5 text-center">
                                            <input type="number" form="update-form-{{ $curr->id }}" name="exchange_rate" step="0.000001" value="{{ $curr->exchange_rate }}" class="w-28 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg px-2 py-1 text-center font-bold outline-none focus:bg-white dark:focus:bg-slate-900 focus:ring-1 focus:ring-indigo-500">
                                        </td>
                                        <td class="p-5 text-center">
                                            <input type="checkbox" form="update-form-{{ $curr->id }}" name="is_default" value="1" {{ $curr->is_default ? 'checked disabled' : '' }} class="rounded border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="this.form.submit()">
                                        </td>
                                        <td class="p-5 text-center">
                                            <input type="checkbox" form="update-form-{{ $curr->id }}" name="is_active" value="1" {{ $curr->is_active ? 'checked' : '' }} {{ $curr->is_default ? 'disabled' : '' }} class="rounded border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500 cursor-pointer" onchange="this.form.submit()">
                                        </td>
                                        <td class="p-5 text-right whitespace-nowrap">
                                            <button type="submit" form="update-form-{{ $curr->id }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 dark:hover:bg-indigo-955 px-3 py-1.5 rounded-xl transition-colors">
                                                Update
                                            </button>
                                            @if(!$curr->is_default)
                                                <form action="{{ route('admin.settings.currencies.destroy', $curr->id) }}" method="POST" class="inline ml-1" onsubmit="return confirm('Delete currency {{ $curr->code }}? This will reset all converted items back to PKR.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:text-rose-900 dark:hover:text-rose-300 bg-rose-50 dark:bg-rose-955 hover:bg-rose-100 dark:hover:bg-rose-900/40 px-3 py-1.5 rounded-xl transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                            No currencies found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Currency Form -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-6 flex items-center">
                        <span class="bg-indigo-100 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 w-8 h-8 rounded-full flex items-center justify-center mr-3 font-mono font-bold">+</span>
                        Add New Currency
                    </h3>
                    
                    <form action="{{ route('admin.settings.currencies.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Currency Code *</label>
                                <input type="text" name="code" placeholder="e.g. CAD" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-bold uppercase focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1.5 font-medium">Standard 3-letter currency code.</p>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Currency Symbol *</label>
                                <input type="text" name="symbol" placeholder="e.g. C$" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                <p class="text-[10px] text-slate-400 dark:text-slate-550 mt-1.5 font-medium">Character shown next to numbers.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Exchange Rate *</label>
                                <input type="number" name="exchange_rate" step="0.000001" placeholder="e.g. 0.0048" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                <p class="text-[10px] text-slate-400 dark:text-slate-550 mt-1.5 font-medium">Rate relative to base PKR (1.0 PKR = X Currency).</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 bg-slate-55 dark:bg-slate-850 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_default" value="1" id="add_is_default" class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                <label for="add_is_default" class="text-xs font-bold text-slate-600 dark:text-slate-450 cursor-pointer select-none">Set as global default</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" id="add_is_active" checked class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                <label for="add_is_active" class="text-xs font-bold text-slate-600 dark:text-slate-450 cursor-pointer select-none">Mark as active</label>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 transition-all hover:-translate-y-0.5">
                                Add Currency
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchSettingsTab(tabId) {
            document.querySelectorAll('.settings-tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');

            document.querySelectorAll('#settings-tabs-nav button').forEach(btn => {
                btn.className = "tab-btn w-full flex items-center px-4 py-3 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-2xl text-sm font-medium text-left transition-colors";
                if (btn.querySelector('svg')) {
                    btn.querySelector('svg').classList.add('opacity-70');
                }
            });

            const activeBtn = document.getElementById('nav-' + tabId.replace('tab-', 'tab-'));
            if(activeBtn) {
                activeBtn.className = "tab-btn w-full flex items-center px-4 py-3 bg-indigo-600 dark:bg-indigo-700 border border-indigo-600 dark:border-indigo-700 rounded-2xl text-sm font-bold text-white shadow-sm text-left transition-all";
                if (activeBtn.querySelector('svg')) {
                    activeBtn.querySelector('svg').classList.remove('opacity-70');
                }
            }
        }
    </script>
@endsection