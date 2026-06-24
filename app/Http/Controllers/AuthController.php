<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        $oldSessionId = session()->getId();

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Merge session cart to user cart
            $this->mergeSessionCart($oldSessionId, Auth::id());

            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $oldSessionId = session()->getId();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        Auth::login($user);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("WelcomeMail failed to send to {$user->email}: " . $e->getMessage());
        }

        // Merge session cart to user cart
        $this->mergeSessionCart($oldSessionId, $user->id);

        return redirect('/dashboard')->with('registered_success', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Merge guest session cart items into authenticated user cart.
     */
    private function mergeSessionCart($sessionId, $userId)
    {
        $sessionItems = CartItem::where('session_id', $sessionId)->get();

        foreach ($sessionItems as $item) {
            // Check if user already has this product in cart
            $userItem = CartItem::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->first();

            if ($userItem) {
                $newQuantity = $userItem->quantity + $item->quantity;
                // Cap quantity to product stock if available
                if ($item->product) {
                    $newQuantity = min($newQuantity, $item->product->stock);
                }
                $userItem->update(['quantity' => $newQuantity]);
                $item->delete();
            } else {
                $item->update([
                    'user_id' => $userId,
                    'session_id' => null,
                ]);
            }
        }
    }
}

