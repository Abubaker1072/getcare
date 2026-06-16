<?php

namespace App\Helpers;

use App\Models\Currency;
use Illuminate\Support\Facades\Session;

class CurrencyHelper
{
    /**
     * Get the current active currency.
     */
    public static function getCurrent()
    {
        $code = Session::get('currency_code');
        if ($code) {
            $currency = Currency::where('code', $code)->where('is_active', true)->first();
            if ($currency) {
                return $currency;
            }
        }

        $default = Currency::where('is_default', true)->first();
        if ($default) {
            Session::put('currency_code', $default->code);
            return $default;
        }

        return (object)[
            'code' => 'PKR',
            'symbol' => '₨',
            'exchange_rate' => 1.000000
        ];
    }

    /**
     * Convert a price to the current active currency.
     */
    public static function convert($price)
    {
        $currency = self::getCurrent();
        return $price * $currency->exchange_rate;
    }

    /**
     * Format a price to the current active currency with its symbol.
     */
    public static function format($price)
    {
        $currency = self::getCurrent();
        $converted = $price * $currency->exchange_rate;
        
        if ($currency->code === 'PKR') {
            return $currency->symbol . ' ' . number_format($converted, 0);
        }
        
        return $currency->symbol . number_format($converted, 2);
    }

    /**
     * Format a price using the order's specific currency and rate.
     */
    public static function formatForOrder($price, $order)
    {
        $code = $order->currency_code ?? 'PKR';
        $rate = (float) ($order->exchange_rate ?? 1.000000);
        
        $currency = Currency::where('code', $code)->first();
        $symbol = $currency ? $currency->symbol : ($code === 'PKR' ? '₨' : '$');
        
        $converted = $price * $rate;
        
        if ($code === 'PKR') {
            return $symbol . ' ' . number_format($converted, 0);
        }
        
        return $symbol . number_format($converted, 2);
    }
}
