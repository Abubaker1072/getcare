<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    /**
     * Show checkout form.
     */
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add products before checkout.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingActive = \App\Models\StoreSetting::getValue('shipping_is_active', '1') === '1';
        $shippingFee = 0;
        if ($subtotal > 0 && $shippingActive) {
            $shippingFee = (float) \App\Models\StoreSetting::getValue('shipping_fee', 150);
        }
        $total = $subtotal + $shippingFee;

        $codActive = \App\Models\StoreSetting::getValue('cod_is_active', '1') === '1';
        $codDescription = \App\Models\StoreSetting::getValue('cod_description', 'Pay in cash when your order is delivered to your doorstep.');
        $bankActive = \App\Models\StoreSetting::getValue('bank_is_active', '1') === '1';
        $bankDetails = \App\Models\StoreSetting::getValue('bank_details', '');

        return view('pages.checkout', compact(
            'cartItems', 'subtotal', 'shippingFee', 'total',
            'codActive', 'codDescription', 'bankActive', 'bankDetails'
        ));
    }

    /**
     * Handle order submission.
     */
    public function placeOrder(Request $request)
    {
        // Dynamically build valid payment methods
        $validMethods = [];
        if (\App\Models\StoreSetting::getValue('cod_is_active', '1') === '1') {
            $validMethods[] = 'cod';
        }
        if (\App\Models\StoreSetting::getValue('bank_is_active', '1') === '1') {
            $validMethods[] = 'bank';
        }
        if (empty($validMethods)) {
            $validMethods = ['cod'];
        }

        $rules = [
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:' . implode(',', $validMethods),
        ];

        if ($request->input('payment_method') === 'bank') {
            $rules['customer_bank_name'] = 'required|string|max:255';
            $rules['customer_account_number'] = 'required|string|max:255';
            $rules['customer_account_holder'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Validate stock before placing order
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Sorry, product {$item->product->name} does not have enough stock available.");
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingActive = \App\Models\StoreSetting::getValue('shipping_is_active', '1') === '1';
        $shippingFee = 0;
        if ($subtotal > 0 && $shippingActive) {
            $shippingFee = (float) \App\Models\StoreSetting::getValue('shipping_fee', 150);
        }
        $total = $subtotal + $shippingFee;

        // Generate a unique order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        // Get checkout currency code and rate
        $currentCurrency = \App\Helpers\CurrencyHelper::getCurrent();

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'status' => 'pending',
            'total_amount' => $total,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'currency_code' => $currentCurrency->code,
            'exchange_rate' => $currentCurrency->exchange_rate,
            'customer_bank_name' => $request->input('customer_bank_name'),
            'customer_account_number' => $request->input('customer_account_number'),
            'customer_account_holder' => $request->input('customer_account_holder'),
        ]);

        // Save order items & deduct stock
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Deduct product stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear cart items
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('dashboard')->with('success', "Order placed successfully! Your order number is {$orderNumber}.");
    }
}
