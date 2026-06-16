@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add New Brand</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Create a new partner brand in the system.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-rose-50 text-rose-600 border border-rose-100 p-4 rounded-xl text-sm font-bold">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden p-8">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Brand Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Lumière Clinical" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tagline (Optional)</label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="Pioneers in LED Technology" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Brand Logo (Optional)</label>
                    <input type="file" name="logo" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                    <p class="text-xs text-slate-400 mt-1">Image displayed in the marquee loop. Max: 2MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Boutique Cover Photo (Optional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                    <p class="text-xs text-slate-400 mt-1">Lifestyle cover photo for the boutique card. Max: 2MB.</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Description / Boutique Details</label>
                <textarea name="description" rows="4" placeholder="Brief boutique summary displayed on hover..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                    <span class="ml-2 text-sm font-bold text-slate-700">Active (Visible on brands page)</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm font-bold text-slate-700">Featured Boutique (Show in boutique list)</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Save Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
