<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;

// Sanctum CSRF route
Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);

// Auth routes - using web middleware
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');

// Dashboard route - using auth middleware
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Admin only routes - fixed middleware
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    // Pending Users
    Route::get('/pending-users', [AdminController::class, 'pendingUsers'])->name('admin.pendingUsers');
    Route::post('/pending-users/approve/{id}', [AdminController::class, 'approvePending'])->name('admin.pending.approve');
    Route::post('/pending-users/reject/{id}', [AdminController::class, 'rejectPending'])->name('admin.pending.reject');

    // All Users
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('admin.users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

// Course routes
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('add.course');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/my-lectures', [CourseController::class, 'studentLectures'])->name('student.lectures');
});

// Attendance routes
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/crite', [AttendanceController::class, 'criteArea'])->name('attendance.crite');
    Route::get('/attendance/calendar', [AttendanceController::class, 'calendar'])->name('attendance.calendar');
    Route::get('/attendance/export/csv', [AttendanceController::class, 'exportCsv'])->name('attendance.export.csv');
    Route::get('/attendance/export/pdf', [AttendanceController::class, 'exportPdf'])->name('attendance.export.pdf');
});

// Results routes
Route::middleware(['auth'])->group(function () {
    Route::get('/results/create', [ResultController::class, 'create'])->name('results.create');
    Route::post('/results/store', [ResultController::class, 'store'])->name('results.store');
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
});

// OTP routes
Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
Route::get('/verify-otp/{email}', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');

// Forgot password routes
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('forgot.password');
Route::post('/verify-otp-reset', [ForgotPasswordController::class, 'verifyOtpReset'])->name('verify.otp.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');

// Home page route
Route::get('/', function () {
    return view('welcome');
});

// Catch-all route for SPA (Vue Router) - excluding API routes
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api|dashboard|_ignition).*$');
