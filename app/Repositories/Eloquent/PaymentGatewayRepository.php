<?php

namespace App\Repositories\Eloquent;

use App\Models\PaymentGateway;
use App\Repositories\Contracts\PaymentGatewayRepositoryInterface;

class PaymentGatewayRepository implements PaymentGatewayRepositoryInterface
{
    /**
     * Get the active administrative gateway configuration settings.
     */
    public function getAdminGatewaySettings()
    {
        return PaymentGateway::firstOrCreate([], [
            'admin_bank_name' => '',
            'admin_account_number' => '',
            'admin_account_holder_name' => '',
            'admin_cvc' => '',
            'admin_expiry_date' => '',
        ]);
    }

    /**
     * Save/update the active administrative gateway configuration settings.
     */
    public function saveAdminGatewaySettings(array $data)
    {
        $settings = $this->getAdminGatewaySettings();
        $settings->update($data);
        return $settings;
    }
}
