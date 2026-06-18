<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the customer messages (tickets).
     */
    public function index(Request $request)
    {
        $query = CustomerMessage::query()->orderBy('created_at', 'desc');

        // Optional filtering
        if ($request->has('type') && $request->type != 'all') {
            $query->where('inquiry_type', $request->type);
        }

        if ($request->has('status')) {
            if ($request->status == 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status == 'read') {
                $query->where('is_read', true);
            }
        }

        $messages = $query->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified message.
     */
    public function show(CustomerMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Reply to the message.
     */
    public function reply(Request $request, CustomerMessage $message)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $request->reply,
            'replied_at' => now(),
            'is_read' => true,
        ]);

        return back()->with('success', 'Reply sent successfully. The customer will see this in their dashboard.');
    }
}
