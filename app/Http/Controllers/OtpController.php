<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpController extends Controller
{
    // Show OTP form
    public function showVerifyForm($email)
    {
        return view('auth.verify-otp', compact('email'));
    }

    // Verify OTP
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpInput = trim($request->otp);

        $user = User::where('email', $request->email)
            ->where('otp_code', $otpInput)
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        $user->update([
            'is_verified' => true,
            'otp_code' => null,
        ]);

        return redirect()->route('login')->with('success', 'OTP verified! You can now login.');
    }

    // Send OTP email

    public static function sendOtp(User $user)
    {
        $otp = rand(100000, 999999);
        $user->update(['otp_code' => $otp]);

        // First OTP bhi HTML blade template ke through send karo
        Mail::to($user->email)->send(new OtpMail($user, $otp));
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        self::sendOtp($user);

        return back()->with('success', 'A new OTP has been sent to your email!');
    }
}
