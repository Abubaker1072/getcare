@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Product</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Update the details of this product.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
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
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Compare Price</label>
                    <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Discount Price</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                    <select name="category_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-6 border border-slate-200 rounded-xl p-6 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Product Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 1</label>
                        @if($product->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Image 1" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="image" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 2 (Optional)</label>
                        @if($product->image_1)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image_1) }}" alt="Image 2" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="image_1" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 3 (Optional)</label>
                        @if($product->image_2)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image_2) }}" alt="Image 3" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="image_2" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 4 (Optional)</label>
                        @if($product->image_3)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image_3) }}" alt="Image 4" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="image_3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3">Select Cover Photo</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image" class="text-indigo-600 focus:ring-indigo-500" {{ $product->cover_image == $product->image ? 'checked' : '' }}>
                            <span class="text-sm font-medium">Image 1</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_1" class="text-indigo-600 focus:ring-indigo-500" {{ $product->cover_image == $product->image_1 && $product->image_1 ? 'checked' : '' }}>
                            <span class="text-sm font-medium">Image 2</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_2" class="text-indigo-600 focus:ring-indigo-500" {{ $product->cover_image == $product->image_2 && $product->image_2 ? 'checked' : '' }}>
                            <span class="text-sm font-medium">Image 3</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_3" class="text-indigo-600 focus:ring-indigo-500" {{ $product->cover_image == $product->image_3 && $product->image_3 ? 'checked' : '' }}>
                            <span class="text-sm font-medium">Image 4</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $product->is_active ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-bold text-slate-700">Active (Visible to customers)</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection