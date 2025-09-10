<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // 👈 yeh line add karni hai

class StrictDashboardProtection
{
    public function handle(Request $request, Closure $next)
    {
        Log::debug('StrictDashboard check - auth=' . (Auth::check() ? '1' : '0') . ' user_id=' . Auth::id() . ' session_id=' . $request->session()->getId());

        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect('/login')->with('error', 'Please login to access dashboard');
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
