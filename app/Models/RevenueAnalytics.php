<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_orders',
        'cod_orders',
        'online_orders',
        'total_revenue',
        'cod_revenue',
        'online_revenue'
    ];

    public static function syncDate($date)
    {
        $stats = \App\Models\Order::select(
            \Illuminate\Support\Facades\DB::raw('COUNT(id) as total_orders'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN payment_method = "cod" THEN 1 ELSE 0 END) as cod_orders'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN payment_method != "cod" THEN 1 ELSE 0 END) as online_orders'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN payment_status = "paid" THEN total_amount ELSE 0 END) as total_revenue'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN payment_status = "paid" AND payment_method = "cod" THEN total_amount ELSE 0 END) as cod_revenue'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN payment_status = "paid" AND payment_method != "cod" THEN total_amount ELSE 0 END) as online_revenue')
        )->whereDate('created_at', $date)->first();

        self::updateOrCreate(
            ['date' => $date],
            [
                'total_orders' => $stats->total_orders ?? 0,
                'cod_orders' => $stats->cod_orders ?? 0,
                'online_orders' => $stats->online_orders ?? 0,
                'total_revenue' => $stats->total_revenue ?? 0,
                'cod_revenue' => $stats->cod_revenue ?? 0,
                'online_revenue' => $stats->online_revenue ?? 0,
            ]
        );
    }
}
