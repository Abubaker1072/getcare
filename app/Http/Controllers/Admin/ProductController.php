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
        $search = $request->input('search');
        $categories = $this->categoryRepository->all();
        
        $query = Product::with('category');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $products = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.products', compact('products', 'categories', 'categoryId', 'search'));
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
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'purchased_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'cover_image_selection' => 'nullable|string|in:image,image_1,image_2,image_3,image_4',
            'is_active' => 'boolean',
            'tags' => 'nullable|string|max:255',
            'promo_text' => 'nullable|string|max:255',
            'bullet_points' => 'nullable|array',
            'bullet_points.*' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
        ]);

        foreach (['image', 'image_1', 'image_2', 'image_3', 'image_4', 'banner_image'] as $imgField) {
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

        $validatedData['bullet_points'] = array_values(array_filter($request->input('bullet_points', [])));
        $validatedData['features'] = array_values(array_filter($request->input('features', [])));
        
        $faqs = $request->input('faqs', []);
        $validatedData['faqs'] = array_values(array_filter($faqs, function($faq) {
            return !empty($faq['question']) && !empty($faq['answer']);
        }));

        $this->productService->createProduct($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with(['testimonials', 'reviewVideos', 'reviews'])->findOrFail($id);
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
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'purchased_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'cover_image_selection' => 'nullable|string|in:image,image_1,image_2,image_3,image_4',
            'is_active' => 'boolean',
            'tags' => 'nullable|string|max:255',
            'promo_text' => 'nullable|string|max:255',
            'bullet_points' => 'nullable|array',
            'bullet_points.*' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
        ]);

        foreach (['image', 'image_1', 'image_2', 'image_3', 'image_4', 'banner_image'] as $imgField) {
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

        $validatedData['bullet_points'] = array_values(array_filter($request->input('bullet_points', [])));
        $validatedData['features'] = array_values(array_filter($request->input('features', [])));
        
        $faqs = $request->input('faqs', []);
        $validatedData['faqs'] = array_values(array_filter($faqs, function($faq) {
            return !empty($faq['question']) && !empty($faq['answer']);
        }));

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

    // Product Testimonials
    public function storeTestimonial(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:255',
        ]);
        $path = $request->file('image')->store('testimonials', 'public');
        $product->testimonials()->create([
            'image_path' => $path,
            'caption' => $request->input('caption'),
            'short_description' => $request->input('short_description'),
        ]);
        return back()->with('success', 'Testimonial added successfully.');
    }

    public function destroyTestimonial(Product $product, $testimonialId)
    {
        $testimonial = $product->testimonials()->findOrFail($testimonialId);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted successfully.');
    }

    // Product Review Videos
    public function storeReviewVideo(Request $request, Product $product)
    {
        $request->validate([
            'video' => 'required|mimetypes:video/mp4,video/x-m4v,video/*|max:20480',
            'caption' => 'nullable|string|max:255',
            'show_on_homepage' => 'nullable|boolean'
        ]);
        $path = $request->file('video')->store('review_videos', 'public');
        $product->reviewVideos()->create([
            'video_path' => $path,
            'caption' => $request->input('caption'),
            'show_on_homepage' => $request->has('show_on_homepage'),
            'is_active' => true
        ]);
        return back()->with('success', 'Review video added successfully.');
    }

    public function destroyReviewVideo(Product $product, $videoId)
    {
        $video = $product->reviewVideos()->findOrFail($videoId);
        $video->delete();
        return back()->with('success', 'Review video deleted successfully.');
    }

    // Product Reviews
    public function approveReview(Product $product, $reviewId)
    {
        $review = $product->reviews()->findOrFail($reviewId);
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Review status updated.');
    }

    public function destroyReview(Product $product, $reviewId)
    {
        $review = $product->reviews()->findOrFail($reviewId);
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}
