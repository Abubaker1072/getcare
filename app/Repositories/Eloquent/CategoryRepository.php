<?php
namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::withCount('products')->latest()->get();
    }

    public function active()
    {
        return Category::withCount('products')
            ->where('status', true)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Category::withCount('products')->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Category::withCount('products')->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}