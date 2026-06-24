@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.marquee-images.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-3 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Marquee Image</h1>
        <p class="text-sm text-slate-500 mt-1 font-medium">Update marquee image, sort order, link, or publication status.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-6 md:p-8">
        <form action="{{ route('admin.marquee-images.update', $marqueeImage->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Image Preview and File Input -->
            <div>
                <label for="image" class="block text-sm font-semibold text-slate-800 mb-2">Change Image</label>
                @if($marqueeImage->image_path)
                    <div class="mb-3 w-48 h-32 bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ asset('storage/' . $marqueeImage->image_path) }}" class="w-full h-full object-cover">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('image') border-rose-500 @enderror">
                <p class="text-slate-400 text-xs mt-1.5 font-medium">Mimes: png, jpg, jpeg, gif, svg, webp. Max 2MB. Leave blank to keep current.</p>
                @error('image')
                    <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title (Optional) -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-800 mb-2">Title / Alt Text (Optional)</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $marqueeImage->title) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-semibold text-slate-800 mb-2">Sort Order <span class="text-red-500">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $marqueeImage->sort_order) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('sort_order') border-rose-500 @enderror">
                    @error('sort_order')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Link URL -->
            <div>
                <label for="link_url" class="block text-sm font-semibold text-slate-800 mb-2">Link URL (Optional)</label>
                <input type="text" name="link_url" id="link_url" value="{{ old('link_url', $marqueeImage->link_url) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('link_url') border-rose-500 @enderror">
                @error('link_url')
                    <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Checkbox -->
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $marqueeImage->is_active ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-semibold text-slate-800">Publish immediately (Active)</label>
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex space-x-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Update Marquee Image
                </button>
                <a href="{{ route('admin.marquee-images.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
