<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    /**
     * Show email input form.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Generate 6-digit code, save to DB, and send email.
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $code = mt_rand(100000, 999999);

        // Store hashed code in password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($code),
                'created_at' => now()
            ]
        );

        // Trigger email
        try {
            Mail::to($request->email)->send(new ResetCodeMail($code));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("ResetCodeMail failed to send to {$request->email}: " . $e->getMessage());
            return back()->with('error', 'Unable to send password reset code. Please try again later.');
        }

        return redirect()->route('password.verify', ['email' => $request->email])
            ->with('success', 'A 6-digit verification code has been sent to your email.');
    }

    /**
     * Show code verification form.
     */
    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code', compact('email'));
    }

    /**
     * Verify code against DB token.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // 15-minute expiration
        if (!$record || now()->subMinutes(15)->gt($record->created_at)) {
            return back()->withErrors(['code' => 'The code has expired or is invalid.']);
        }

        if (!Hash::check($request->code, $record->token)) {
            return back()->withErrors(['code' => 'The code has expired or is invalid.']);
        }

        // Keep in session for reset form authorization
        session()->put('reset_email', $request->email);
        session()->put('reset_code_verified', true);

        return redirect()->route('password.reset');
    }

    /**
     * Show password reset form.
     */
    public function showResetForm()
    {
        if (!session()->get('reset_code_verified') || !session()->get('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Please request a reset code first.');
        }

        $email = session()->get('reset_email');
        return view('auth.reset-password', compact('email'));
    }

    /**
     * Reset the user password and log in.
     */
    public function resetPassword(Request $request)
    {
        if (!session()->get('reset_code_verified') || !session()->get('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Please request a reset code first.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = session()->get('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User not found.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clean up reset token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Clear reset session variables
        session()->forget(['reset_email', 'reset_code_verified']);

        // Log the user in automatically
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Your password has been reset and you are now logged in.');
    }
}
