@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Reel</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Update the details of your video reel.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.reels.index') }}" class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
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
        <form action="{{ route('admin.reels.update', $reel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Video File -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Replace Video File (Optional)</label>
                    <input type="file" name="video" accept="video/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty to keep current video. Max: 20MB.</p>
                    
                    <div class="mt-3">
                        <span class="text-xs font-bold text-slate-500 block mb-1">Current Video:</span>
                        <video src="{{ asset('storage/' . $reel->video_path) }}" class="w-40 h-24 bg-slate-100 rounded-xl object-cover border border-slate-200" controls muted></video>
                    </div>
                </div>

                <!-- Poster Image -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Replace Thumbnail / Poster (Optional)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty to keep current thumbnail. Max: 2MB.</p>

                    <div class="mt-3">
                        <span class="text-xs font-bold text-slate-500 block mb-1">Current Thumbnail:</span>
                        @if($reel->thumbnail_path)
                            <img src="{{ asset('storage/' . $reel->thumbnail_path) }}" class="w-40 h-24 bg-slate-100 rounded-xl object-cover border border-slate-200">
                        @else
                            <div class="w-40 h-24 bg-slate-50 rounded-xl border border-dashed border-slate-200 flex items-center justify-center">
                                <span class="text-slate-400 text-xs italic">No Thumbnail</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Caption</label>
                <input type="text" name="caption" value="{{ old('caption', $reel->caption) }}" placeholder="Used by the professionals..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Link to Product (Optional)</label>
                <select name="product_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    <option value="">Do Not Link to a Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $reel->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (${{ number_format($product->price, 2) }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1">If selected, a small product card will be linked below this reel.</p>
            </div>

            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_active', $reel->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-bold text-slate-700">Active (Visible on home page)</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Update Reel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
