<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                color: black;
                padding: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans min-h-screen py-8 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden p-8 sm:p-12 relative">
        
        <!-- Action Buttons (Hidden on Print) -->
        <div class="no-print flex justify-end gap-3 mb-8">
            <a href="{{ auth()->user()->is_admin ? route('admin.orders') : route('dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
            <button onclick="window.print()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all flex items-center gap-2 shadow-md shadow-indigo-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print / Save PDF
            </button>
        </div>

        <!-- Invoice Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-widest text-slate-900 font-serif">GetCare</h1>
                <p class="text-xs font-light text-slate-500 uppercase tracking-widest mt-0.5">Beauty &amp; Skincare Devices</p>
                <div class="mt-4 text-xs text-slate-400 font-medium">
                    <p class="font-semibold">{{ \App\Models\StoreSetting::getValue('company_name', 'GetCare Beauty') }}</p>
                    <p>{{ \App\Models\StoreSetting::getValue('street_address', 'Main Office, Block B') }}, {{ \App\Models\StoreSetting::getValue('city', 'Lahore') }}</p>
                    <p>Phone: {{ \App\Models\StoreSetting::getValue('support_phone', '+92 300 1234567') }}</p>
                    <p>Email: {{ \App\Models\StoreSetting::getValue('support_email', 'support@getcarebeauty.com') }}</p>
                </div>
            </div>
            <div class="text-left md:text-right">
                <h2 class="text-xl font-bold text-slate-900 tracking-wide">INVOICE</h2>
                <p class="text-indigo-600 font-extrabold text-lg mt-1">#{{ $order->order_number }}</p>
                <div class="mt-4 text-xs text-slate-500 font-semibold space-y-1">
                    <p>Date: <span class="font-normal text-slate-600">{{ $order->created_at->format('M d, Y') }}</span></p>
                    <p>Payment Method: <span class="font-normal text-slate-600 uppercase">{{ $order->payment_method }}</span></p>
                    <p>Payment Status: <span class="font-normal text-slate-600 uppercase">{{ $order->payment_status }}</span></p>
                </div>
            </div>
        </div>

        <!-- Billing & Shipping Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-8 border-b border-slate-100">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Billed To</h3>
                <p class="font-bold text-slate-800">{{ $order->user->name ?? 'Guest Customer' }}</p>
                <p class="text-sm text-slate-500">{{ $order->user->email ?? '' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Shipped To</h3>
                <p class="font-bold text-slate-800">{{ $order->shipping_name }}</p>
                <p class="text-sm text-slate-500">Phone: {{ $order->shipping_phone }}</p>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="py-8">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Order Summary</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase">
                        <th class="py-3">Item Description</th>
                        <th class="py-3 text-center w-20">Qty</th>
                        <th class="py-3 text-right w-32">Price</th>
                        <th class="py-3 text-right w-36">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @php
                        $itemsTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                        $orderShippingFee = $order->total_amount - $itemsTotal;
                    @endphp
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-4">
                            <span class="font-semibold text-slate-800">{{ $item->product->name ?? 'Deleted Product' }}</span>
                        </td>
                        <td class="py-4 text-center text-slate-600">
                            {{ $item->quantity }}
                        </td>
                        <td class="py-4 text-right text-slate-600">
                            {{ \App\Helpers\CurrencyHelper::formatForOrder($item->price, $order) }}
                        </td>
                        <td class="py-4 text-right font-bold text-slate-900">
                            {{ \App\Helpers\CurrencyHelper::formatForOrder($item->price * $item->quantity, $order) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Grand Total Summary -->
        <div class="border-t border-slate-100 pt-6 flex justify-end">
            <div class="w-full sm:w-80 space-y-3 text-sm">
                <div class="flex justify-between text-slate-500 font-semibold">
                    <span>Subtotal</span>
                    <span class="text-slate-800">{{ \App\Helpers\CurrencyHelper::formatForOrder($itemsTotal, $order) }}</span>
                </div>
                <div class="flex justify-between text-slate-500 font-semibold">
                    <span>Shipping</span>
                    <span class="text-slate-800">{{ $orderShippingFee > 0 ? \App\Helpers\CurrencyHelper::formatForOrder($orderShippingFee, $order) : 'Free Shipping' }}</span>
                </div>
                <div class="flex justify-between border-t border-slate-200 pt-3 text-base">
                    <span class="font-extrabold text-slate-900">Total Amount</span>
                    <span class="font-extrabold text-indigo-600 text-lg">{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center text-xs text-slate-400 font-medium mt-16 pt-8 border-t border-slate-100">
            <p>Thank you for shopping with {{ \App\Models\StoreSetting::getValue('company_name', 'GetCare Beauty') }}!</p>
            <p class="mt-1">For support or inquiries, email us at {{ \App\Models\StoreSetting::getValue('support_email', 'support@getcarebeauty.com') }}</p>
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
