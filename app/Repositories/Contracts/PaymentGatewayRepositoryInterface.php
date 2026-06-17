<?php

namespace App\Repositories\Contracts;

interface PaymentGatewayRepositoryInterface
{
    /**
     * Get the active administrative gateway configuration settings.
     */
    public function getAdminGatewaySettings();

    /**
     * Save/update the active administrative gateway configuration settings.
     */
    public function saveAdminGatewaySettings(array $data);
}
