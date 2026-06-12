<?php

namespace App\Repositories\Contracts;

interface HomepageHotDealProductRepositoryInterface
{
    public function getHotDealProductIds(): array;

    public function syncHotDealProducts(array $productIds): void;

    public function getHotDealProducts();
}
