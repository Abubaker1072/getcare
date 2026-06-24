<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotDealPromo;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class HotDealPromoController extends Controller
{
    public function index()
    {
        $promos = HotDealPromo::with('product')->latest()->paginate(15);
        return view('admin.hot-deal-promos.index', compact('promos'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.hot-deal-promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Max 2MB
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt,webm|max:20480', // Max 20MB
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hot_deals', 'public');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('hot_deals', 'public');
        }

        HotDealPromo::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'],
            'button_url' => $validated['button_url'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'image_path' => $imagePath,
            'video_path' => $videoPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hot-deal-promos.index')->with('success', 'Hot Deal Promo Banner created successfully.');
    }

    public function edit(HotDealPromo $hotDealPromo)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.hot-deal-promos.edit', compact('hotDealPromo', 'products'));
    }

    public function update(Request $request, HotDealPromo $hotDealPromo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt,webm|max:20480',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'],
            'button_url' => $validated['button_url'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($hotDealPromo->image_path) {
                Storage::disk('public')->delete($hotDealPromo->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('hot_deals', 'public');
        }

        if ($request->hasFile('video')) {
            // Delete old video
            if ($hotDealPromo->video_path) {
                Storage::disk('public')->delete($hotDealPromo->video_path);
            }
            $updateData['video_path'] = $request->file('video')->store('hot_deals', 'public');
        }

        $hotDealPromo->update($updateData);

        return redirect()->route('admin.hot-deal-promos.index')->with('success', 'Hot Deal Promo Banner updated successfully.');
    }

    public function destroy(HotDealPromo $hotDealPromo)
    {
        if ($hotDealPromo->image_path) {
            Storage::disk('public')->delete($hotDealPromo->image_path);
        }
        if ($hotDealPromo->video_path) {
            Storage::disk('public')->delete($hotDealPromo->video_path);
        }

        $hotDealPromo->delete();

        return redirect()->route('admin.hot-deal-promos.index')->with('success', 'Hot Deal Promo Banner deleted successfully.');
    }
}
