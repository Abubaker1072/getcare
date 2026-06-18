@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Revenue & Order Analytics ✨</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <form method="POST" action="{{ route('admin.analytics.sync') }}">
                @csrf
                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Sync Data Now</span>
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Total Revenue Breakdown -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4 uppercase tracking-wide">Total Revenue Breakdown</h2>
            <div class="flex items-end mb-6">
                <div class="text-4xl font-extrabold text-slate-800">{{ \App\Helpers\CurrencyHelper::format($totalStats['total_revenue']) }}</div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>
                        Cash on Delivery (COD)
                    </span>
                    <span class="font-bold text-slate-800">{{ \App\Helpers\CurrencyHelper::format($totalStats['cod_revenue']) }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-indigo-500 mr-2"></span>
                        Online Payment Gateways
                    </span>
                    <span class="font-bold text-slate-800">{{ \App\Helpers\CurrencyHelper::format($totalStats['online_revenue']) }}</span>
                </div>
            </div>
        </div>

        <!-- Total Orders Breakdown -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4 uppercase tracking-wide">Total Orders Breakdown</h2>
            <div class="flex items-end mb-6">
                <div class="text-4xl font-extrabold text-slate-800">{{ number_format($totalStats['total_orders']) }}</div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>
                        Cash on Delivery (COD)
                    </span>
                    <span class="font-bold text-slate-800">{{ number_format($totalStats['cod_orders']) }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-indigo-500 mr-2"></span>
                        Online Payment Gateways
                    </span>
                    <span class="font-bold text-slate-800">{{ number_format($totalStats['online_orders']) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Daily Log Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Daily Analytics (Last 30 Days)</h2>
        </header>
        <div class="p-3">
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50">
                        <tr>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Date</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Total Orders</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">COD Orders</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Online Orders</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Total Revenue</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">COD Revenue</div></th>
                            <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Online Revenue</div></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @forelse($recentStats as $stat)
                        <tr>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-slate-800 font-medium">{{ \Carbon\Carbon::parse($stat->date)->format('M d, Y') }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-slate-600">{{ $stat->total_orders }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-emerald-500 font-medium">{{ $stat->cod_orders }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-indigo-500 font-medium">{{ $stat->online_orders }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-slate-800 font-bold">{{ \App\Helpers\CurrencyHelper::format($stat->total_revenue) }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-emerald-500 font-medium">{{ \App\Helpers\CurrencyHelper::format($stat->cod_revenue) }}</div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left text-indigo-500 font-medium">{{ \App\Helpers\CurrencyHelper::format($stat->online_revenue) }}</div></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-2 whitespace-nowrap text-center text-slate-500 py-4">No data available for the last 30 days. Click Sync Data Now.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
