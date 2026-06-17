<?php

namespace App\Services;

use App\Repositories\Contracts\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\PaymentTransactionRepositoryInterface;

class PaymentProcessingService
{
    protected $gatewayRepo;
    protected $transactionRepo;

    public function __construct(
        PaymentGatewayRepositoryInterface $gatewayRepo,
        PaymentTransactionRepositoryInterface $transactionRepo
    ) {
        $this->gatewayRepo = $gatewayRepo;
        $this->transactionRepo = $transactionRepo;
    }

    /**
     * Process checkout payment simulated logic.
     *
     * @param float $amount
     * @param array $paymentData
     * @param int|null $orderId
     * @return array
     */
    public function processPayment(float $amount, array $paymentData, $orderId = null): array
    {
        $accountNum = $paymentData['customer_account_number'] ?? '';
        
        // Simulation rule: If account number ends in '9' or contains 'fail' / 'insufficient' (case insensitive), payment fails.
        $isInsufficient = str_ends_with(trim($accountNum), '9') 
            || str_contains(strtolower($accountNum), 'fail') 
            || str_contains(strtolower($accountNum), 'insufficient');

        if ($isInsufficient) {
            // Log the failed transaction
            $this->transactionRepo->create([
                'order_id' => $orderId,
                'customer_bank_name' => $paymentData['customer_bank_name'],
                'customer_account_number' => $paymentData['customer_account_number'],
                'customer_account_holder_name' => $paymentData['customer_account_holder'],
                'customer_cvc' => $paymentData['customer_cvc'],
                'customer_expiry_date' => $paymentData['customer_expiry_date'],
                'amount' => $amount,
                'status' => 'failed',
            ]);

            return [
                'success' => false,
                'status' => 'insufficient_balance',
                'message' => 'Transaction declined: Insufficient balance in the customer bank account.',
            ];
        }

        // Otherwise transaction is successful. Log success.
        $this->transactionRepo->create([
            'order_id' => $orderId,
            'customer_bank_name' => $paymentData['customer_bank_name'],
            'customer_account_number' => $paymentData['customer_account_number'],
            'customer_account_holder_name' => $paymentData['customer_account_holder'],
            'customer_cvc' => $paymentData['customer_cvc'],
            'customer_expiry_date' => $paymentData['customer_expiry_date'],
            'amount' => $amount,
            'status' => 'success',
        ]);

        return [
            'success' => true,
            'status' => 'success',
            'message' => 'Payment processed successfully.',
        ];
    }
}
