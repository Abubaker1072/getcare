@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.hot-deal-promos.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-3 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add Promo Banner</h1>
        <p class="text-sm text-slate-500 mt-1 font-medium">Create a custom promotional banner featuring a product on the left and a video on the right.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-6 md:p-8">
        <form action="{{ route('admin.hot-deal-promos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-800 mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('title') border-rose-500 @enderror" placeholder="e.g. Perfect hair with Argan Oil">
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product -->
                <div>
                    <label for="product_id" class="block text-sm font-semibold text-slate-800 mb-2">Associate Product (Optional)</label>
                    <select name="product_id" id="product_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (${{ number_format($product->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-800 mb-2">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('description') border-rose-500 @enderror" placeholder="e.g. Moisturizes and protects hair.">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Button Text -->
                <div>
                    <label for="button_text" class="block text-sm font-semibold text-slate-800 mb-2">Button Text <span class="text-red-500">*</span></label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text', 'Check Product') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('button_text') border-rose-500 @enderror" placeholder="e.g. CHECK PRODUCT">
                    @error('button_text')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button URL -->
                <div>
                    <label for="button_url" class="block text-sm font-semibold text-slate-800 mb-2">Button URL (Fallback)</label>
                    <input type="text" name="button_url" id="button_url" value="{{ old('button_url') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('button_url') border-rose-500 @enderror" placeholder="e.g. /product/argan-oil (Leave blank if product is associated)">
                    @error('button_url')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image Upload (Left Side Showed Image) -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-800 mb-2">Product Image / Logo (Left Side)</label>
                    <input type="file" name="image" id="image" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('image') border-rose-500 @enderror">
                    <p class="text-slate-400 text-xs mt-1.5">Mimes: png, jpg, jpeg, webp. Max 2MB.</p>
                    @error('image')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload (Right Side Video) -->
                <div>
                    <label for="video" class="block text-sm font-semibold text-slate-800 mb-2">Promo Video (Right Side)</label>
                    <input type="file" name="video" id="video" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none @error('video') border-rose-500 @enderror">
                    <p class="text-slate-400 text-xs mt-1.5">Mimes: mp4, mov, webm. Max 20MB.</p>
                    @error('video')
                        <p class="text-rose-500 text-xs mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Active Checkbox -->
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-semibold text-slate-800">Publish immediately (Active)</label>
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex space-x-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Save Promo Banner
                </button>
                <a href="{{ route('admin.hot-deal-promos.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
