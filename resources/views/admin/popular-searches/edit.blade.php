@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Popular Search</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Update the details or thumbnail of an existing popular search term.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.popular-searches.index') }}" class="flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
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
        <form action="{{ route('admin.popular-searches.update', $popularSearch->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Search Text / Product Phrase <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $popularSearch->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                <p class="text-xs text-slate-400 mt-1">This text is shown in the search panel. Clicking it runs a search for this exact phrase.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Thumbnail Image (Optional)</label>
                    
                    @if($popularSearch->image)
                        <div class="mb-3 flex items-center gap-3 p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                            <img src="{{ asset('storage/' . $popularSearch->image) }}" class="w-16 h-16 rounded-full object-cover border border-slate-200">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 block">Current Image</span>
                                <span class="text-xs text-slate-400 block">Will be replaced if a new file is uploaded</span>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Sort Order <span class="text-rose-500">*</span></label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $popularSearch->sort_order) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" required>
                    <p class="text-xs text-slate-400 mt-1">Smaller numbers will be displayed first.</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="is_hot" value="1" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_hot', $popularSearch->is_hot) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-bold text-slate-700">Mark as Hot (Displays a fire 🔥 icon next to the text)</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                    Update Popular Search
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
