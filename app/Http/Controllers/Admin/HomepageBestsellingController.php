<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HomepageBestsellingService;
use App\Models\Product;
use Illuminate\Http\Request;

class HomepageBestsellingController extends Controller
{
    protected $service;

    public function __construct(HomepageBestsellingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->getAllProducts();
        return view('admin.product-management', compact('products'));
    }

    public function toggle(Product $product)
    {
        $result = $this->service->toggleProduct($product->id);

        if ($result['status'] === 'error') {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}