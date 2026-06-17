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

    <!-- Raw Data Auto-Fill Assistant -->
    <div class="mb-8 bg-gradient-to-br from-indigo-50/70 via-purple-50/30 to-indigo-50/20 border border-indigo-100/80 rounded-3xl p-6 shadow-sm transition-all duration-200">
        <div class="flex items-center justify-between cursor-pointer" onclick="toggleAutoFillAssistant()">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-indigo-600/10 text-indigo-600 flex items-center justify-center text-lg shadow-sm">✨</span>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Raw Data Auto-Fill Assistant</h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Paste product info/JSON to fill out this form automatically.</p>
                </div>
            </div>
            <button type="button" id="assistant-toggle-btn" class="text-slate-400 hover:text-slate-650 transition-colors">
                <svg id="assistant-arrow-icon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
        </div>
        
        <div id="autofill-assistant-body" class="mt-6 space-y-4">
            <!-- Alert message for successful fill -->
            <div id="autofill-success-alert" class="hidden bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-sm font-semibold flex items-start gap-3 shadow-sm">
                <!-- Message inserted dynamically -->
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Paste raw details or JSON below</label>
                    <textarea id="raw-data-input" rows="6" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all font-mono shadow-inner" placeholder="Product Name: Clinical Jade Roller&#10;Price: 24.99&#10;Stock: 150&#10;Category: Skincare&#10;Description: Experience the soothing power of Jade Roller.&#10;Tags: roller, beauty&#10;Features: Cruelty-free, Vegan&#10;Bullet Points:&#10;- Dual-sided design&#10;- Helps depuff face&#10;FAQs:&#10;Q: How often to use?&#10;A: Daily for 5-10 minutes."></textarea>
                </div>
                
                <div class="bg-white/50 rounded-2xl p-5 border border-slate-100 flex flex-col justify-between">
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-indigo-750 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            How it works
                        </h4>
                        <ul class="text-xs text-slate-500 space-y-2 list-disc list-inside leading-relaxed font-medium">
                            <li>Supports Key-Value formats (e.g. <code class="bg-slate-100 px-1 py-0.5 rounded">Key: Value</code>).</li>
                            <li>Supports raw supplier descriptions & lists.</li>
                            <li>Supports structured <code class="bg-slate-100 px-1 py-0.5 rounded">JSON</code> objects.</li>
                            <li>Lists, checkboxes, and FAQs are filled dynamically!</li>
                        </ul>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="triggerAutoFill()" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg hover:shadow-indigo-550/20 active:translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            <span>✨ Parse &amp; Auto-Fill Form</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

function toggleAutoFillAssistant() {
    const body = document.getElementById('autofill-assistant-body');
    const arrow = document.getElementById('assistant-arrow-icon');
    if (body.classList.contains('hidden')) {
        body.classList.remove('hidden');
        arrow.classList.remove('-rotate-90');
    } else {
        body.classList.add('hidden');
        arrow.classList.add('-rotate-90');
    }
}

function triggerAutoFill() {
    const text = document.getElementById('raw-data-input').value;
    if (!text.trim()) {
        alert('Please paste some text first.');
        return;
    }
    
    let data = {};
    
    // Try JSON parsing
    try {
        const parsed = JSON.parse(text);
        if (parsed && typeof parsed === 'object') {
            data = parsed;
        }
    } catch (e) {
        // Not JSON, fall back to line/regex parsing
        data = parseRawTextHeuristics(text);
    }
    
    fillFormFields(data);
}

