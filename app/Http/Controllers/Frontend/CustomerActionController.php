<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerMessage;
use App\Models\Review;
use Illuminate\Http\Request;

class CustomerActionController extends Controller
{
    /**
     * Store a new customer contact message.
     */
    public function storeMessage(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'inquiry_type' => 'required|string|max:255',
            'message' => 'nullable|string',
            'phone_number' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'reason' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tickets', 'public');
        }

        CustomerMessage::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'inquiry_type' => $request->inquiry_type,
            'message' => $request->message,
            'phone_number' => $request->phone_number,
            'order_number' => $request->order_number,
            'address' => $request->address,
            'reason' => $request->reason,
            'image_path' => $imagePath,
            'is_read' => false,
        ]);

        return back()->with('success', 'Your inquiry has been submitted successfully! Our concierge team will get back to you shortly.');
    }

    /**
     * Store a new customer review/testimonial.
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'title' => $request->title,
            'text' => $request->text,
            'is_approved' => true, // Auto-approved by default, can be toggled by admin
        ]);

        return back()->with('success', 'Thank you for sharing your transformation story! Your review has been submitted.');
    }

    /**
     * Update customer saved bank details from dashboard.
     */
    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_holder_name' => 'nullable|string|max:255',
            'cvc' => 'nullable|string|max:4',
            'expiry_date' => 'nullable|string|max:10',
        ]);

        \App\Models\UserBankDetail::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'bank_name' => $request->input('bank_name'),
                'account_number' => $request->input('account_number'),
                'account_holder_name' => $request->input('account_holder_name'),
                'cvc' => $request->input('cvc'),
                'expiry_date' => $request->input('expiry_date'),
            ]
        );

        return back()->with('success', 'Your gateway payment details have been saved successfully.');
    }

    /**
     * Change the authenticated user's password from the dashboard.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Your password has been changed successfully.');
    }
}
