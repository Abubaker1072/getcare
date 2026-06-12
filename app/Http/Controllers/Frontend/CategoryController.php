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
        $categories = $this->categoryRepository->active();
        return view('pages.categories', compact('categories'));
    }

    public function show(string $slug)
    {
        $category = $this->categoryRepository->findBySlug($slug);
        $categories = $this->categoryRepository->active();
        $products = $category->products()->where('is_active', true)->latest()->paginate(12);

        return view('pages.category-detail', compact('category', 'categories', 'products', 'slug'));
    }
}
