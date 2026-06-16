<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface;

class HomepageHotDealService
{
    protected $repository;

    public function __construct(HomepageHotDealProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function toggleProduct(int $productId): array
    {
        $currentIds = $this->repository->getHotDealProductIds();

        if (in_array($productId, $currentIds)) {
            $currentIds = array_values(array_filter($currentIds, fn ($id) => $id != $productId));
            $this->repository->syncHotDealProducts($currentIds);

            return ['status' => 'success', 'message' => 'Product removed from hot deals.'];
        }

        if (count($currentIds) >= 8) {
            return ['status' => 'error', 'message' => 'You can only select 8 Hot Deal Products.'];
        }

        $currentIds[] = $productId;
        $this->repository->syncHotDealProducts($currentIds);

        return ['status' => 'success', 'message' => 'Product added to hot deals.'];
    }

    public function getAllProducts()
    {
        return Product::with('homepageHotDeal')->paginate(15);
    }

    public function getHotDealProducts()
    {
        return $this->repository->getHotDealProducts();
    }
}
