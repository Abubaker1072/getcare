<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\HomepageBestsellingProductRepositoryInterface;
use App\Models\HomepageBestsellingProduct;
use App\Models\Product;

class HomepageBestsellingProductRepository implements HomepageBestsellingProductRepositoryInterface
{
    public function getBestsellingProductIds(): array
    {
        return HomepageBestsellingProduct::pluck('product_id')->toArray();
    }

    public function syncBestsellingProducts(array $productIds): void
    {
        // Limit to max 8 products as requested
        $productIds = array_slice($productIds, 0, 8);
        
        HomepageBestsellingProduct::truncate();
        
        $data = [];
        foreach ($productIds as $id) {
            $data[] = [
                'product_id' => $id, 
                'created_at' => now(), 
                'updated_at' => now()
            ];
        }
        
        if (!empty($data)) {
            HomepageBestsellingProduct::insert($data);
        }
    }
    
    public function getBestsellingProducts()
    {
        $ids = $this->getBestsellingProductIds();
        if (empty($ids)) {
            return collect();
        }
        // Fetch products and preserve order of IDs if possible, or just fetch them
        return Product::with('category')->whereIn('id', $ids)->take(8)->get();
    }
}