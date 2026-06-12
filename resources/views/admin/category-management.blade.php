@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Category Management</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manage Featured Categories to show on Home Page (Max 8).</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-5 py-2 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Categories
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

    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400">
                        <th class="p-5 font-bold">Image</th>
                        <th class="p-5 font-bold">Name</th>
                        <th class="p-5 font-bold">Products</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold text-center">Show on Home Page</th>
                        <th class="p-5 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5 w-20">
                            <img src="{{ \App\Helpers\ImageHelper::getCategoryImage($category->image) }}"
                                 alt="{{ $category->name }}"
                                 class="w-12 h-12 bg-slate-100 rounded-xl object-cover">
                        </td>
                        <td class="p-5">
                            <p class="font-bold text-slate-900">{{ $category->name }}</p>
                            <p class="text-xs text-slate-500">/{{ $category->slug }}</p>
                        </td>
                        <td class="p-5 text-slate-600 font-medium">{{ $category->products_count ?? 0 }}</td>
                        <td class="p-5">
                            @if($category->status)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold">Active</span>
                            @else
                                <span class="bg-slate-50 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-lg text-xs font-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="p-5 text-center">
                            @if($category->homepageFeatured)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Yes</span>
                            @else
                                <span class="bg-slate-50 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">No</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <form action="{{ route('admin.category-management.toggle', $category->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg transition-colors
                                    {{ $category->homepageFeatured ? 'bg-rose-50 text-rose-600 hover:bg-rose-100' : 'bg-indigo-50 text-indigo-600 hover:bg-indigo-100' }}">
                                    {{ $category->homepageFeatured ? 'Remove from Home' : 'Add to Home' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-slate-500">No categories found. Add categories first.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-50">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
