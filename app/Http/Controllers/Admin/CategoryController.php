<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = \App\Models\Category::withCount('products')->latest()->paginate(15);
        $pageSettings = [
            'title' => \App\Models\StoreSetting::where('key', 'categories_page_title')->value('value'),
            'subtitle' => \App\Models\StoreSetting::where('key', 'categories_page_subtitle')->value('value'),
            'description' => \App\Models\StoreSetting::where('key', 'categories_page_description')->value('value'),
            'image' => \App\Models\StoreSetting::where('key', 'categories_page_image')->value('value'),
        ];
        return view('admin.categories', compact('categories', 'pageSettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'slug', 'description']);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryRepository->create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $categories = \App\Models\Category::withCount('products')->latest()->paginate(15);
        $category = $this->categoryRepository->find($id);
        $pageSettings = [
            'title' => \App\Models\StoreSetting::where('key', 'categories_page_title')->value('value'),
            'subtitle' => \App\Models\StoreSetting::where('key', 'categories_page_subtitle')->value('value'),
            'description' => \App\Models\StoreSetting::where('key', 'categories_page_description')->value('value'),
            'image' => \App\Models\StoreSetting::where('key', 'categories_page_image')->value('value'),
        ];

        return view('admin.categories', compact('categories', 'category', 'pageSettings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                Rule::unique('categories', 'slug')->ignore($id)
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'slug', 'description']);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $existing = $this->categoryRepository->find($id);
            if ($existing->image) {
                Storage::disk('public')->delete($existing->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryRepository->update($id, $data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $this->categoryRepository->delete($id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function updatePageSettings(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        \App\Models\StoreSetting::updateOrCreate(['key' => 'categories_page_title'], ['value' => $request->title]);
        \App\Models\StoreSetting::updateOrCreate(['key' => 'categories_page_subtitle'], ['value' => $request->subtitle]);
        \App\Models\StoreSetting::updateOrCreate(['key' => 'categories_page_description'], ['value' => $request->description]);

        if ($request->hasFile('image')) {
            $oldImage = \App\Models\StoreSetting::where('key', 'categories_page_image')->value('value');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('image')->store('pages', 'public');
            \App\Models\StoreSetting::updateOrCreate(['key' => 'categories_page_image'], ['value' => $path]);
        }

        return back()->with('success', 'Categories page settings updated successfully.');
    }
}