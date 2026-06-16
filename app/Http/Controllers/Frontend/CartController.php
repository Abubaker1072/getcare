<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get the identifying attributes (user_id or session_id) for cart queries.
     */
    protected function getCartIdentifiers()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id()];
        }
        return ['session_id' => session()->getId()];
    }

    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        $identifiers = $this->getCartIdentifiers();
        $cartItems = CartItem::where($identifiers)->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingActive = \App\Models\StoreSetting::getValue('shipping_is_active', '1') === '1';
        $shippingFee = 0;
        if ($subtotal > 0 && $shippingActive) {
            $shippingFee = (float) \App\Models\StoreSetting::getValue('shipping_fee', 150);
        }
        $total = $subtotal + $shippingFee;

        return view('pages.cart', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $identifiers = $this->getCartIdentifiers();

        // Check stock
        if ($product->stock < $request->quantity) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Not enough stock available.'], 400);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        // Find existing cart item for this session/user & product
        $cartItem = CartItem::where($identifiers)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Cannot add more items. Stock limit reached.'], 400);
                }
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = CartItem::create(array_merge($identifiers, [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $identifiers = $this->getCartIdentifiers();
        $cartItem = CartItem::where($identifiers)->where('id', $id)->firstOrFail();
        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Not enough stock available.'], 400);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $identifiers = $this->getCartIdentifiers();
        $cartItem = CartItem::where($identifiers)->where('id', $id)->firstOrFail();
        $cartItem->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    /**
     * Get dynamic summary JSON for the drawer/header count.
     */
    public function getSummary()
    {
        $identifiers = $this->getCartIdentifiers();
        $cartItems = CartItem::where($identifiers)->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingActive = \App\Models\StoreSetting::getValue('shipping_is_active', '1') === '1';
        $shippingFee = 0;
        if ($subtotal > 0 && $shippingActive) {
            $shippingFee = (float) \App\Models\StoreSetting::getValue('shipping_fee', 150);
        }
        $total = $subtotal + $shippingFee;

        $items = $cartItems->map(function ($item) {
            $convertedPrice = \App\Helpers\CurrencyHelper::convert($item->product->price);
            return [
                'id' => $item->id,
                'product_id' => $item->product->id,
                'name' => $item->product->name,
                'slug' => $item->product->slug,
                'price' => (float) $convertedPrice,
                'formatted_price' => \App\Helpers\CurrencyHelper::format($item->product->price),
                'quantity' => $item->quantity,
                'total_price' => (float) ($convertedPrice * $item->quantity),
                'formatted_total_price' => \App\Helpers\CurrencyHelper::format($item->product->price * $item->quantity),
                'image_url' => $item->product->cover_image || $item->product->image
                    ? asset('storage/' . ($item->product->cover_image ?? $item->product->image))
                    : 'https://via.placeholder.com/150',
            ];
        });

        return response()->json([
            'items' => $items,
            'cart_count' => $cartItems->sum('quantity'),
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'formatted_subtotal' => \App\Helpers\CurrencyHelper::format($subtotal),
            'formatted_shipping_fee' => \App\Helpers\CurrencyHelper::format($shippingFee),
            'formatted_total' => \App\Helpers\CurrencyHelper::format($total),
        ]);
    }

    /**
     * Helper to fetch total quantity count.
     */
    protected function getCartCount()
    {
        $identifiers = $this->getCartIdentifiers();
        return CartItem::where($identifiers)->sum('quantity');
    }
}
