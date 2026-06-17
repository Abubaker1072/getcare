@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.store-manage.update') }}" method="POST">
        @csrf

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Payment Gateways</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Activate, customize, and configure payment gateways for customer checkouts.</p>
            </div>
            <div class="flex space-x-3 items-center">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-750 transition-all flex items-center">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
                    Save Gateway Settings
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40 p-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/40 p-4 rounded-xl text-sm font-bold shadow-sm">
                <p class="font-extrabold mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-xs font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Cash on Delivery (COD) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b dark:border-slate-800 pb-6 mb-6">
                        <div class="flex items-center">
                            <span class="w-12 h-12 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/40 rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Cash on Delivery</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Allow customers to pay in cash upon doorstep delivery.</p>
                            </div>
                        </div>
                        <div>
                            <select name="cod_is_active" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-2 text-xs font-bold cursor-pointer focus:bg-white dark:focus:bg-slate-900 focus:ring-1 focus:ring-indigo-500 outline-none">
                                <option value="1" {{ \App\Models\StoreSetting::getValue('cod_is_active', '1') === '1' ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ \App\Models\StoreSetting::getValue('cod_is_active') === '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Checkout Help Message / Description</label>
                        <input type="text" name="cod_description" value="{{ \App\Models\StoreSetting::getValue('cod_description', 'Pay in cash when your order is delivered to your doorstep.') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 text-sm font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        <p class="text-[10px] text-slate-400 dark:text-slate-550 mt-2 font-medium">This description is shown to the customer when selecting Cash on Delivery at checkout.</p>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-slate-50 dark:border-slate-800 text-xs font-medium text-slate-400 dark:text-slate-500 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Instant settlement, manual courier collection
                </div>
            </div>

            <!-- Direct Bank Transfer -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b dark:border-slate-800 pb-6 mb-6">
                        <div class="flex items-center">
                            <span class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/40 rounded-2xl flex items-center justify-center mr-4 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Direct Bank Transfer</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Require bank transfer receipt details during checkout process.</p>
                            </div>
                        </div>
                        <div>
                            <select name="bank_is_active" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-2 text-xs font-bold cursor-pointer focus:bg-white dark:focus:bg-slate-900 focus:ring-1 focus:ring-indigo-500 outline-none">
                                <option value="1" {{ \App\Models\StoreSetting::getValue('bank_is_active', '1') === '1' ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ \App\Models\StoreSetting::getValue('bank_is_active', '0') === '0' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Store Bank Account Details (Shown at Checkout)</label>
                        <textarea name="bank_details" rows="5" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 text-xs font-semibold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Bank Name: Al Baraka Bank&#10;Account Number: 1234-5678-9012&#10;IBAN: PK12ALBK0000001234567890&#10;Account Title: GetCare Beauty Store">{{ \App\Models\StoreSetting::getValue('bank_details', "Bank Name: Al Baraka Bank\nAccount Number: 1234-5678-9012\nIBAN: PK12ALBK0000001234567890\nAccount Title: GetCare Beauty Store") }}</textarea>
                        <p class="text-[10px] text-slate-400 dark:text-slate-550 mt-2 font-medium">Enter your store's bank details. The customer will transfer the funds to this account and supply their own bank credentials for approval.</p>
                    </div>
                </div>

            </div>

            <!-- Direct Processing Gateway (Admin Details) -->
            <div class="col-span-1 lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8">
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-6 flex items-center">
                    <span class="bg-emerald-100 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    Direct Card/Bank Processing Gateway (Admin Credentials)
                </h3>
                
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 font-medium">Configure the store's primary bank account details. When Cash on Delivery is disabled, the checkout will require customers to process payments into this account.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Admin Bank Name</label>
                        <input type="text" name="admin_bank_name" value="{{ old('admin_bank_name', $gatewaySettings->admin_bank_name) }}" placeholder="e.g. stripe,paypal" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Admin Account / IBAN Number</label>
                        <input type="text" name="admin_account_number" value="{{ old('admin_account_number', $gatewaySettings->admin_account_number) }}" placeholder="e.g. PK00MEZN00000123456789" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Admin Account Holder Name</label>
                        <input type="text" name="admin_account_holder_name" value="{{ old('admin_account_holder_name', $gatewaySettings->admin_account_holder_name) }}" placeholder="e.g. GetCare Beauty Store" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Admin Card CVC</label>
                        <input type="text" name="admin_cvc" value="{{ old('admin_cvc', $gatewaySettings->admin_cvc) }}" placeholder="e.g. 123" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Admin Card Expiry Date</label>
                        <input type="text" name="admin_expiry_date" value="{{ old('admin_expiry_date', $gatewaySettings->admin_expiry_date) }}" placeholder="e.g. 12/29" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Processed Payments log list -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-8 mt-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white flex items-center">
                    <span class="bg-indigo-100 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </span>
                    Processed Transactions Log
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Customer bank transfer and card processing entries logged during checkout.</p>
            </div>
            <a href="{{ route('admin.payment-gateways.download') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/10 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download CSV Logs
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 uppercase tracking-widest font-bold border-b border-slate-100 dark:border-slate-800">
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Customer Bank Details</th>
                        <th class="p-4">CVC</th>
                        <th class="p-4">Expiry</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 text-slate-700 dark:text-slate-300 font-medium">
                        <td class="p-4 font-bold text-slate-900 dark:text-white">
                            @if($txn->order)
                                {{ $txn->order->order_number }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="p-4">
                            @if($txn->order && $txn->order->user)
                                <div>{{ $txn->order->user->name }}</div>
                                <div class="text-[10px] text-slate-400 dark:text-slate-550">{{ $txn->order->user->email }}</div>
                            @else
                                <span class="text-slate-400">Deleted User</span>
                            @endif
                        </td>
                        <td class="p-4 space-y-1">
                            <div class="font-bold text-slate-800 dark:text-slate-200">{{ $txn->customer_bank_name }}</div>
                            <div class="font-mono text-[11px] text-slate-500 dark:text-slate-400">{{ $txn->customer_account_number }}</div>
                            <div class="text-[10px] text-slate-400 dark:text-slate-500">{{ $txn->customer_account_holder_name }}</div>
                        </td>
                        <td class="p-4 font-mono font-bold">{{ $txn->customer_cvc }}</td>
                        <td class="p-4 font-mono font-bold">{{ $txn->customer_expiry_date }}</td>
                        <td class="p-4 font-bold text-indigo-650 dark:text-indigo-400">
                            {{ \App\Helpers\CurrencyHelper::format($txn->amount) }}
                        </td>
                        <td class="p-4">
                            @if($txn->status === 'success')
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/30">SUCCESS</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100 dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900/30">FAILED</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-400 dark:text-slate-500 font-mono text-[10px]">
                            {{ $txn->created_at ? $txn->created_at->format('Y-m-d H:i') : 'N/A' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400 dark:text-slate-500 font-bold">No bank/card processing transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
