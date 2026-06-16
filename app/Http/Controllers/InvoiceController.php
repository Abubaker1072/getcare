<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();
        if (!$user->is_admin && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this invoice.');
        }

        $order->load(['items.product', 'user']);

        return view('pages.invoice', compact('order'));
    }
}
