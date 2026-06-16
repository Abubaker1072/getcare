<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class StoreManageController extends Controller
{
    public function index()
    {
        return view('admin.store-manage');
    }

    public function paymentGateways()
    {
        return view('admin.payment-gateways');
    }

    public function update(Request $request)
    {
        $request->validate([
            // Company details
            'company_name' => 'nullable|string|max:255',
            'support_phone' => 'nullable|string|max:50',
            'support_email' => 'nullable|email|max:255',
            'street_address' => 'nullable|string',
            'city' => 'nullable|string|max:200',
            'state' => 'nullable|string|max:200',
            'zip_code' => 'nullable|string|max:50',
            
            // Hero section config
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_media_type' => 'sometimes|required|in:image,video',
            'hero_media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm,ogg|max:20480', // Max 20MB for video
            
            // Scheduled hero section
            'hero_scheduled_media_type' => 'sometimes|required|in:image,video',
            'hero_scheduled_media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm,ogg|max:20480',
            'hero_scheduled_start' => 'nullable|date',
            'hero_scheduled_end' => 'nullable|date|after_or_equal:hero_scheduled_start',
            
            // Countdown Timer
            'countdown_is_active' => 'nullable|in:0,1',
            'countdown_end_time' => 'nullable|date',
            'countdown_text' => 'nullable|string|max:255',

            // Shipping & Payments
            'shipping_fee' => 'nullable|numeric|min:0',
            'shipping_is_active' => 'nullable|in:0,1',
            'cod_is_active' => 'nullable|in:0,1',
            'cod_description' => 'nullable|string',
            'bank_is_active' => 'nullable|in:0,1',
            'bank_details' => 'nullable|string',
        ]);

        // Simple text fields saving
        $keys = [
            'company_name', 'support_phone', 'support_email', 'street_address', 'city', 'state', 'zip_code',
            'hero_title', 'hero_subtitle', 'hero_media_type', 'hero_scheduled_media_type',
            'hero_scheduled_start', 'hero_scheduled_end', 'countdown_is_active', 'countdown_end_time', 'countdown_text',
            'shipping_fee', 'shipping_is_active', 'cod_is_active', 'cod_description', 'bank_is_active', 'bank_details'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                StoreSetting::setValue($key, $request->input($key));
            }
        }

        // Default Hero Background media upload
        if ($request->hasFile('hero_media')) {
            $file = $request->file('hero_media');
            $fileName = 'hero_background_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('hero', $fileName, 'public');
            StoreSetting::setValue('hero_media_path', $path);
        }

        // Scheduled Hero Background media upload
        if ($request->hasFile('hero_scheduled_media')) {
            $file = $request->file('hero_scheduled_media');
            $fileName = 'hero_scheduled_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('hero', $fileName, 'public');
            StoreSetting::setValue('hero_scheduled_media_path', $path);
        }

        return redirect()->back()->with('success', 'Store settings updated successfully.');
    }

    public function reset()
    {
        $keys = [
            'hero_title', 'hero_subtitle', 'hero_media_type', 'hero_media_path',
            'hero_scheduled_media_type', 'hero_scheduled_media_path',
            'hero_scheduled_start', 'hero_scheduled_end', 'countdown_is_active',
            'countdown_end_time', 'countdown_text'
        ];

        foreach ($keys as $key) {
            StoreSetting::where('key', $key)->delete();
        }

        return redirect()->back()->with('success', 'Store customizations reset to default values successfully.');
    }
}
