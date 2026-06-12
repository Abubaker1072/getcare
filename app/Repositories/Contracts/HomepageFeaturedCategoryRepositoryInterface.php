<?php

namespace App\Repositories\Contracts;

interface HomepageFeaturedCategoryRepositoryInterface
{
    public function getFeaturedCategoryIds(): array;

    public function syncFeaturedCategories(array $categoryIds): void;

    public function getFeaturedCategories();
}
