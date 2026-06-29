<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetCare Beauty - Orders Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff;
                color: #000000;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body class="p-8 max-w-6xl mx-auto">

    <!-- Print Header Controls -->
    <div class="no-print flex justify-between items-center bg-slate-50 border border-slate-100 p-4 rounded-2xl mb-8">
        <div class="flex items-center gap-3">
            <span class="text-2xl">📄</span>
            <div>
                <h4 class="font-bold text-sm">PDF Print Preview</h4>
                <p class="text-xs text-slate-500">Your report has been generated. Use the print prompt to save as PDF or print.</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.deep-manage', ['status' => $status, 'month' => $month]) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition-colors">
                Back to Dashboard
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                Open Print Dialogue
            </button>
        </div>
    </div>

    <!-- The Report Header -->
    <div class="border-b-2 border-slate-900 pb-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 uppercase">GetCare Beauty</h1>
                <p class="text-xs font-bold tracking-widest text-indigo-600 uppercase mt-0.5">Orders Report & Shipment Ledger</p>
            </div>
            <div class="text-right text-xs text-slate-500 font-semibold space-y-0.5">
                <p>Status: <span class="text-slate-900 uppercase font-bold">{{ $status }}</span></p>
                <p>Month: <span class="text-slate-900 font-bold">
                    {{ $month === 'all' ? 'All Months (All Time)' : date('F Y', strtotime($month . '-01')) }}
                </span></p>
                <p>Date Generated: <span class="text-slate-900 font-bold">{{ date('Y-m-d H:i') }}</span></p>
            </div>
        </div>
    </div>

    <!-- Table of Orders -->
    <table class="w-full text-left border-collapse border-b border-slate-200">
        <thead>
            <tr class="border-b border-slate-900 text-[10px] uppercase font-bold tracking-wider text-slate-500">
                <th class="py-3 pr-4">Order Details</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Customer Name & Phone</th>
                <th class="py-3 px-4">Shipping Address</th>
                <th class="py-3 px-4">Products</th>
                <th class="py-3 px-4">Payment</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 pl-4 text-right">Total</th>
            </tr>
        </thead>
        <tbody class="text-xs divide-y divide-slate-100">
            @php $grandTotal = 0; @endphp
            @forelse($orders as $order)
                @php $grandTotal += $order->total_amount; @endphp
                <tr class="align-top">
                    <td class="py-4 pr-4">
                        <span class="font-extrabold text-slate-950 block">#{{ $order->order_number }}</span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">{{ $order->user->email ?? 'Guest' }}</span>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <span>{{ $order->created_at->format('Y-m-d') }}</span>
                    </td>
                    <td class="py-4 px-4">
                        <span class="font-bold text-slate-900 block">{{ $order->shipping_name }}</span>
                        <span class="text-[10px] text-slate-500 block">{{ $order->shipping_phone }}</span>
                    </td>
                    <td class="py-4 px-4 text-slate-550 max-w-[200px] leading-relaxed">
                        {{ $order->shipping_address }}
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap leading-relaxed">
                        @foreach($order->items as $item)
                            • {{ $item->product->name ?? 'Product' }} <span class="font-bold">(x{{ $item->quantity }})</span><br>
                        @endforeach
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <span class="font-bold block text-[10px] text-slate-500 uppercase">{{ $order->payment_method ?? 'COD' }}</span>
                        <span class="font-semibold text-[10px] uppercase {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $order->payment_status }}</span>
                    </td>
                    <td class="py-4 px-4 uppercase font-bold text-[10px] whitespace-nowrap">
                        <span class="
                            @if($order->status === 'completed') text-green-600
                            @elseif($order->status === 'cancelled') text-red-600
                            @elseif($order->status === 'shipped') text-blue-600
                            @else text-amber-600
                            @endif
                        ">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="py-4 pl-4 text-right font-black text-slate-900">
                        {{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-10 text-center text-slate-400 font-semibold">
                        No orders matched criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Ledger Total Summary -->
    <div class="flex justify-end mt-8">
        <div class="w-64 bg-slate-50 border border-slate-100 p-4 rounded-2xl">
            <div class="flex justify-between items-center text-xs font-bold text-slate-500 mb-1">
                <span>TOTAL TRANSACTIONS</span>
                <span class="text-slate-900">{{ $orders->count() }}</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                <span class="text-xs font-extrabold text-slate-900">GRAND TOTAL</span>
                <span class="text-base font-black text-indigo-600">
                    {{ \App\Helpers\CurrencyHelper::format($grandTotal) }}
                </span>
            </div>
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
