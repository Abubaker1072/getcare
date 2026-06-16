@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
                Hot Deals
                <span class="ml-3 bg-rose-100 text-rose-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                </span>
            </h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">All products — assign hot deals for homepage & hot deals page.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.hot-deal-management') }}" class="flex items-center px-5 py-2 bg-gradient-to-r from-rose-500 to-orange-500 text-white rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-rose-500/25 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Manage Hot Products
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 border border-emerald-100 p-4 rounded-xl text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Product Name</th>
                        <th class="p-5 font-bold">Category</th>
                        <th class="p-5 font-bold">Price</th>
                        <th class="p-5 font-bold">Stock</th>
                        <th class="p-5 font-bold">Hot Deal</th>
                        <th class="p-5 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-5 flex items-center">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" class="w-10 h-10 rounded-xl mr-4 object-cover">
                            @else
                                <div class="w-10 h-10 bg-slate-100 rounded-xl mr-4"></div>
                            @endif
                            <div>
                                <p class="font-bold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->slug }}</p>
                            </div>
                        </td>
                        <td class="p-5 text-slate-600">{{ $product->category->name ?? '—' }}</td>
                        <td class="p-5 font-bold text-slate-900">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</td>
                        <td class="p-5 text-slate-600">{{ $product->stock }}</td>
                        <td class="p-5">
                            @if($product->homepageHotDeal)
                                <span class="bg-rose-50 text-rose-600 border border-rose-100 px-2.5 py-1 rounded-lg text-xs font-bold">Yes</span>
                            @else
                                <span class="bg-slate-50 text-slate-500 border border-slate-200 px-2.5 py-1 rounded-lg text-xs font-bold">No</span>
                            @endif
                        </td>
                        <td class="p-5">
                            @if($product->is_active)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold">Active</span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-100 px-2.5 py-1 rounded-lg text-xs font-bold">Inactive</span>
                            @endif
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
