<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopularSearch;
use Illuminate\Support\Facades\Storage;

class PopularSearchController extends Controller
{
    public function index()
    {
        $searches = PopularSearch::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.popular-searches.index', compact('searches'));
    }

    public function create()
    {
        return view('admin.popular-searches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Max 2MB
            'is_hot' => 'boolean',
            'sort_order' => 'required|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('popular', 'public');
        }

        PopularSearch::create([
            'name' => $validated['name'],
            'image' => $imagePath,
            'is_hot' => $request->has('is_hot'),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()->route('admin.popular-searches.index')->with('success', 'Popular search/product created successfully.');
    }

    public function edit(PopularSearch $popularSearch)
    {
        return view('admin.popular-searches.edit', compact('popularSearch'));
    }

    public function update(Request $request, PopularSearch $popularSearch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_hot' => 'boolean',
            'sort_order' => 'required|integer',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'is_hot' => $request->has('is_hot'),
            'sort_order' => $validated['sort_order'],
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($popularSearch->image) {
                Storage::disk('public')->delete($popularSearch->image);
            }
            $updateData['image'] = $request->file('image')->store('popular', 'public');
        }

        $popularSearch->update($updateData);

        return redirect()->route('admin.popular-searches.index')->with('success', 'Popular search/product updated successfully.');
    }

    public function destroy(PopularSearch $popularSearch)
    {
        if ($popularSearch->image) {
            Storage::disk('public')->delete($popularSearch->image);
        }

        $popularSearch->delete();

        return redirect()->route('admin.popular-searches.index')->with('success', 'Popular search/product deleted successfully.');
    }
}
