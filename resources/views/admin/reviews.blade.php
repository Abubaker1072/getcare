@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Testimonials & Reviews</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Moderate customer reviews and testimonials. Approved items are shown on the blog and contact pages.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/40 text-emerald-700 dark:text-emerald-400 rounded-2xl text-sm font-medium flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Reviews Grid/Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <div class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Reviews: <span class="text-slate-900 dark:text-white font-bold">{{ $reviews->total() }}</span></div>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
                        <th class="p-5 font-bold">Reviewer Info</th>
                        <th class="p-5 font-bold">Product</th>
                        <th class="p-5 font-bold">Rating</th>
                        <th class="p-5 font-bold">Review Title & Text</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-800/60">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md shadow-amber-500/10">
                                        {{ strtoupper(substr($rev->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-900 dark:text-white text-base">{{ $rev->name }}</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-0.5">{{ $rev->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-700 dark:text-slate-300 font-bold">{{ $rev->product_name ?? 'General Website' }}</p>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rev->rating ? 'fill-current' : 'text-slate-200 dark:text-slate-700 stroke-current' }}" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span class="ml-1.5 text-xs text-slate-500 dark:text-slate-400 font-bold">({{ $rev->rating }}/5)</span>
                                </div>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-900 dark:text-white font-bold text-base mb-1">{{ $rev->title }}</p>
                                <p class="text-slate-600 dark:text-slate-300 font-medium max-w-md leading-relaxed">{{ $rev->text }}</p>
                            </td>
                            <td class="p-5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $rev->is_approved ? 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-400' }}">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $rev->is_approved ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    {{ $rev->is_approved ? 'Approved' : 'Pending Approval' }}
                                </span>
                            </td>
                            <td class="p-5 text-right whitespace-nowrap space-x-1">
                                <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 {{ $rev->is_approved ? 'bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm' }} rounded-xl text-xs font-bold transition-all">
                                        {{ $rev->is_approved ? 'Reject/Hide' : 'Approve' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-950/60 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-bold transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
            <div class="p-4 border-t border-slate-50 dark:border-slate-800">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection
