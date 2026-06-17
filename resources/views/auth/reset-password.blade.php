@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="max-w-4xl w-full bg-white flex shadow-lg rounded-lg overflow-hidden">
        
        <!-- Image Panel -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
            <div class="h-full w-full bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center">
                <div class="text-white text-center p-6 border border-white/30 rounded-xl bg-white/10">
                    <h2 class="text-2xl font-semibold mb-2">New Password</h2>
                    <p class="text-sm opacity-80">Choose a secure password</p>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="mb-8">
                <svg class="w-10 h-10 text-blue-800 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <h2 class="text-3xl font-bold text-blue-900 uppercase">Reset Password</h2>
                <p class="text-gray-500 mt-1">Set a new password for <span class="font-semibold text-gray-700">{{ $email }}</span>.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded transition duration-200 uppercase tracking-wider text-sm">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-sm text-gray-600">
                Cancel and return to <a href="{{ route('login') }}" class="text-blue-800 font-bold hover:underline">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
