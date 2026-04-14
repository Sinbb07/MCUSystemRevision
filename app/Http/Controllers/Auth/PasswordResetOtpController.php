<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordResetOtpController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        // ✅ VALIDATION: Email must exist in tbl_users.user_Email
        $request->validate([
            'email' => [
                'required', 
                'email',
                'exists:tbl_users,user_Email'
            ]
        ]);

        // Get the user using user_Email column
        $user = User::where('user_Email', $request->email)->first();

        // Clean up expired OTPs for this user
        PasswordResetOtp::where('user_ID', $user->user_ID)
                       ->where('expires_at', '<', now())
                       ->orWhere('created_at', '<', now()->subHour())
                       ->delete();

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // ✅ SIMPLIFIED: Let MySQL handle the auto-increment, don't manually set ID
        PasswordResetOtp::create([
            'user_ID' => $user->user_ID,
            'user_Email' => $user->user_Email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send OTP email
        try {
            Mail::to($user->user_Email)->send(new PasswordResetOtpMail($user, $otp));
            Log::info("OTP sent to {$user->user_Email}");
        } catch (\Exception $e) {
            Log::error('OTP email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        return redirect()->route('password.otp.verify.form')->with([
            'success' => 'OTP has been sent to your email!',
            'email' => $request->email
        ]);
    }

    public function showVerifyOtpForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.send-otp');
    }

    public function verifyOtp(Request $request)
    {
        // Check if OTP comes from individual inputs or single field
        if ($request->has('otp1')) {
            // Combine individual OTP inputs
            $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;
        } else {
            $otp = $request->otp;
        }

        $request->merge(['otp' => $otp]);

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        $otpRecord = PasswordResetOtp::where('user_Email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
        }

        // Check attempts
        if ($otpRecord->attempts >= 5) {
            $otpRecord->delete();
            return back()->withErrors(['otp' => 'Too many failed attempts. Please request a new OTP.'])->withInput();
        }

        if ($otpRecord->otp !== $request->otp) {
            $otpRecord->incrementAttempts();
            $attemptsLeft = 5 - ($otpRecord->attempts + 1);
            return back()->withErrors(['otp' => "Invalid OTP. {$attemptsLeft} attempts left."])->withInput();
        }

        // Mark OTP as used
        $otpRecord->update(['used' => true]);

        // Set session for password reset
        session([
            'otp_verified' => true,
            'reset_user_id' => $otpRecord->user_ID,
            'reset_email' => $request->email,
            'reset_verified_at' => now()->toISOString()
        ]);

        return redirect()->route('password.reset')->with('success', 'OTP verified successfully!');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 
                'email',
                'exists:tbl_users,user_Email'
            ]
        ]);
        
        // Get user using user_Email column
        $user = User::where('user_Email', $request->email)->first();
        
        // Delete existing OTPs
        PasswordResetOtp::where('user_ID', $user->user_ID)->delete();
        
        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // ✅ SIMPLIFIED: Let MySQL handle the auto-increment
        PasswordResetOtp::create([
            'user_ID' => $user->user_ID,
            'user_Email' => $user->user_Email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send email
        try {
            Mail::to($user->user_Email)->send(new PasswordResetOtpMail($user, $otp));
            Log::info("Resent OTP to {$user->user_Email}");
        } catch (\Exception $e) {
            Log::error('Resend OTP email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to resend OTP. Please try again.']);
        }

        return back()->with('success', 'New OTP has been sent to your email!');
    }
}