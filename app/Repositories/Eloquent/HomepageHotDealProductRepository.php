<?php

namespace App\Repositories\Eloquent;

use App\Models\HomepageHotDealProduct;
use App\Models\Product;
use App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface;

class HomepageHotDealProductRepository implements HomepageHotDealProductRepositoryInterface
{
    public function getHotDealProductIds(): array
    {
        return HomepageHotDealProduct::pluck('product_id')->toArray();
    }

    public function syncHotDealProducts(array $productIds): void
    {
        $productIds = array_slice($productIds, 0, 8);

        HomepageHotDealProduct::truncate();

        $data = [];
        foreach ($productIds as $id) {
            $data[] = [
                'product_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            HomepageHotDealProduct::insert($data);
        }
    }

    public function getHotDealProducts()
    {
        $ids = $this->getHotDealProductIds();

        if (empty($ids)) {
            return collect();
        }

        return Product::whereIn('id', $ids)
            ->where('is_active', true)
            ->get()
            ->sortBy(fn ($product) => array_search($product->id, $ids))
            ->values();
    }
}
