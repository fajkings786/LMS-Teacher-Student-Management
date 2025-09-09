<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResultController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/verify-otp-reset', [ForgotPasswordController::class, 'verifyOtpReset']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Protected routes with session authentication
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/lectures', [CourseController::class, 'userLectures']);
    Route::post('/courses/mark-complete', [CourseController::class, 'markComplete']);
    Route::get('/results', [ResultController::class, 'index']);
    Route::post('/results', [ResultController::class, 'store']);
});
