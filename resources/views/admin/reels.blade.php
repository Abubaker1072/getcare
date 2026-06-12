@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Reels List</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Manage video reels displayed on your home page.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.reels.create') }}" class="flex items-center px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Reel
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
                        <th class="p-5 font-bold">Video</th>
                        <th class="p-5 font-bold">Caption</th>
                        <th class="p-5 font-bold">Associated Product</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($reels as $reel)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <div class="relative w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                <video src="{{ asset('storage/' . $reel->video_path) }}" 
                                       @if($reel->thumbnail_path) poster="{{ asset('storage/' . $reel->thumbnail_path) }}" @endif 
                                       class="w-full h-full object-cover" 
                                       muted 
                                       preload="metadata">
                                </video>
                                <div class="absolute inset-0 bg-black/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 font-medium text-slate-700">
                            {{ $reel->caption ?: '-' }}
                        </td>
                        <td class="p-5">
                            @if($reel->product)
                                <div class="flex items-center">
                                    @if($reel->product->cover_image || $reel->product->image)
                                        <img src="{{ asset('storage/' . ($reel->product->cover_image ?? $reel->product->image)) }}" class="w-8 h-8 bg-slate-100 rounded-lg mr-3 object-cover flex-shrink-0">
                                    @else
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg mr-3 flex-shrink-0"></div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900 leading-tight">{{ $reel->product->name }}</p>
                                        <p class="text-xs text-slate-500">${{ number_format($reel->product->price, 2) }}</p>
                                    </div>
                                </div>
                            @else
                                <span class="text-slate-400 text-xs italic">None</span>
                            @endif
                        </td>
                        <td class="p-5">
                            @if($reel->is_active)
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Active</span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-100 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide">Inactive</span>
                            @endif
                        </td>
                        <td class="p-5 text-right whitespace-nowrap">
                            <a href="{{ route('admin.reels.edit', $reel->id) }}" class="text-slate-400 hover:text-indigo-600 transition-colors inline-block mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('admin.reels.destroy', $reel->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Reel?')" class="text-slate-400 hover:text-rose-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 italic">No Reels added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reels->hasPages())
        <div class="p-4 border-t border-slate-50">
            {{ $reels->links() }}
        </div>
        @endif
    </div>
@endsection
