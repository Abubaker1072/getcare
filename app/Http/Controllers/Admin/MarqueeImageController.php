<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarqueeImage;
use Illuminate\Support\Facades\Storage;

class MarqueeImageController extends Controller
{
    public function index()
    {
        $images = MarqueeImage::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.marquee-images.index', compact('images'));
    }

    public function create()
    {
        return view('admin.marquee-images.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Max 2MB
            'link_url' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('marquee', 'public');

        MarqueeImage::create([
            'image_path' => $imagePath,
            'link_url' => $validated['link_url'] ?? null,
            'title' => $validated['title'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.marquee-images.index')->with('success', 'Marquee Image created successfully.');
    }

    public function edit(MarqueeImage $marqueeImage)
    {
        return view('admin.marquee-images.edit', compact('marqueeImage'));
    }

    public function update(Request $request, MarqueeImage $marqueeImage)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_url' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'link_url' => $validated['link_url'] ?? null,
            'title' => $validated['title'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($marqueeImage->image_path) {
                Storage::disk('public')->delete($marqueeImage->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('marquee', 'public');
        }

        $marqueeImage->update($updateData);

        return redirect()->route('admin.marquee-images.index')->with('success', 'Marquee Image updated successfully.');
    }

    public function destroy(MarqueeImage $marqueeImage)
    {
        if ($marqueeImage->image_path) {
            Storage::disk('public')->delete($marqueeImage->image_path);
        }

        $marqueeImage->delete();

        return redirect()->route('admin.marquee-images.index')->with('success', 'Marquee Image deleted successfully.');
    }
}
