<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueAnalyticsController extends Controller
{
    public function index()
    {
        // Get all time stats
        $totalStats = [
            'total_orders' => \App\Models\RevenueAnalytics::sum('total_orders'),
            'cod_orders' => \App\Models\RevenueAnalytics::sum('cod_orders'),
            'online_orders' => \App\Models\RevenueAnalytics::sum('online_orders'),
            'total_revenue' => \App\Models\RevenueAnalytics::sum('total_revenue'),
            'cod_revenue' => \App\Models\RevenueAnalytics::sum('cod_revenue'),
            'online_revenue' => \App\Models\RevenueAnalytics::sum('online_revenue'),
        ];

        // Fetch recent days for chart/table
        $recentStats = \App\Models\RevenueAnalytics::orderBy('date', 'desc')->take(30)->get();

        return view('admin.analytics.index', compact('totalStats', 'recentStats'));
    }

    public function sync()
    {
        \Illuminate\Support\Facades\Artisan::call('analytics:sync');
        return back()->with('success', 'Analytics data has been synchronized successfully!');
    }
}
