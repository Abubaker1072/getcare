<?php

namespace App\Repositories\Contracts;

interface PaymentTransactionRepositoryInterface
{
    /**
     * Create a new payment transaction log.
     */
    public function create(array $data);

    /**
     * Get all logged customer payment transactions.
     */
    public function getAllTransactions();

    /**
     * Find a transaction by its associated order ID.
     */
    public function getTransactionByOrderId($orderId);
}
