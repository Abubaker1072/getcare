<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\HomepageFeaturedCategory;
use App\Repositories\Contracts\HomepageFeaturedCategoryRepositoryInterface;

class HomepageFeaturedCategoryRepository implements HomepageFeaturedCategoryRepositoryInterface
{
    public function getFeaturedCategoryIds(): array
    {
        return HomepageFeaturedCategory::pluck('category_id')->toArray();
    }

    public function syncFeaturedCategories(array $categoryIds): void
    {
        $categoryIds = array_slice($categoryIds, 0, 8);

        HomepageFeaturedCategory::truncate();

        $data = [];
        foreach ($categoryIds as $id) {
            $data[] = [
                'category_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($data)) {
            HomepageFeaturedCategory::insert($data);
        }
    }

    public function getFeaturedCategories()
    {
        $ids = $this->getFeaturedCategoryIds();

        if (empty($ids)) {
            return collect();
        }

        return Category::whereIn('id', $ids)
            ->where('status', true)
            ->get()
            ->sortBy(fn ($category) => array_search($category->id, $ids))
            ->values();
    }
}
