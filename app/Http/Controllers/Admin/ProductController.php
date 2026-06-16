<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;
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
        $categoryId = $request->input('category_id');
        $categories = $this->categoryRepository->all();
        
        $query = Product::with('category');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.products', compact('products', 'categories', 'categoryId'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->active();
        return view('admin.product-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cover_image_selection' => 'nullable|string|in:image,image_1,image_2,image_3,image_4',
            'is_active' => 'boolean',
        ]);

        foreach (['image', 'image_1', 'image_2', 'image_3', 'image_4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $validatedData[$imgField] = $request->file($imgField)->store('products', 'public');
            }
        }

        if ($request->has('cover_image_selection')) {
            $selection = $request->input('cover_image_selection');
            if (isset($validatedData[$selection])) {
                $validatedData['cover_image'] = $validatedData[$selection];
            }
        } else {
            $validatedData['cover_image'] = $validatedData['image'] ?? $validatedData['image_1'] ?? null;
        }

        $validatedData['is_active'] = $request->has('is_active');
        $validatedData['category_id'] = $request->input('category_id') ?: null;

        $this->productService->createProduct($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = $this->categoryRepository->all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cover_image_selection' => 'nullable|string|in:image,image_1,image_2,image_3,image_4',
            'is_active' => 'boolean',
        ]);

        foreach (['image', 'image_1', 'image_2', 'image_3', 'image_4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $validatedData[$imgField] = $request->file($imgField)->store('products', 'public');
            }
        }

        if ($request->has('cover_image_selection')) {
            $selection = $request->input('cover_image_selection');
            if (isset($validatedData[$selection])) {
                $validatedData['cover_image'] = $validatedData[$selection];
            } else {
                $validatedData['cover_image'] = $product->$selection;
            }
        }

        $validatedData['is_active'] = $request->has('is_active');
        $validatedData['category_id'] = $request->input('category_id') ?: null;

        $this->productService->updateProduct($product, $validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function updateCategory(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $this->productService->updateProduct($product, [
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return back()->with('success', 'Product category updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
