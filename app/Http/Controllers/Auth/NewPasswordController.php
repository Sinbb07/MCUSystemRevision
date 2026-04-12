<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        // Check if OTP was verified
        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Please verify OTP first.']);
        }

        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        // Check if OTP was verified
        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'OTP verification required.']);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find user from session
        $user = User::where('user_ID', session('reset_user_id'))->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->update([
            'user_Password' => Hash::make($request->password)
        ]);

        // Clear session
        session()->forget(['otp_verified', 'reset_user_id', 'reset_email', 'reset_verified_at']);

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }
}
