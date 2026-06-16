<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryRepository;

    public function __construct(ProductService $productService, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $selectedCategories = array_filter((array) $request->input('categories', []), 'is_numeric');
        $priceRange = $request->input('price_range');

        $filters = [
            'categories' => $selectedCategories,
            'in_stock' => $request->boolean('in_stock'),
            'sort' => $request->input('sort', 'newest'),
        ];

        if ($priceRange) {
            match ($priceRange) {
                '0-50' => [$filters['min_price'] = 0, $filters['max_price'] = 50],
                '50-100' => [$filters['min_price'] = 50, $filters['max_price'] = 100],
                '100-200' => [$filters['min_price'] = 100, $filters['max_price'] = 200],
                '200+' => $filters['min_price'] = 200,
                default => null,
            };
        }

        $products = $this->productService->getFilteredProducts($filters, 20, true);
        $categories = $this->categoryRepository->active();

        return view('pages.shop', compact('products', 'categories', 'selectedCategories', 'filters'));
    }

    public function show($identifier)
    {
        $product = $this->productService->getProduct($identifier);

        if (!$product->is_active) {
            abort(404);
        }

        return view('pages.product-detail', compact('product'));
    }
}
