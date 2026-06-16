@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Customers</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Manage your clientele, view purchase history, and track lifetime value.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button class="flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-750 transition-all">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Export CSV
            </button>
            <button onclick="openAddCustomerModal()" class="flex items-center px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Customer
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        
        <!-- Table Search -->
        <div class="p-5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <form action="{{ route('admin.customers') }}" method="GET" class="relative w-72">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name or email..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-sm" onchange="this.form.submit()">
            </form>
            <div class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Customers: <span class="text-slate-900 dark:text-white font-bold">{{ $customers->total() }}</span></div>
        </div>

        <!-- The Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
                        <th class="p-5 font-bold">Customer Profile</th>
                        <th class="p-5 font-bold text-center">Orders</th>
                        <th class="p-5 font-bold">Total Spent</th>
                        <th class="p-5 font-bold">Last Active</th>
                        <th class="p-5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50 dark:divide-slate-800/60">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors group">
                            <td class="p-5 flex items-center">
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-slate-800 shadow-sm mr-4" src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=e0e7ff&color=4f46e5" alt="Avatar">
                                <div>
                                    <p class="font-extrabold text-slate-900 dark:text-white text-base">{{ $customer->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $customer->email }}</p>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <span class="font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg">{{ $customer->orders_count }}</span>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-900 dark:text-white font-extrabold text-base">{{ \App\Helpers\CurrencyHelper::format($customer->orders_sum_total_amount ?? 0) }}</p>
                            </td>
                            <td class="p-5">
                                <p class="text-slate-700 dark:text-slate-300 font-bold">{{ $customer->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">{{ $customer->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-5 text-right">
                                <span class="text-xs text-slate-400 dark:text-slate-500 font-semibold bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg uppercase tracking-wide">Customer</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-400 dark:text-slate-550 font-semibold">
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-50 dark:border-slate-800">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <!-- Premium Add Customer Modal -->
    <div id="addCustomerModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeAddCustomerModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100 dark:border-slate-800 p-8">
                <div class="flex items-center justify-between border-b dark:border-slate-800 pb-4 mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white" id="modal-title">
                        Create Customer Account
                    </h3>
                    <button onclick="closeAddCustomerModal()" class="text-slate-400 hover:text-slate-655 dark:hover:text-slate-300 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Customer Name</label>
                        <input type="text" name="name" required placeholder="John Doe" class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                        <input type="email" name="email" required placeholder="john@example.com" class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Password</label>
                        <input type="password" name="password" required minlength="6" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-4 py-3 font-medium focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 font-medium">Minimum 6 characters required.</p>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" onclick="closeAddCustomerModal()" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-all">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.remove('hidden');
        }
        function closeAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.add('hidden');
        }
    </script>
@endsection