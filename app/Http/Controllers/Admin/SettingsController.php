<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('is_default', 'desc')->latest()->get();
        return view('admin.settings', compact('currencies'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'support_email' => 'nullable|email|max:255',
            'store_description' => 'nullable|string',
        ]);

        StoreSetting::setValue('company_name', $request->input('company_name'));
        StoreSetting::setValue('support_email', $request->input('support_email'));
        StoreSetting::setValue('store_description', $request->input('store_description'));

        return back()->with('success', 'General settings updated successfully.');
    }

    public function updateHomepage(Request $request)
    {
        $request->validate([
            'why_choose_us_subtitle' => 'nullable|string|max:255',
            'why_choose_us_title' => 'nullable|string|max:255',
            'why_choose_us_card1_title' => 'nullable|string|max:255',
            'why_choose_us_card1_desc' => 'nullable|string',
            'why_choose_us_card2_title' => 'nullable|string|max:255',
            'why_choose_us_card2_desc' => 'nullable|string',
            'why_choose_us_card3_title' => 'nullable|string|max:255',
            'why_choose_us_card3_desc' => 'nullable|string',
        ]);

        StoreSetting::setValue('why_choose_us_subtitle', $request->input('why_choose_us_subtitle'));
        StoreSetting::setValue('why_choose_us_title', $request->input('why_choose_us_title'));
        StoreSetting::setValue('why_choose_us_card1_title', $request->input('why_choose_us_card1_title'));
        StoreSetting::setValue('why_choose_us_card1_desc', $request->input('why_choose_us_card1_desc'));
        StoreSetting::setValue('why_choose_us_card2_title', $request->input('why_choose_us_card2_title'));
        StoreSetting::setValue('why_choose_us_card2_desc', $request->input('why_choose_us_card2_desc'));
        StoreSetting::setValue('why_choose_us_card3_title', $request->input('why_choose_us_card3_title'));
        StoreSetting::setValue('why_choose_us_card3_desc', $request->input('why_choose_us_card3_desc'));

        return back()->with('success', 'Homepage settings updated successfully.');
    }

    public function updateFooter(Request $request)
    {
        $request->validate([
            'footer_about_text' => 'nullable|string',
            'footer_contact_email' => 'nullable|email|max:255',
            'footer_contact_phone' => 'nullable|string|max:255',
            'footer_contact_address' => 'nullable|string|max:500',
            'footer_facebook' => 'nullable|url|max:255',
            'footer_instagram' => 'nullable|url|max:255',
            'footer_twitter' => 'nullable|url|max:255',
            'footer_youtube' => 'nullable|url|max:255',
        ]);

        StoreSetting::setValue('footer_about_text', $request->input('footer_about_text'));
        StoreSetting::setValue('footer_contact_email', $request->input('footer_contact_email'));
        StoreSetting::setValue('footer_contact_phone', $request->input('footer_contact_phone'));
        StoreSetting::setValue('footer_contact_address', $request->input('footer_contact_address'));
        StoreSetting::setValue('footer_facebook', $request->input('footer_facebook'));
        StoreSetting::setValue('footer_instagram', $request->input('footer_instagram'));
        StoreSetting::setValue('footer_twitter', $request->input('footer_twitter'));
        StoreSetting::setValue('footer_youtube', $request->input('footer_youtube'));

        return back()->with('success', 'Footer settings updated successfully.');
    }

    public function storeCurrency(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $isDefault = $request->has('is_default');
        $isActive = $request->has('is_active');

        if ($isDefault) {
            Currency::query()->update(['is_default' => false]);
        }

        Currency::create([
            'code' => strtoupper($request->code),
            'symbol' => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
            'is_default' => $isDefault,
            'is_active' => $isDefault ? true : $isActive,
        ]);

        return back()->with('success', 'Currency created successfully.');
    }

    public function updateCurrency(Request $request, Currency $currency)
    {
        $request->validate([
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $isDefault = $request->has('is_default');
        $isActive = $request->has('is_active');

        if ($isDefault) {
            Currency::query()->update(['is_default' => false]);
            $isActive = true; // Default must be active
        } else {
            // Keep the previous value if it was already default
            $isDefault = $currency->is_default;
            if ($isDefault) {
                $isActive = true;
            }
        }

        $currency->update([
            'symbol' => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
            'is_default' => $isDefault,
            'is_active' => $isActive,
        ]);

        return back()->with('success', 'Currency updated successfully.');
    }

    public function destroyCurrency(Currency $currency)
    {
        if ($currency->is_default) {
            return back()->with('error', 'Cannot delete default currency. Please set another default first.');
        }

        $currency->delete();
        return back()->with('success', 'Currency deleted successfully.');
    }
}
