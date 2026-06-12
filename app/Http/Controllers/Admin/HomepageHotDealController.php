<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\HomepageHotDealService;

class HomepageHotDealController extends Controller
{
    protected $hotDealService;

    public function __construct(HomepageHotDealService $hotDealService)
    {
        $this->hotDealService = $hotDealService;
    }

    public function index()
    {
        $products = Product::with(['homepageHotDeal', 'category'])->latest()->paginate(15);

        return view('admin.hot-deals', compact('products'));
    }

    public function manage()
    {
        $products = $this->hotDealService->getAllProducts();

        return view('admin.hot-deal-management', compact('products'));
    }

    public function toggle(Product $product)
    {
        $result = $this->hotDealService->toggleProduct($product->id);

        if ($result['status'] === 'error') {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
