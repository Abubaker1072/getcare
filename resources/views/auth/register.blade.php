@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="max-w-4xl w-full bg-white flex shadow-lg rounded-lg overflow-hidden">
        
        <div class="hidden md:block md:w-5/12 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522199755839-a2bacb67c546?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');">
        </div>

        <div class="w-full md:w-7/12 p-8 md:p-12 overflow-y-auto" style="max-height: 90vh;">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-blue-900">Create Account</h2>
                <p class="text-gray-600 mt-1">Join us and start shopping today.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
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
                
            {{--    <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Register as <span class="text-red-500">*</span></label>
                    <div class="flex space-x-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role" value="customer" class="peer sr-only" checked onchange="toggleVendorDetails(false)">
                            <div class="text-center py-3 border rounded border-gray-200 text-gray-600 peer-checked:border-blue-800 peer-checked:text-blue-800 peer-checked:bg-blue-50 transition flex justify-center items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-gray-300 peer-checked:bg-orange-400 inline-block"></span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role" value="vendor" class="peer sr-only" onchange="toggleVendorDetails(true)">
                            <div class="text-center py-3 border rounded border-gray-200 text-gray-600 peer-checked:border-blue-800 peer-checked:text-blue-800 peer-checked:bg-blue-50 transition flex justify-center items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-gray-300 peer-checked:bg-orange-400 inline-block"></span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Vendor
                            </div>
                        </label>
                    </div>
                </div>  --}}

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div id="vendor-details" class="hidden mb-6 p-4 border border-blue-200 border-dashed rounded bg-blue-50/50">
                    <h3 class="text-sm font-bold text-blue-900 mb-4 uppercase">Vendor / Brand Details</h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brand Name <span class="text-red-500">*</span></label>
                        <input type="text" name="brand_name" class="w-full px-4 py-3 bg-white border border-blue-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded transition duration-200">
                    Register
                </button>
            </form>
            
            <div class="mt-6 text-sm text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-800 font-bold hover:underline">Login Here</a>
            </div>
        </div>
    </div>
</div>
@endsection

@stack('scripts')
<script>
    function toggleVendorDetails(isVendor) {
        const vendorDetails = document.getElementById('vendor-details');
        const brandInput = document.querySelector('input[name="brand_name"]');
        
        if (isVendor) {
            vendorDetails.classList.remove('hidden');
            brandInput.setAttribute('required', 'required');
        } else {
            vendorDetails.classList.add('hidden');
            brandInput.removeAttribute('required');
        }
    }
</script>