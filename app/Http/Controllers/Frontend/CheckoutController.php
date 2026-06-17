<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

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

        $bankDetail = \App\Models\UserBankDetail::where('user_id', auth()->id())->first();

        return view('pages.checkout', compact(
            'cartItems', 'subtotal', 'shippingFee', 'total',
            'codActive', 'codDescription', 'bankActive', 'bankDetails', 'bankDetail'
        ));
    }

    /**
     * Handle order submission.
     */
    public function placeOrder(Request $request, \App\Services\PaymentProcessingService $paymentService)
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

        $codActive = \App\Models\StoreSetting::getValue('cod_is_active', '1') === '1';

        if ($request->input('payment_method') === 'bank') {
            $rules['customer_bank_name'] = 'required|string|max:255';
            $rules['customer_account_number'] = 'required|string|max:255';
            $rules['customer_account_holder'] = 'required|string|max:255';
            
            // Expiry and CVC are only mandatory/validated if Cash on Delivery is disabled (OFF)
            if (!$codActive) {
                $rules['customer_cvc'] = 'required|string|max:4';
                $rules['customer_expiry_date'] = 'required|string|max:10';
            }
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

        // Wrap order placement in a DB transaction
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
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

            // If cash on delivery is off, process the direct payment gateway
            if ($request->payment_method === 'bank' && !$codActive) {
                $paymentData = [
                    'customer_bank_name' => $request->input('customer_bank_name'),
                    'customer_account_number' => $request->input('customer_account_number'),
                    'customer_account_holder' => $request->input('customer_account_holder'),
                    'customer_cvc' => $request->input('customer_cvc'),
                    'customer_expiry_date' => $request->input('customer_expiry_date'),
                ];

                // Execute the balance processing logic
                $paymentResult = $paymentService->processPayment($total, $paymentData, $order->id);

                if (!$paymentResult['success']) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    return redirect()->back()->withInput()->with('insufficient_balance', $paymentResult['message']);
                }

                // If transaction is successful, mark order payment_status as paid
                $order->update(['payment_status' => 'paid']);
            }

            if ($request->payment_method === 'bank') {
                \App\Models\UserBankDetail::updateOrCreate(
                    ['user_id' => auth()->id()],
                    [
                        'bank_name' => $request->input('customer_bank_name'),
                        'account_number' => $request->input('customer_account_number'),
                        'account_holder_name' => $request->input('customer_account_holder'),
                        'cvc' => $request->input('customer_cvc'),
                        'expiry_date' => $request->input('customer_expiry_date'),
                    ]
                );
            }

            \Illuminate\Support\Facades\DB::commit();

            // Clear cart items
            CartItem::where('user_id', auth()->id())->delete();

            // Send order confirmation email
            try {
                if ($order->user) {
                    Mail::to($order->user->email)->send(new OrderPlacedMail($order));
                }
            } catch (\Exception $mailEx) {
                \Illuminate\Support\Facades\Log::warning("OrderPlacedMail failed to send for order {$orderNumber}: " . $mailEx->getMessage());
            }

            return redirect()->route('dashboard')->with('success', "Order placed successfully! Your order number is {$orderNumber}.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while placing your order: ' . $e->getMessage());
        }
    }
}
