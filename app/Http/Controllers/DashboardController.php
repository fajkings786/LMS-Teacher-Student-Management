<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // اگر صارف لاگ ان نہیں ہے تو لاگ ان صفحے پر ریڈائرکٹ کریں
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // کیشنگ روکنے کے لیے ہیڈر سیٹ کریں
        return response()->view('dashboard')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}