<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Get all products, optionally paginated or filtered.
     */
    public function getAllProducts($perPage = 15, $activeOnly = false)
    {
        $query = Product::with('category');

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getFilteredProducts(array $filters = [], $perPage = 15, $activeOnly = false)
    {
        $query = Product::with('category');

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        if (!empty($filters['categories'])) {
            $query->whereIn('category_id', $filters['categories']);
        }

        if (!empty($filters['in_stock'])) {
            $query->where('stock', '>', 0);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return Product::create($data);
    }

    /**
     * Get a specific product by ID or slug.
     */
    public function getProduct($identifier)
    {
        if (is_numeric($identifier)) {
            return Product::findOrFail($identifier);
        }

        return Product::where('slug', $identifier)->firstOrFail();
    }

    /**
     * Update a product.
     */
    public function updateProduct(Product $product, array $data)
    {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return $product;
    }

    /**
     * Delete a product.
     */
    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}
