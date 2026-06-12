<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\HomepageFeaturedCategoryRepositoryInterface;

class HomepageFeaturedCategoryService
{
    protected $repository;

    public function __construct(HomepageFeaturedCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function toggleCategory(int $categoryId): array
    {
        $currentIds = $this->repository->getFeaturedCategoryIds();

        if (in_array($categoryId, $currentIds)) {
            $currentIds = array_values(array_filter($currentIds, fn ($id) => $id != $categoryId));
            $this->repository->syncFeaturedCategories($currentIds);

            return ['status' => 'success', 'message' => 'Category removed from homepage.'];
        }

        if (count($currentIds) >= 8) {
            return ['status' => 'error', 'message' => 'You can only select 8 categories for the homepage.'];
        }

        $currentIds[] = $categoryId;
        $this->repository->syncFeaturedCategories($currentIds);

        return ['status' => 'success', 'message' => 'Category added to homepage.'];
    }

    public function getAllCategories()
    {
        return Category::with('homepageFeatured')
            ->withCount('products')
            ->latest()
            ->paginate(10);
    }
}
