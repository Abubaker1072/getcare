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
