<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\HomepageBestsellingProductRepositoryInterface;
use App\Repositories\Eloquent\HomepageBestsellingProductRepository;
use App\Repositories\Contracts\HomepageHotDealProductRepositoryInterface;
use App\Repositories\Eloquent\HomepageHotDealProductRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Contracts\HomepageFeaturedCategoryRepositoryInterface;
use App\Repositories\Eloquent\HomepageFeaturedCategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            HomepageBestsellingProductRepositoryInterface::class,
            HomepageBestsellingProductRepository::class
        );
        $this->app->bind(
            HomepageHotDealProductRepositoryInterface::class,
            HomepageHotDealProductRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            HomepageFeaturedCategoryRepositoryInterface::class,
            HomepageFeaturedCategoryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
