@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Store Settings</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Configure your website's global preferences.</p>
        </div>
        <button class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
            Save Changes
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Navigation for Forms -->
        <div class="lg:col-span-1">
            <nav class="space-y-2">
                <a href="#" class="block px-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-indigo-600 shadow-sm">General Details</a>
                <a href="#" class="block px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium transition-colors">Payment Gateways</a>
                <a href="#" class="block px-4 py-3 text-slate-500 hover:text-slate-900 rounded-2xl text-sm font-medium transition-colors">Shipping Zones</a>
            </nav>
        </div>

        <!-- Form Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Store Name</label>
                        <input type="text" value="Arden's Print" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Contact Email</label>
                        <input type="email" value="admin@ardensprint.com" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-2.5 font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Store Description</label>
                        <textarea rows="4" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3 font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">We sell the best premium apparel in the industry.</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection