<?php

namespace App\Repositories\Contracts;

interface HomepageBestsellingProductRepositoryInterface
{
    /**
     * Get an array of currently selected bestselling product IDs.
     *
     * @return array
     */
    public function getBestsellingProductIds(): array;

    /**
     * Sync the given product IDs as bestselling products.
     *
     * @param array $productIds
     * @return void
     */
    public function syncBestsellingProducts(array $productIds): void;

    /**
     * Get the actual bestselling products to display on the homepage.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBestsellingProducts();
}