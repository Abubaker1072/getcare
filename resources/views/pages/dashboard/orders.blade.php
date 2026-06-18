
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Your Order History</h2>

                        @php
                            $approvedOrders = $orders->filter(fn($o) => in_array($o->status, ['processing', 'shipped', 'completed']));
                        @endphp
                        @if($approvedOrders->isNotEmpty())
                            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl text-sm shadow-sm">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 font-bold shadow-md shadow-emerald-500/10">
                                        🎉
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-extrabold text-base text-slate-900 mb-0.5">Order Approved!</h4>
                                        <p class="font-medium text-slate-700">
                                            Your order(s) 
                                            @foreach($approvedOrders as $ao)
                                                <strong class="text-emerald-700">#{{ $ao->order_number }}</strong>@if(!$loop->last), @endif
                                            @endforeach
                                            have been approved by Admin. You can now download their invoice below.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($orders->isEmpty())
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <h3 class="text-base font-bold text-gray-800">No Orders Found</h3>
                                <p class="text-sm text-gray-500 mt-1">You haven't placed any orders yet.</p>
                                <a href="{{ route('products.all') }}" class="inline-block mt-4 bg-amber-500 text-white font-bold text-sm px-6 py-2.5 rounded-lg hover:bg-amber-600 transition shadow-md shadow-amber-100">
                                    Start Shopping
                                </a>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition-shadow">
                                        {{-- Order Info Header --}}
                                        <div class="bg-gray-50 px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4 border-b">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Order Number</p>
                                                <h4 class="text-sm sm:text-base font-extrabold text-amber-600">{{ $order->order_number }}</h4>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Date Placed</p>
                                                <p class="text-sm font-medium text-gray-800">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Payment Status</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Order Status</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase 
                                                    @if($order->status === 'completed') bg-green-50 text-green-700 border border-green-100
                                                    @elseif($order->status === 'cancelled') bg-red-50 text-red-700 border border-red-100
                                                    @elseif($order->status === 'shipped') bg-blue-50 text-blue-700 border border-blue-100
                                                    @else bg-gray-100 text-gray-700 border border-gray-200
                                                    @endif">
                                                    {{ $order->status }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Actions</p>
                                                @if($order->status === 'pending')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold">
                                                        <svg class="w-3.5 h-3.5 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3 3L22 4"></path></svg>
                                                        Awaiting Review
                                                    </span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold">
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-md shadow-emerald-100">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        Invoice
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Order Items --}}
                                        <div class="p-4 sm:p-6 divide-y divide-gray-100 bg-white">
                                            @foreach($order->items as $item)
                                                @php
                                                    $product = $item->product;
                                                    $imagePath = $product && ($product->cover_image || $product->image)
                                                        ? asset('storage/' . ($product->cover_image ?? $product->image))
                                                        : 'https://via.placeholder.com/150';
                                                @endphp
                                                <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                                                    <div class="w-14 h-14 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                                        <img src="{{ $imagePath }}" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        @if($product)
                                                            <h5 class="text-sm font-bold text-gray-900 truncate hover:text-amber-600">
                                                                <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                            </h5>
                                                        @else
                                                            <h5 class="text-sm font-bold text-gray-500 truncate">Deleted Product</h5>
                                                        @endif
                                                        <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} x {{ \App\Helpers\CurrencyHelper::formatForOrder($item->price, $order) }}</p>
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-900">{{ \App\Helpers\CurrencyHelper::formatForOrder($item->price * $item->quantity, $order) }}</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Order Shipping Summary --}}
                                        <div class="bg-gray-50/50 p-4 sm:px-6 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">
                                            <div>
                                                <span class="font-semibold text-gray-700">Shipping to:</span>
                                                <span class="text-gray-600">{{ $order->shipping_name }} ({{ $order->shipping_phone }}), {{ $order->shipping_address }}</span>
                                            </div>
                                            <div class="text-right w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 flex justify-between sm:block gap-4">
                                                <span class="font-bold text-gray-500 sm:mr-2">Grand Total:</span>
                                                <span class="text-lg font-extrabold text-amber-600">{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</span>
                                            </div>
                                        </div>

                                        {{-- Order Tracker Visual --}}
                                        <div class="px-4 sm:px-6 py-5 bg-white border-t">
                                            <div class="w-full">
                                                <div class="flex items-center justify-between relative">
                                                    @php
                                                        $statusOrder = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'completed' => 4];
                                                        $currentStep = $statusOrder[$order->status] ?? ($order->status == 'cancelled' ? 0 : 1);
                                                    @endphp
                                                    
                                                    {{-- Background Line --}}
                                                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded-full"></div>
                                                    
                                                    {{-- Active Line --}}
                                                    @if($currentStep > 0)
                                                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-amber-500 z-0 rounded-full transition-all duration-500" style="width: {{ ($currentStep - 1) * 33.33 }}%;"></div>
                                                    @endif

                                                    {{-- Steps --}}
                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStep >= 1 ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-gray-200 text-gray-500' }}">1</div>
                                                        <span class="text-[10px] mt-2 font-bold uppercase tracking-wider {{ $currentStep >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Pending</span>
                                                    </div>
                                                    
                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStep >= 2 ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-gray-200 text-gray-500' }}">2</div>
                                                        <span class="text-[10px] mt-2 font-bold uppercase tracking-wider {{ $currentStep >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Processing</span>
                                                    </div>

                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStep >= 3 ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-gray-200 text-gray-500' }}">3</div>
                                                        <span class="text-[10px] mt-2 font-bold uppercase tracking-wider {{ $currentStep >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Shipped</span>
                                                    </div>

                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $currentStep >= 4 ? 'bg-green-500 text-white shadow-md shadow-green-200' : 'bg-gray-200 text-gray-500' }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                        <span class="text-[10px] mt-2 font-bold uppercase tracking-wider {{ $currentStep >= 4 ? 'text-green-600' : 'text-gray-400' }}">Completed</span>
                                                    </div>
                                                </div>
                                                
                                                {{-- Status Updates / Tracking Notes --}}
                                                @if($order->statusUpdates && $order->statusUpdates->count() > 0)
                                                    <div class="mt-6 border-t border-gray-100 pt-4">
                                                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Live Tracking Updates</h4>
                                                        <div class="space-y-4 pl-2 border-l-2 border-amber-200 ml-3">
                                                            @foreach($order->statusUpdates as $update)
                                                                <div class="relative">
                                                                    <div class="absolute -left-[13px] top-1 w-2.5 h-2.5 rounded-full bg-amber-500 ring-4 ring-white"></div>
                                                                    <div class="pl-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="text-xs font-bold text-gray-900 uppercase">{{ $update->status }}</span>
                                                                            <span class="text-[10px] text-gray-400 font-medium">{{ $update->created_at->format('M d, Y h:i A') }}</span>
                                                                        </div>
                                                                        @if($update->note)
                                                                            <p class="text-xs text-gray-600 mt-1 bg-gray-50 p-2 rounded-lg border border-gray-100 inline-block">{{ $update->note }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    