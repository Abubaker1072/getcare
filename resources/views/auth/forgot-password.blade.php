@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="max-w-4xl w-full bg-white flex shadow-lg rounded-lg overflow-hidden">
        
        <!-- Image Panel -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
            <div class="h-full w-full bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center">
                <div class="text-white text-center p-6 border border-white/30 rounded-xl bg-white/10">
                    <h2 class="text-2xl font-semibold mb-2">Password Recovery</h2>
                    <p class="text-sm opacity-80">Request a verification code</p>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="mb-8">
                <svg class="w-10 h-10 text-blue-800 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"></path></svg>
                <h2 class="text-3xl font-bold text-blue-900 uppercase">Forgot Password</h2>
                <p class="text-gray-500 mt-1">Enter your registered email address to receive a 6-digit verification code.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline text-sm">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="yourname@example.com" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded transition duration-200 uppercase tracking-wider text-sm">
                    Send Code
                </button>
            </form>

            <div class="mt-6 text-sm text-gray-600">
                Remember your password? <a href="{{ route('login') }}" class="text-blue-800 font-bold hover:underline">Log in</a>
            </div>

            <div class="mt-10 text-right">
                <a href="{{ route('home') }}" class="text-sm text-blue-800 font-semibold flex items-center justify-end hover:underline">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
