@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add New Product</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Create a new product in your store.</p>
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
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', 0) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Compare Price</label>
                    <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Discount Price</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                    <select name="category_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6 border border-slate-200 rounded-xl p-6 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Product Details (Dynamic Frontend)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tags (Comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. Green tea, Argan Oil">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Promo Text</label>
                        <input type="text" name="promo_text" value="{{ old('promo_text') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. 🎟️ Use code Beauty for 10% OFF!">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">How to Use (Simple Text)</label>
                        <textarea name="how_to_use" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">{{ old('how_to_use') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ingredients (Simple Text)</label>
                        <textarea name="ingredients" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">{{ old('ingredients') }}</textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Features Icons</label>
                    <div class="flex flex-wrap gap-4">
                        @php $selectedFeatures = old('features', []); @endphp
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
                        @php $bullets = old('bullet_points', ['']); @endphp
                        @foreach($bullets as $index => $bullet)
                            <input type="text" name="bullet_points[]" value="{{ $bullet }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="e.g. 100% Vegan and Organic">
                        @endforeach
                    </div>
                    <button type="button" onclick="addBulletPoint()" class="mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-800">+ Add Bullet Point</button>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">FAQs</label>
                    <div id="faqs-container" class="space-y-4">
                        @php 
                            $defaultFaqs = [
                                ['question' => 'How to use?', 'answer' => 'Apply a small amount to your hands and gently massage into the desired area.'],
                                ['question' => 'How to place an order?', 'answer' => 'Simply add the item to your cart and proceed to checkout. We accept all major credit cards.'],
                                ['question' => 'How we deal with customers?', 'answer' => 'We prioritize customer satisfaction. If you are not happy, contact our 24/7 support team.'],
                            ];
                            $faqs = old('faqs', $defaultFaqs); 
                        @endphp
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
                        <input type="file" name="image" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 2 (Optional)</label>
                        <input type="file" name="image_1" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 3 (Optional)</label>
                        <input type="file" name="image_2" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image 4 (Optional)</label>
                        <input type="file" name="image_3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Image ("Created In Harmony with Nature")</label>
                        <input type="file" name="banner_image" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-bold text-slate-700 mb-3">Select Cover Photo</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image" class="text-indigo-600 focus:ring-indigo-500" checked>
                            <span class="text-sm font-medium">Image 1</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_1" class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium">Image 2</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_2" class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium">Image 3</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="cover_image_selection" value="image_3" class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium">Image 4</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                    <span class="ml-2 text-sm font-bold text-slate-700">Active (Visible to customers)</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Save Product
                </button>
            </div>
        </form>
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