<?php

namespace App\Services;

use App\Repositories\Contracts\HomepageBestsellingProductRepositoryInterface;
use App\Models\Product;

class HomepageBestsellingService
{
    protected $repository;

    public function __construct(HomepageBestsellingProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function toggleProduct($productId)
    {
        $currentIds = $this->repository->getBestsellingProductIds();

        if (in_array($productId, $currentIds)) {
            // Remove it
            $currentIds = array_filter($currentIds, function($id) use ($productId) {
                return $id != $productId;
            });
            $this->repository->syncBestsellingProducts(array_values($currentIds));
            return ['status' => 'success', 'message' => 'Product removed from bestselling list.'];
        } else {
            // Add it
            if (count($currentIds) >= 8) {
                return ['status' => 'error', 'message' => 'You can only select 8 Bestselling Products.'];
            }
            $currentIds[] = $productId;
            $this->repository->syncBestsellingProducts($currentIds);
            return ['status' => 'success', 'message' => 'Product added to bestselling list.'];
        }
    }

    public function getAllProducts()
    {
        return Product::with('homepageBestselling')->paginate(10);
    }
}