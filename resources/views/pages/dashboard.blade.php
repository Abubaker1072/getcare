@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen pt-32 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Registration Success Celebration --}}
        @if(session('registered_success'))
            <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Confetti Cannon Animation
                    var duration = 3.5 * 1000;
                    var animationEnd = Date.now() + duration;
                    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 10000, colors: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6'] };

                    function randomInRange(min, max) {
                      return Math.random() * (max - min) + min;
                    }

                    var interval = setInterval(function() {
                      var timeLeft = animationEnd - Date.now();
                      if (timeLeft <= 0) {
                        return clearInterval(interval);
                      }
                      var particleCount = 50 * (timeLeft / duration);
                      // Fire from left side
                      confetti(Object.assign({}, defaults, { particleCount,
                        origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
                      }));
                      // Fire from right side
                      confetti(Object.assign({}, defaults, { particleCount,
                        origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
                      }));
                    }, 250);
                });
            </script>
            
            <div class="mb-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-2xl text-base font-bold shadow-lg shadow-amber-500/10 flex items-center gap-3 animate-[bounce_1s_ease-in-out_2]">
                <div class="bg-amber-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg">Welcome to GetCare!</h3>
                    <p class="text-sm font-medium text-amber-700/80">Your account has been successfully created. We're thrilled to have you here!</p>
                </div>
            </div>
        @endif

        {{-- Success message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Profile Sidebar --}}
            <div class="w-full lg:w-80 flex-shrink-0">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
                    <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4 font-serif">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-3 bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100 uppercase tracking-wide">
                        Verified Customer
                    </span>

                    <hr class="my-6 border-gray-100">

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-4 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition shadow-md shadow-gray-100 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </button>
                    </form>
                </div>

                {{-- Saved Payment Gateway details --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 font-serif text-left flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Saved Gateway Details
                    </h3>
                    <p class="text-xs text-gray-500 mb-4 text-left">Configure your default payment gateway credentials for faster checkout processing.</p>

                    <form action="{{ route('dashboard.bank-details.update') }}" method="POST" class="space-y-4 text-left">
                        @csrf
                        <div>
                            <label for="bank_name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" placeholder="e.g. Meezan Bank" value="{{ old('bank_name', $bankDetail->bank_name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('bank_name')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_number" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Account or IBAN Number</label>
                            <input type="text" name="account_number" id="account_number" placeholder="e.g. PK00MEZN00000123456789" value="{{ old('account_number', $bankDetail->account_number ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('account_number')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_holder_name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Account Title / Holder Name</label>
                            <input type="text" name="account_holder_name" id="account_holder_name" placeholder="e.g. John Doe" value="{{ old('account_holder_name', $bankDetail->account_holder_name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                            @error('account_holder_name')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="expiry_date" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Expiry (MM/YY)</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="12/29" value="{{ old('expiry_date', $bankDetail->expiry_date ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                @error('expiry_date')
                                    <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cvc" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Card CVC</label>
                                <input type="text" name="cvc" id="cvc" placeholder="123" value="{{ old('cvc', $bankDetail->cvc ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors">
                                @error('cvc')
                                    <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2 px-4 bg-amber-500 text-white rounded-xl text-xs font-bold hover:bg-amber-600 transition shadow-md shadow-amber-100 flex items-center justify-center gap-1.5 uppercase tracking-wider">
                            Update Details
                        </button>
                    </form>
                </div>
            </div>

            {{-- Main Dashboard Content --}}
            <div class="flex-1">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    
                    {{-- Tab Headers --}}
                    <div class="flex border-b border-gray-200 mb-8 overflow-x-auto gap-6">
                        <button id="tab-orders-btn" onclick="switchTab('orders')" class="pb-4 px-2 text-sm font-bold border-b-2 border-amber-500 text-amber-600 focus:outline-none whitespace-nowrap transition-all duration-200">
                            Order History
                        </button>
                        <button id="tab-completed-btn" onclick="switchTab('completed')" class="pb-4 px-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none whitespace-nowrap transition-all duration-200">
                            Completed Orders
                        </button>
                        <button id="tab-messages-btn" onclick="switchTab('messages')" class="pb-4 px-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none whitespace-nowrap transition-all duration-200 flex items-center gap-1.5">
                            Concierge Messages
                            @php
                                $unreadCount = $messages->filter(fn($m) => !$m->is_read && $m->reply)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="bg-amber-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-sans font-bold animate-pulse">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <button id="tab-payment-btn" onclick="switchTab('payment')" class="pb-4 px-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none whitespace-nowrap transition-all duration-200">
                            Saved Payment Gateways
                        </button>
                        <button id="tab-password-btn" onclick="switchTab('password')" class="pb-4 px-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none whitespace-nowrap transition-all duration-200">
                            Security Settings
                        </button>
                    </div>

                    {{-- Tab 1: Orders --}}
                    <div id="tab-orders" class="tab-content text-left">
                        @include('pages.dashboard.orders')
                    </div>

                    {{-- Tab 1.5: Completed Orders --}}
                    <div id="tab-completed" class="tab-content hidden text-left">
                        @include('pages.dashboard.completed')
                    </div>

                    {{-- Tab 2: Messages/Inquiries --}}
                    <div id="tab-messages" class="tab-content hidden text-left">
                        @include('pages.dashboard.messages')
                    </div>

                    {{-- Tab 3: Payment Details --}}
                    <div id="tab-payment" class="tab-content hidden text-left">
                        @include('pages.dashboard.payment')
                    </div>

                    {{-- Tab 3: Security --}}
                    <div id="tab-password" class="tab-content hidden text-left">
                        @include('pages.dashboard.security')
                    </div>

                </div>
            </div>

            <script>
            function toggleFormFields() {
                const type = document.getElementById('inquiry_type').value;
                const fieldOrder = document.getElementById('field_order_number');
                const fieldReason = document.getElementById('field_reason');
                const fieldImage = document.getElementById('field_image');
                const fieldMessage = document.getElementById('field_message');
                const msgInput = document.getElementById('message');

                // Reset all
                fieldOrder.classList.add('hidden');
                fieldReason.classList.add('hidden');
                fieldImage.classList.add('hidden');
                fieldMessage.classList.remove('hidden');
                msgInput.required = true;

                if (type === 'complain') {
                    fieldOrder.classList.remove('hidden');
                    fieldImage.classList.remove('hidden');
                } else if (type === 'refund') {
                    fieldOrder.classList.remove('hidden');
                    fieldReason.classList.remove('hidden');
                    fieldImage.classList.remove('hidden');
                    fieldMessage.classList.add('hidden');
                    msgInput.required = false;
                }
            }

            function switchTab(tabId) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(function(el) {
                    el.classList.add('hidden');
                });
                
                // Remove active styling from all buttons
                document.getElementById('tab-orders-btn').classList.remove('border-amber-500', 'text-amber-600');
                document.getElementById('tab-orders-btn').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('tab-completed-btn').classList.remove('border-amber-500', 'text-amber-600');
                document.getElementById('tab-completed-btn').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('tab-messages-btn').classList.remove('border-amber-500', 'text-amber-600');
                document.getElementById('tab-messages-btn').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('tab-payment-btn').classList.remove('border-amber-500', 'text-amber-600');
                document.getElementById('tab-payment-btn').classList.add('border-transparent', 'text-gray-500');
                document.getElementById('tab-password-btn').classList.remove('border-amber-500', 'text-amber-600');
                document.getElementById('tab-password-btn').classList.add('border-transparent', 'text-gray-500');
                
                // Show active tab
                document.getElementById('tab-' + tabId).classList.remove('hidden');
                
                // Add active styling to button
                document.getElementById('tab-' + tabId + '-btn').classList.add('border-amber-500', 'text-amber-600');
                document.getElementById('tab-' + tabId + '-btn').classList.remove('border-transparent', 'text-gray-500');
            }

            document.addEventListener('DOMContentLoaded', function() {
                toggleFormFields(); // Initialize form state
                
                @if($errors->has('current_password') || $errors->has('password'))
                    switchTab('password');
                @elseif(session('success') && (str_contains(session('success'), 'gateway') || str_contains(session('success'), 'details')))
                    switchTab('payment');
                @elseif(session('success') && (str_contains(session('success'), 'inquiry') || str_contains(session('success'), 'message') || str_contains(session('success'), 'Reply')))
                    switchTab('messages');
                @else
                    switchTab('orders');
                @endif
            });
            </script>
        </div>
    </div>
</div>
@endsection
