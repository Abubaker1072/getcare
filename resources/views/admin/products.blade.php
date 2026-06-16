@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Products List</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manage your store's inventory and pricing.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.product-management') }}" class="flex items-center px-5 py-2 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Product Management
            </a>
            <a href="{{ route('admin.products.create') }}" class="flex items-center px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Product
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 border border-emerald-100 p-4 rounded-xl text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Product Name</th>
                        <th class="p-5 font-bold">Category</th>
                        <th class="p-5 font-bold">Stock</th>
                        <th class="p-5 font-bold">Price</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5 flex items-center">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" class="w-10 h-10 bg-slate-100 rounded-xl mr-4 flex-shrink-0 object-cover">
                            @else
                                <div class="w-10 h-10 bg-slate-100 rounded-xl mr-4 flex-shrink-0"></div>
                            @endif
                            <div>
                                <p class="font-bold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">Slug: {{ $product->slug }}</p>
                            </div>
                        </td>
                        <td class="p-5">
                            <form action="{{ route('admin.products.update-category', $product->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="category_id" onchange="this.form.submit()"
                                    class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none min-w-[140px]">
                                    <option value="">No Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="p-5 text-slate-600 font-medium">{{ $product->stock }}</td>
                        <td class="p-5 text-slate-900 font-bold">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</td>
                        <td class="p-5">
                            @if($product->is_active)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Active</span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Inactive</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-slate-400 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-slate-400 hover:text-rose-600 transition-colors"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-slate-500">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-50">
            {{ $products->links() }}
        </div>
    </div>
@endsection