function parseRawTextHeuristics(text) {
    const lines = text.split('\n');
    const data = {
        bullet_points: [],
        features: [],
        faqs: []
    };
    
    let currentSection = '';
    
    for (let i = 0; i < lines.length; i++) {
        let line = lines[i].trim();
        if (!line) continue;
        
        const lowerLine = line.toLowerCase();
        
        // 1. Check for section transitions
        if (lowerLine.startsWith('bullet points:') || lowerLine.startsWith('bulletpoints:') || lowerLine.startsWith('bullets:')) {
            currentSection = 'bullet_points';
            continue;
        } else if (lowerLine.startsWith('faqs:') || lowerLine.startsWith('faq:') || lowerLine.startsWith('questions:')) {
            currentSection = 'faqs';
            continue;
        } else if (lowerLine.startsWith('features:') || lowerLine.startsWith('icons:')) {
            currentSection = 'features';
            continue;
        }
        
        // 2. Direct field regex tests (more flexible than strict key-value)
        let matchedField = false;
        
        // Product Name
        let m = line.match(/(?:product\s*)?name\s*[:=]\s*(.+)/i) || line.match(/title\s*[:=]\s*(.+)/i);
        if (m) { data.name = m[1].trim(); matchedField = true; }
        
        // Slug
        m = line.match(/slug\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.slug = m[1].trim(); matchedField = true; }
        
        // Price
        m = line.match(/price\s*[:=]\s*(.+)/i) || line.match(/mrp\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.price = parseFloat(m[1].replace(/[^0-9.]/g, '')); matchedField = true; }
        
        // Compare Price
        m = line.match(/compare\s*(?:at\s*)?price\s*[:=]\s*(.+)/i) || line.match(/retail\s*price\s*[:=]\s*(.+)/i) || line.match(/original\s*price\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.compare_price = parseFloat(m[1].replace(/[^0-9.]/g, '')); matchedField = true; }
        
        // Discount Price
        m = line.match(/discount\s*price\s*[:=]\s*(.+)/i) || line.match(/sale\s*price\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.discount_price = parseFloat(m[1].replace(/[^0-9.]/g, '')); matchedField = true; }
        
        // Stock
        m = line.match(/stock\s*[:=]\s*(.+)/i) || line.match(/qty\s*[:=]\s*(.+)/i) || line.match(/quantity\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.stock = parseInt(m[1].replace(/[^0-9]/g, '')); matchedField = true; }
        
        // Category
        m = line.match(/category\s*[:=]\s*(.+)/i) || line.match(/type\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.category = m[1].trim(); matchedField = true; }
        
        // Tags
        m = line.match(/tags\s*[:=]\s*(.+)/i) || line.match(/keywords\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.tags = m[1].trim(); matchedField = true; }
        
        // Promo Text
        m = line.match(/promo\s*(?:text)?\s*[:=]\s*(.+)/i) || line.match(/coupon\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.promo_text = m[1].trim(); matchedField = true; }
        
        // How to Use
        m = line.match(/how\s*to\s*use\s*[:=]\s*(.+)/i) || line.match(/usage\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.how_to_use = m[1].trim(); matchedField = true; }
        
        // Ingredients
        m = line.match(/ingredients\s*[:=]\s*(.+)/i) || line.match(/composition\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.ingredients = m[1].trim(); matchedField = true; }
        
        // Features Inline
        m = line.match(/features\s*[:=]\s*(.+)/i) || line.match(/icons\s*[:=]\s*(.+)/i);
        if (m && !matchedField) {
            const list = m[1].split(/[,;|]/);
            list.forEach(item => {
                const cleanItem = item.trim().toLowerCase();
                ['cruelty-free', 'gluten-free', 'recyclable', 'vegan'].forEach(f => {
                    if (cleanItem.includes(f.toLowerCase())) {
                        data.features.push(f);
                    }
                });
            });
            matchedField = true;
        }
        
        // Description
        m = line.match(/description\s*[:=]\s*(.+)/i) || line.match(/desc\s*[:=]\s*(.+)/i) || line.match(/about\s*[:=]\s*(.+)/i);
        if (m && !matchedField) { data.description = m[1].trim(); matchedField = true; }
        
        if (matchedField) {
            continue;
        }
        
        // 3. Fallbacks to collection sections
        if (currentSection === 'bullet_points' || line.match(/^[-*•]\s+/)) {
            const cleanBullet = line.replace(/^[-*•]\s+/, '').trim();
            if (cleanBullet) {
                data.bullet_points.push(cleanBullet);
            }
            continue;
        }
        
        if (currentSection === 'features') {
            const cleanFeature = line.replace(/^[-*•]\s+/, '').trim().toLowerCase();
            ['cruelty-free', 'gluten-free', 'recyclable', 'vegan'].forEach(f => {
                if (cleanFeature.includes(f.toLowerCase())) {
                    data.features.push(f);
                }
            });
            continue;
        }
        
        if (currentSection === 'faqs' || line.match(/^[qQ]:/) || line.endsWith('?')) {
            let question = '';
            let answer = '';
            
            if (line.match(/^[qQ]:/)) {
                question = line.replace(/^[qQ]:\s*/i, '').trim();
                if (i + 1 < lines.length && lines[i + 1].trim().match(/^[aA]:/i)) {
                    answer = lines[i + 1].trim().replace(/^[aA]:\s*/i, '').trim();
                    i++;
                }
            } else if (line.endsWith('?')) {
                question = line;
                if (i + 1 < lines.length && !lines[i + 1].trim().endsWith('?') && !lines[i + 1].trim().match(/^[qQ]:/i)) {
                    answer = lines[i + 1].trim();
                    i++;
                }
            }
            
            if (question && answer) {
                data.faqs.push({ question, answer });
            }
            continue;
        }
    }
    
    return data;
}

