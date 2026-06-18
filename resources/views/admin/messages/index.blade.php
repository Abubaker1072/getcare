@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Customer Box / Tickets ✨</h1>
        </div>
        
        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <form method="GET" action="{{ route('admin.messages.index') }}" class="flex gap-2">
                <select name="type" class="border-slate-200 hover:border-slate-300 text-slate-500 bg-white px-3 py-2 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                    <option value="complain" {{ request('type') == 'complain' ? 'selected' : '' }}>Complain</option>
                    <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Refund</option>
                </select>
                <select name="status" class="border-slate-200 hover:border-slate-300 text-slate-500 bg-white px-3 py-2 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Status</div></th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Customer</div></th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Type</div></th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Date</div></th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">Action</div></th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-200">
                    @forelse($messages as $msg)
                    <tr>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            @if(!$msg->is_read)
                                <div class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Unread</div>
                            @elseif($msg->reply)
                                <div class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">Replied</div>
                            @else
                                <div class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5">Read</div>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">{{ $msg->first_name }} {{ $msg->last_name }}</div>
                            <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <span class="capitalize">{{ str_replace('_', ' ', $msg->inquiry_type) }}</span>
                            @if($msg->order_number)
                                <div class="text-xs text-slate-400">Order: {{ $msg->order_number }}</div>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div>{{ $msg->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $msg->created_at->format('g:i A') }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">View & Reply</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-slate-500">
                            No tickets found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $messages->appends(request()->query())->links() }}
    </div>

</div>
@endsection
