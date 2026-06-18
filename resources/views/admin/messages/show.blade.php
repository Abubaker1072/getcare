@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.messages.index') }}" class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                &larr; Back
            </a>
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Ticket Details ✨</h1>
        </div>
        <div>
            @if($message->reply)
                <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-medium leading-none text-emerald-700 bg-emerald-100 rounded-full border border-emerald-200">
                    Replied
                </span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 border border-emerald-200 bg-emerald-50 text-emerald-600 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Left Col: Ticket Info -->
        <div class="xl:col-span-2 space-y-6">
            
            <!-- Customer Details Card -->
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Customer Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-slate-500">Name</div>
                        <div class="font-medium text-slate-800">{{ $message->first_name }} {{ $message->last_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Email</div>
                        <div class="font-medium text-slate-800"><a href="mailto:{{ $message->email }}" class="text-indigo-500 hover:text-indigo-600">{{ $message->email }}</a></div>
                    </div>
                    @if($message->phone_number)
                    <div>
                        <div class="text-sm text-slate-500">Phone</div>
                        <div class="font-medium text-slate-800">{{ $message->phone_number }}</div>
                    </div>
                    @endif
                    @if($message->address)
                    <div class="col-span-2">
                        <div class="text-sm text-slate-500">Address</div>
                        <div class="font-medium text-slate-800">{{ $message->address }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Inquiry Details Card -->
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Inquiry Information</h2>
                <div class="mb-4">
                    <div class="text-sm text-slate-500">Type</div>
                    <div class="font-medium text-slate-800 capitalize">{{ str_replace('_', ' ', $message->inquiry_type) }}</div>
                </div>
                
                @if($message->order_number)
                <div class="mb-4">
                    <div class="text-sm text-slate-500">Order Number / ID</div>
                    <div class="font-medium text-slate-800">{{ $message->order_number }}</div>
                </div>
                @endif
                
                @if($message->reason)
                <div class="mb-4">
                    <div class="text-sm text-slate-500">Reason</div>
                    <div class="font-medium text-slate-800">{{ $message->reason }}</div>
                </div>
                @endif
                
                @if($message->message)
                <div class="mb-4">
                    <div class="text-sm text-slate-500">Message</div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded mt-1 text-slate-700">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
                @endif
                
                @if($message->image_path)
                <div>
                    <div class="text-sm text-slate-500 mb-2">Attached Image</div>
                    <a href="{{ asset('storage/' . $message->image_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $message->image_path) }}" class="max-w-xs rounded border border-slate-200 shadow-sm hover:opacity-80 transition">
                    </a>
                </div>
                @endif
            </div>
            
        </div>
        
        <!-- Right Col: Reply Form -->
        <div class="xl:col-span-1">
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5 sticky top-24">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Admin Reply</h2>
                
                <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1" for="reply">Response Message</label>
                        <textarea id="reply" name="reply" class="form-textarea w-full border-slate-200 hover:border-slate-300 focus:border-indigo-300 rounded-md shadow-sm" rows="8" required>{{ old('reply', $message->reply) }}</textarea>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full">
                            {{ $message->reply ? 'Update Reply' : 'Send Reply' }}
                        </button>
                    </div>
                </form>
                
                @if($message->replied_at)
                    <div class="mt-4 text-xs text-slate-500 text-center">
                        Replied at: {{ $message->replied_at->format('M d, Y h:i A') }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
