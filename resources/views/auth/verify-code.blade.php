@extends('layouts.auth')

@section('title', 'Verify Code')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="max-w-4xl w-full bg-white flex shadow-lg rounded-lg overflow-hidden">
        
        <!-- Image Panel -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
            <div class="h-full w-full bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center">
                <div class="text-white text-center p-6 border border-white/30 rounded-xl bg-white/10">
                    <h2 class="text-2xl font-semibold mb-2">Verify Account</h2>
                    <p class="text-sm opacity-80">Enter authorization code</p>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <div class="mb-8">
                <svg class="w-10 h-10 text-blue-800 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h2 class="text-3xl font-bold text-blue-900 uppercase">Verification</h2>
                <p class="text-gray-500 mt-1">We have sent a verification code to <span class="font-semibold text-gray-700">{{ $email }}</span>.</p>
            </div>

            <form action="{{ route('password.verify.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline text-sm">{{ session('success') }}</span>
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">6-Digit Verification Code</label>
                    <input type="text" name="code" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-center text-2xl font-bold tracking-widest" placeholder="••••••" maxlength="6" pattern="\d{6}" inputmode="numeric" required autocomplete="one-time-code">
                </div>

                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded transition duration-200 uppercase tracking-wider text-sm">
                    Verify Code
                </button>
            </form>

            <div class="mt-6 text-sm text-gray-600 flex justify-between">
                <span>Didn't receive code? <a href="{{ route('password.request') }}" class="text-blue-800 font-bold hover:underline">Resend</a></span>
                <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Back to Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
