<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\HomepageFeaturedCategoryService;
use Illuminate\Http\Request;

class HomepageFeaturedCategoryController extends Controller
{
    protected $service;

    public function __construct(HomepageFeaturedCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->getAllCategories();

        return view('admin.category-management', compact('categories'));
    }

    public function toggle(Category $category)
    {
        $result = $this->service->toggleCategory($category->id);

        if ($result['status'] === 'error') {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
