@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-20 px-6 text-center">
    <div class="w-20 h-20 bg-rose-50 border border-rose-200 rounded-3xl flex items-center justify-center mx-auto mb-6 text-rose-500 shadow-sm animate-pulse">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Access Denied</h1>
    <p class="text-slate-500 font-medium mb-8">You do not have administrative permissions to access this page.</p>

    @if(config('app.env') === 'local')
        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 text-left shadow-sm">
            <h4 class="font-bold text-indigo-900 mb-1">Local Developer Console</h4>
            <p class="text-xs text-indigo-700 leading-relaxed mb-4">You are seeing this error in local development because your current user account is not an administrator. Use the buttons below to switch accounts or promote your current account.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('local.promote-me') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                        Promote Current Account
                    </button>
                </form>
                <form action="{{ route('local.login-admin') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 bg-white hover:bg-slate-50 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold transition shadow-sm">
                        Login as default Admin
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
