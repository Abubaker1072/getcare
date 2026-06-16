@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Product Management</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manage Bestselling Products to show on Home Page (Max 8).</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-5 py-2 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Products
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 border border-emerald-100 p-4 rounded-xl text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-rose-50 text-rose-600 border border-rose-100 p-4 rounded-xl text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Image</th>
                        <th class="p-5 font-bold">Name</th>
                        <th class="p-5 font-bold">Price</th>
                        <th class="p-5 font-bold">Stock</th>
                        <th class="p-5 font-bold text-center">Show on Home Page</th>
                        <th class="p-5 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5 w-20">
                            @if($product->cover_image || $product->image)
                                <img src="{{ asset('storage/' . ($product->cover_image ?? $product->image)) }}" class="w-12 h-12 bg-slate-100 rounded-xl object-cover">
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded-xl"></div>
                            @endif
                        </td>
                        <td class="p-5">
                            <p class="font-bold text-slate-900">{{ $product->name }}</p>
                        </td>
                        <td class="p-5 text-slate-900 font-bold">{!! \App\Helpers\CurrencyHelper::format($product->price) !!}</td>
                        <td class="p-5 text-slate-600 font-medium">{{ $product->stock }}</td>
                        <td class="p-5 text-center">
                            @if($product->homepageBestselling)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Yes</span>
                            @else
                                <span class="bg-slate-50 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">No</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <form action="{{ route('admin.product-management.toggle', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg transition-colors 
                                    {{ $product->homepageBestselling ? 'bg-rose-50 text-rose-600 hover:bg-rose-100' : 'bg-indigo-50 text-indigo-600 hover:bg-indigo-100' }}">
                                    {{ $product->homepageBestselling ? 'Remove from Home' : 'Add to Home' }}
                                </button>
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