function fillFormFields(data) {
    const filledFields = [];
    
    if (data.name) {
        document.querySelector('input[name="name"]').value = data.name;
        filledFields.push('Product Name');
    }
    if (data.slug) {
        document.querySelector('input[name="slug"]').value = data.slug;
        filledFields.push('Slug');
    }
    if (data.price !== undefined && !isNaN(data.price)) {
        document.querySelector('input[name="price"]').value = data.price;
        filledFields.push('Price');
    }
    if (data.compare_price !== undefined && !isNaN(data.compare_price)) {
        document.querySelector('input[name="compare_price"]').value = data.compare_price;
        filledFields.push('Compare Price');
    }
    if (data.discount_price !== undefined && !isNaN(data.discount_price)) {
        document.querySelector('input[name="discount_price"]').value = data.discount_price;
        filledFields.push('Discount Price');
    }
    if (data.stock !== undefined && !isNaN(data.stock)) {
        document.querySelector('input[name="stock"]').value = data.stock;
        filledFields.push('Stock');
    }
    if (data.description) {
        document.querySelector('textarea[name="description"]').value = data.description;
        filledFields.push('Description');
    }
    if (data.tags) {
        document.querySelector('input[name="tags"]').value = data.tags;
        filledFields.push('Tags');
    }
    if (data.promo_text) {
        document.querySelector('input[name="promo_text"]').value = data.promo_text;
        filledFields.push('Promo Text');
    }
    if (data.how_to_use) {
        document.querySelector('textarea[name="how_to_use"]').value = data.how_to_use;
        filledFields.push('How to Use');
    }
    if (data.ingredients) {
        document.querySelector('textarea[name="ingredients"]').value = data.ingredients;
        filledFields.push('Ingredients');
    }
    
    if (data.category) {
        const categorySelect = document.querySelector('select[name="category_id"]');
        if (categorySelect) {
            let matched = false;
            const catNameLower = data.category.toLowerCase().trim();
            for (let i = 0; i < categorySelect.options.length; i++) {
                const optText = categorySelect.options[i].text.toLowerCase().trim();
                if (optText.includes(catNameLower) || catNameLower.includes(optText)) {
                    categorySelect.selectedIndex = i;
                    matched = true;
                    filledFields.push('Category (' + categorySelect.options[i].text + ')');
                    break;
                }
            }
        }
    }
    
    if (data.features && data.features.length > 0) {
        const checkboxes = document.querySelectorAll('input[name="features[]"]');
        checkboxes.forEach(cb => {
            const val = cb.value.toLowerCase();
            const isMatched = data.features.some(f => f.toLowerCase() === val);
            cb.checked = isMatched;
        });
        filledFields.push('Features Icons');
    }
    
    if (data.bullet_points && data.bullet_points.length > 0) {
        const container = document.getElementById('bullet-points-container');
        container.innerHTML = '';
        data.bullet_points.forEach((bullet, index) => {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'bullet_points[]';
            input.value = bullet;
            input.className = 'w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none' + (index > 0 ? ' mt-2' : '');
            input.placeholder = 'e.g. 100% Vegan and Organic';
            container.appendChild(input);
        });
        filledFields.push('Bullet Points (' + data.bullet_points.length + ')');
    }
    
    if (data.faqs && data.faqs.length > 0) {
        const container = document.getElementById('faqs-container');
        container.innerHTML = '';
        data.faqs.forEach((faq, index) => {
            const div = document.createElement('div');
            div.className = 'flex gap-2 faq-row' + (index > 0 ? ' mt-2' : '');
            div.innerHTML = `
                <input type="text" name="faqs[${index}][question]" value="${faq.question.replace(/"/g, '&quot;')}" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Question">
                <input type="text" name="faqs[${index}][answer]" value="${faq.answer.replace(/"/g, '&quot;')}" class="w-1/2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none" placeholder="Answer">
            `;
            container.appendChild(div);
        });
        filledFields.push('FAQs (' + data.faqs.length + ')');
    }
    
    const alertDiv = document.getElementById('autofill-success-alert');
    if (alertDiv) {
        alertDiv.classList.remove('hidden');
        alertDiv.innerHTML = `
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-extrabold text-emerald-800">Fields Auto-filled successfully!</span>
                <p class="text-xs text-emerald-600 mt-0.5">Updated: ${filledFields.join(', ')}</p>
            </div>
        `;
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>

@endsection