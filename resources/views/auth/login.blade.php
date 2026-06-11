    @extends('layouts.auth')

    @section('title', 'Login')

    @section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
        <div class="max-w-4xl w-full bg-white flex shadow-lg rounded-lg overflow-hidden">
            
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
                <div class="h-full w-full bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center">
                    <div class="text-white text-center p-6 border border-white/30 rounded-xl bg-white/10">
                        <h2 class="text-2xl font-semibold mb-2">Secure Login</h2>
                        <p class="text-sm opacity-80">Access your dashboard</p>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="mb-8">
                    <svg class="w-10 h-10 text-blue-800 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16z"/></svg>
                    <h2 class="text-3xl font-bold text-blue-900 uppercase">Welcome Back !</h2>
                    <p class="text-gray-500 mt-1">Login to your account.</p>
                </div>

                <form action="#" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="digitalupk@gmail.com" required>
                    </div>

                    <div class="mb-5 relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••••••" required>
                        <button type="button" class="absolute right-4 top-10 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="mr-2 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                            Remember Me
                        </label>
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-700 underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded transition duration-200">
                        Login
                    </button>
                </form>

                <div class="mt-6 text-sm text-gray-600">
                    Dont have an account? <a href="{{ route('register') }}" class="text-blue-800 font-bold hover:underline">Register Now</a>
                </div>

                <div class="mt-10 text-right">
                    <a href="{{ route('products.index') }}" class="text-sm text-blue-800 font-semibold flex items-center justify-end hover:underline">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Previous Page
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endsection