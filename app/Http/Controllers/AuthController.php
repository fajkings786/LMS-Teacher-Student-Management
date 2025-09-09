<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ✅ Register + Send OTP
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $otp = rand(100000, 999999);
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'status'      => 'pending',   // approval admin karega
            'role'        => 'Student',
            'otp_code'    => $otp,
            'is_verified' => false,
        ]);

        Mail::to($user->email)->send(new OtpMail($user, $otp));

        return response()->json([
            'message'  => 'OTP sent! Check your email.',
            'redirect' => route('otp.verify.form', ['email' => $user->email])
        ], 201);
    }

    // ✅ Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp_code != $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }

        $user->is_verified = true;
        $user->otp_code = null; // OTP clear
        $user->save();

        return response()->json([
            'message'  => 'OTP verified! Wait for admin approval.',
            'redirect' => route('login')
        ]);
    }

    // ✅ Login - Updated for session authentication
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        if (!$user->is_verified) {
            Auth::logout();
            return response()->json(['error' => 'Please verify your email OTP first'], 403);
        }

        if ($user->role !== 'Admin' && $user->status === 'pending') {
            Auth::logout();
            return response()->json(['error' => 'Your account is pending admin approval'], 403);
        }

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status,
                'picture' => $user->picture ?? null
            ],
            'redirect' => '/dashboard'
        ]);
    }

    // ✅ Logout - Updated for session authentication
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['redirect' => '/']);
    }


    // ✅ Approved Users List
    public function approved()
    {
        $users = User::where('status', 'approved')->get();
        return view('ApprovedUsers', compact('users'));
    }
}
