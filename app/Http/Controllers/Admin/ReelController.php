<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reel;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::with('product')->latest()->paginate(15);
        return view('admin.reels', compact('reels'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.reel-create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'video' => 'required|file|mimes:mp4,mov,ogg,qt,webm|max:20480', // Max 20MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Max 2MB
            'caption' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'is_active' => 'boolean',
        ]);

        $videoPath = $request->file('video')->store('reels', 'public');
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('reels', 'public');
        }

        Reel::create([
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'caption' => $validated['caption'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.reels.index')->with('success', 'Reel created successfully.');
    }

    public function edit(Reel $reel)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.reel-edit', compact('reel', 'products'));
    }

    public function update(Request $request, Reel $reel)
    {
        $validated = $request->validate([
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt,webm|max:20480', // Max 20MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'caption' => $validated['caption'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('video')) {
            // Delete old video
            if ($reel->video_path) {
                Storage::disk('public')->delete($reel->video_path);
            }
            $updateData['video_path'] = $request->file('video')->store('reels', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($reel->thumbnail_path) {
                Storage::disk('public')->delete($reel->thumbnail_path);
            }
            $updateData['thumbnail_path'] = $request->file('thumbnail')->store('reels', 'public');
        }

        $reel->update($updateData);

        return redirect()->route('admin.reels.index')->with('success', 'Reel updated successfully.');
    }

    public function destroy(Reel $reel)
    {
        if ($reel->video_path) {
            Storage::disk('public')->delete($reel->video_path);
        }
        if ($reel->thumbnail_path) {
            Storage::disk('public')->delete($reel->thumbnail_path);
        }

        $reel->delete();

        return redirect()->route('admin.reels.index')->with('success', 'Reel deleted successfully.');
    }
}
