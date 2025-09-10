<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // app/Http/Controllers/DashboardController.php
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access dashboard');
        }

        $user = Auth::user();

        return response()
            ->view('dashboard', compact('user'))
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }
}
