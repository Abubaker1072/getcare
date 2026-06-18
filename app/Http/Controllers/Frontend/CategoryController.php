<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->active(20);
        $pageSettings = [
            'title' => \App\Models\StoreSetting::where('key', 'categories_page_title')->value('value') ?? 'Elevate Your Skincare Ritual',
            'subtitle' => \App\Models\StoreSetting::where('key', 'categories_page_subtitle')->value('value') ?? 'Curated Collections',
            'description' => \App\Models\StoreSetting::where('key', 'categories_page_description')->value('value') ?? 'Explore our meticulously crafted categories of clinical-grade devices and potent formulations designed for transformative results.',
            'image' => \App\Models\StoreSetting::where('key', 'categories_page_image')->value('value') ?? 'images/categories/header-collection.jpg',
        ];
        return view('pages.categories', compact('categories', 'pageSettings'));
    }

    public function show(string $slug)
    {
        $category = $this->categoryRepository->findBySlug($slug);
        $categories = $this->categoryRepository->active();
        $products = $category->products()->where('is_active', true)->latest()->paginate(10);

        return view('pages.category-detail', compact('category', 'categories', 'products', 'slug'));
    }
}
