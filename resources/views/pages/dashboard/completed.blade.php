
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Completed Orders</h2>
                        @php
                            $completedOrdersList = $orders->where('status', 'completed');
                        @endphp

                        @if($completedOrdersList->isEmpty())
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="text-base font-bold text-gray-800">No Completed Orders</h3>
                                <p class="text-sm text-gray-500 mt-1">You don't have any completed orders yet.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($completedOrdersList as $order)
                                    <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition-shadow">
                                        <div class="bg-gray-50 px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4 border-b">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Order Number</p>
                                                <h4 class="text-sm sm:text-base font-extrabold text-amber-600">{{ $order->order_number }}</h4>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Date Placed</p>
                                                <p class="text-sm font-medium text-gray-800">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Actions</p>
                                                <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-md shadow-emerald-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Invoice
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-4 sm:p-6 bg-white">
                                            <p class="text-sm font-bold text-gray-700">Total: <span class="text-amber-600">{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</span></p>
                                            <p class="text-xs text-gray-500 mt-1">Delivered to: {{ $order->shipping_address }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    