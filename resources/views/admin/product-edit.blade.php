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
                <h3 class="text-lg font-bold text-slate-800 mb-4">Product Details (Dynamic Frontend)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tags (Comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', $product->tags) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. Green tea, Argan Oil">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Promo Text</label>
                        <input type="text" name="promo_text" value="{{ old('promo_text', $product->promo_text) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. 🎟️ Use code Beauty for 10% OFF!">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">How to Use (Simple Text)</label>
                        <textarea name="how_to_use" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">{{ old('how_to_use', $product->how_to_use) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ingredients (Simple Text)</label>
                        <textarea name="ingredients" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">{{ old('ingredients', $product->ingredients) }}</textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Features Icons</label>
                    <div class="flex flex-wrap gap-4">
                        @php $selectedFeatures = old('features', $product->features ?? []); @endphp
                        @foreach(['Cruelty-free', 'Gluten-free', 'Recyclable', 'Vegan'] as $feature)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="features[]" value="{{ $feature }}" class="rounded text-indigo-600 focus:ring-indigo-500" {{ in_array($feature, $selectedFeatures) ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $feature }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Bullet Points</label>
                    <div id="bullet-points-container" class="space-y-2">
                        @php $bullets = old('bullet_points', $product->bullet_points ?? ['']); @endphp
                        @foreach($bullets as $index => $bullet)
                            <input type="text" name="bullet_points[]" value="{{ $bullet }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. 100% Vegan and Organic">
                        @endforeach
                    </div>
                    <button type="button" onclick="addBulletPoint()" class="mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-800">+ Add Bullet Point</button>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">FAQs</label>
                    <div id="faqs-container" class="space-y-4">
                        @php $faqs = old('faqs', $product->faqs ?? [['question' => '', 'answer' => '']]); @endphp
                        @foreach($faqs as $index => $faq)
                            <div class="flex gap-2 faq-row">
                                <input type="text" name="faqs[{{$index}}][question]" value="{{ $faq['question'] ?? '' }}" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Question">
                                <input type="text" name="faqs[{{$index}}][answer]" value="{{ $faq['answer'] ?? '' }}" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Answer">
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addFaq()" class="mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-800">+ Add FAQ</button>
                </div>
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
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Image ("Created In Harmony with Nature")</label>
                        @if($product->banner_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->banner_image) }}" alt="Banner Image" class="w-full max-w-md h-32 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif
                        <input type="file" name="banner_image" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
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

    <!-- Product Testimonials Section -->
    <div class="mt-8 bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden p-8">
        <h3 class="text-xl font-extrabold text-slate-900 mb-6">Product Testimonials</h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @foreach($product->testimonials as $testimonial)
                <div class="relative group rounded-xl overflow-hidden border border-slate-200">
                    <img src="{{ asset('storage/' . $testimonial->image_path) }}" class="w-full h-32 object-cover">
                    <form action="{{ route('admin.products.testimonials.destroy', [$product->id, $testimonial->id]) }}" method="POST" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-white bg-rose-600 px-3 py-1.5 rounded-lg text-xs font-bold" onclick="return confirm('Delete testimonial?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.products.testimonials.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
            @csrf
            <h4 class="font-bold text-slate-800 mb-4 text-sm">Add New Testimonial Image</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Image File</label>
                    <input type="file" name="image" required accept="image/*" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Caption (e.g. Cleanse)</label>
                    <input type="text" name="caption" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm" placeholder="Caption">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Short Description</label>
                    <input type="text" name="short_description" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm" placeholder="Short text under caption">
                </div>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors">Upload Testimonial</button>
        </form>
    </div>

    <!-- Product Review Videos Section -->
    <div class="mt-8 bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden p-8">
        <h3 class="text-xl font-extrabold text-slate-900 mb-6">Product Review Videos</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @foreach($product->reviewVideos as $video)
                <div class="relative group rounded-xl border border-slate-200 overflow-hidden bg-slate-50 p-4 flex flex-col">
                    <video src="{{ asset('storage/' . $video->video_path) }}" class="w-full h-40 object-cover rounded-lg mb-4" controls></video>
                    <p class="text-xs font-semibold text-slate-700 truncate mb-4">{{ $video->caption ?? 'No caption' }}</p>
                    <div class="mt-auto flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold {{ $video->is_active ? 'text-emerald-600' : 'text-slate-400' }} block">{{ $video->is_active ? 'Active' : 'Inactive' }}</span>
                            @if($video->show_on_homepage)
                                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider block mt-1">Featured</span>
                            @endif
                        </div>
                        <form action="{{ route('admin.products.review_videos.destroy', [$product->id, $video->id]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold" onclick="return confirm('Delete review video?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.products.review_videos.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-bold text-slate-700 mb-2">Upload New Review Video</label>
                <input type="file" name="video" required accept="video/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-bold text-slate-700 mb-2">Video Caption</label>
                <input type="text" name="caption" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="Optional caption">
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" name="show_on_homepage" id="show_on_homepage" value="1" class="rounded text-indigo-600 focus:ring-indigo-500 w-4 h-4 mr-2">
                <label for="show_on_homepage" class="text-sm font-bold text-slate-700">Feature on Home Screen</label>
            </div>
            <button type="submit" class="px-6 py-3 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-colors">Upload</button>
        </form>
    </div>

    <!-- Product Reviews Section -->
    <div class="mt-8 bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden p-8">
        <h3 class="text-xl font-extrabold text-slate-900 mb-6">Product Reviews</h3>
        
        @if($product->reviews && $product->reviews->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($product->reviews as $review)
                    <div class="py-4 flex flex-col md:flex-row md:items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-slate-900">{{ $review->name }}</span>
                                <span class="text-xs text-amber-500 font-bold">★ {{ $review->rating }}/5</span>
                                @if($review->is_approved)
                                    <span class="bg-emerald-50 text-emerald-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide">Approved</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide">Pending</span>
                                @endif
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">{{ $review->title }}</h4>
                            <p class="text-sm text-slate-600 mt-1">{{ $review->text }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.products.reviews.approve', [$product->id, $review->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 {{ $review->is_approved ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }} rounded-lg text-xs font-bold transition-colors">
                                    {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.products.reviews.destroy', [$product->id, $review->id]) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-100 text-rose-700 hover:bg-rose-200 rounded-lg text-xs font-bold transition-colors" onclick="return confirm('Delete review?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-500 text-center py-6">No reviews yet for this product.</p>
        @endif
    </div>

</div>

<script>
function addBulletPoint() {
    const container = document.getElementById('bullet-points-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'bullet_points[]';
    input.className = 'w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none mt-2';
    input.placeholder = 'e.g. New feature point';
    container.appendChild(input);
}
function addFaq() {
    const container = document.getElementById('faqs-container');
    const index = container.querySelectorAll('.faq-row').length;
    const div = document.createElement('div');
    div.className = 'flex gap-2 faq-row mt-2';
    div.innerHTML = `
        <input type="text" name="faqs[${index}][question]" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Question">
        <input type="text" name="faqs[${index}][answer]" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Answer">
    `;
    container.appendChild(div);
}
</script>

@endsection