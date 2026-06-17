<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerMessage;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryRepliedMail;

class CRMController extends Controller
{
    /**
     * Display a listing of customer messages.
     */
    public function messagesIndex()
    {
        $messages = CustomerMessage::latest()->paginate(15);
        return view('admin.messages', compact('messages'));
    }

    /**
     * Toggle the read/unread status of a customer message.
     */
    public function toggleMessageRead(CustomerMessage $message)
    {
        $message->update([
            'is_read' => !$message->is_read
        ]);

        return back()->with('success', 'Message status updated successfully.');
    }

    /**
     * Delete a customer message.
     */
    public function destroyMessage(CustomerMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted successfully.');
    }

    /**
     * Reply to a customer message.
     */
    public function replyMessage(Request $request, CustomerMessage $message)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $request->reply,
            'replied_at' => now(),
            'is_read' => true,
        ]);

        try {
            Mail::to($message->email)->send(new InquiryRepliedMail($message));
        } catch (\Exception $mailEx) {
            \Illuminate\Support\Facades\Log::warning("InquiryRepliedMail failed to send to {$message->email}: " . $mailEx->getMessage());
        }

        return back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Display a listing of product reviews / testimonials.
     */
    public function reviewsIndex()
    {
        $reviews = Review::latest()->paginate(15);
        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Toggle the approval status of a review.
     */
    public function toggleReviewApproval(Review $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        return back()->with('success', 'Review approval status updated successfully.');
    }

    /**
     * Toggle the homepage visibility status of a review.
     */
    public function toggleReviewHomepage(Review $review)
    {
        $review->update([
            'show_on_homepage' => !$review->show_on_homepage
        ]);

        return back()->with('success', 'Review homepage visibility status updated successfully.');
    }

    /**
     * Delete a review.
     */
    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}
