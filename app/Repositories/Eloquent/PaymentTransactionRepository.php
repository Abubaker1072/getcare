<?php

namespace App\Repositories\Eloquent;

use App\Models\PaymentTransaction;
use App\Repositories\Contracts\PaymentTransactionRepositoryInterface;

class PaymentTransactionRepository implements PaymentTransactionRepositoryInterface
{
    /**
     * Create a new payment transaction log.
     */
    public function create(array $data)
    {
        return PaymentTransaction::create($data);
    }

    /**
     * Get all logged customer payment transactions.
     */
    public function getAllTransactions()
    {
        return PaymentTransaction::with(['order.user'])->latest()->get();
    }

    /**
     * Find a transaction by its associated order ID.
     */
    public function getTransactionByOrderId($orderId)
    {
        return PaymentTransaction::where('order_id', $orderId)->first();
    }
}
