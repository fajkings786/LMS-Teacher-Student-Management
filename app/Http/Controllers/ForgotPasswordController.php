<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordOtp;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();
            // Send OTP email
            Mail::to($user->email)->send(new ForgotPasswordOtp($otp));
            // Return JSON
            return response()->json([
                'message' => 'OTP sent! Check your email.',
                'redirect' => '/verify-otp-reset?email=' . urlencode($user->email),
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Send OTP error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
        }
    }

    public function verifyOtpReset(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|numeric',
                'email' => 'required|email'
            ]);

            $user = User::where('email', $request->email)
                ->where('otp_code', $request->otp)
                ->first();

            if (!$user) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            // Check if OTP has expired - Fixed this part
            if (!$user->otp_expires_at || Carbon::now()->isAfter($user->otp_expires_at)) {
                return response()->json(['message' => 'OTP expired'], 400);
            }

            // Clear OTP
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            return response()->json([
                'message' => 'OTP verified successfully!',
                'success' => true,
                'redirect' => '/reset-password-form?email=' . urlencode($user->email)
            ]);
        } catch (\Exception $e) {
            Log::error('Verify OTP error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to verify OTP. Please try again.'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:6|confirmed',
                'email' => 'required|email'
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => 'Password reset successful! Please login.',
                'redirect' => '/login'
            ]);
        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to reset password. Please try again.'], 500);
        }
    }
}
