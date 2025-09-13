<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/verify-otp-reset', [ForgotPasswordController::class, 'verifyOtpReset']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Protected routes with session authentication
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Course routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/courses/{id}/lectures', [CourseController::class, 'lectures']);
    Route::get('/lectures', [CourseController::class, 'userLectures']);
    Route::get('/lectures/{id}', [CourseController::class, 'showLecture']);
    Route::post('/courses/mark-complete', [CourseController::class, 'markComplete']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    // Route::post('/profile/update', [ProfileController::class, 'update']);
    // Route::post('/profile/picture', [ProfileController::class, 'updatePicture']);

    // Results routes
    Route::get('/results', [ResultController::class, 'index']);
    Route::post('/results', [ResultController::class, 'store']);
});
// routes/api.php

// use App\Http\Controllers\ProfileController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture']);
    Route::post('/profile/update', [ProfileController::class, 'updateAccount']);
});

// Auth check route
Route::get('/auth/check', function () {
    return response()->json(['authenticated' => auth()->check()]);
})->middleware('web');
