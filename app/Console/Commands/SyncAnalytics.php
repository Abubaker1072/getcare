<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\RevenueAnalytics;
use Illuminate\Support\Facades\DB;

class SyncAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize order and revenue data into the revenue_analytics table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting analytics sync...');

        // Group orders by date
        $ordersByDate = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(id) as total_orders'),
            DB::raw('SUM(CASE WHEN payment_method = "cod" THEN 1 ELSE 0 END) as cod_orders'),
            DB::raw('SUM(CASE WHEN payment_method != "cod" THEN 1 ELSE 0 END) as online_orders'),
            DB::raw('SUM(CASE WHEN payment_status = "paid" THEN total_amount ELSE 0 END) as total_revenue'),
            DB::raw('SUM(CASE WHEN payment_status = "paid" AND payment_method = "cod" THEN total_amount ELSE 0 END) as cod_revenue'),
            DB::raw('SUM(CASE WHEN payment_status = "paid" AND payment_method != "cod" THEN total_amount ELSE 0 END) as online_revenue')
        )->groupBy(DB::raw('DATE(created_at)'))->get();

        foreach ($ordersByDate as $stats) {
            RevenueAnalytics::updateOrCreate(
                ['date' => $stats->date],
                [
                    'total_orders' => $stats->total_orders,
                    'cod_orders' => $stats->cod_orders,
                    'online_orders' => $stats->online_orders,
                    'total_revenue' => $stats->total_revenue,
                    'cod_revenue' => $stats->cod_revenue,
                    'online_revenue' => $stats->online_revenue,
                ]
            );
        }

        $this->info('Analytics sync completed successfully!');
    }
}
