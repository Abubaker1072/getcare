<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Lifestyle image
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $logoPath = null;
        $imagePath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
        }

        Brand::create([
            'name' => $validated['name'],
            'logo_path' => $logoPath,
            'image_path' => $imagePath,
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand-edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ];

        if ($request->hasFile('logo')) {
            if ($brand->logo_path) {
                Storage::disk('public')->delete($brand->logo_path);
            }
            $updateData['logo_path'] = $request->file('logo')->store('brands', 'public');
        }

        if ($request->hasFile('image')) {
            if ($brand->image_path) {
                Storage::disk('public')->delete($brand->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($updateData);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo_path) {
            Storage::disk('public')->delete($brand->logo_path);
        }
        if ($brand->image_path) {
            Storage::disk('public')->delete($brand->image_path);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
