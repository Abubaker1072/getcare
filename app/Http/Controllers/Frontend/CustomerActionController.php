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
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'inquiry_type' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        CustomerMessage::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'inquiry_type' => $request->inquiry_type,
            'message' => $request->message,
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
}
