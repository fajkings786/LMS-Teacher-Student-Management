<?php

namespace App\Http\Controllers;

use App\Mail\UserApprovedMail;
use App\Mail\UserRejectedMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // Dashboard - accessible to all authenticated users
    public function dashboard(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // Admin dashboard
        if ($user->role === 'Admin') {
            return view('dashboard', [
                'user' => $user,
                'pendingCount' => User::where('status', 'pending')->count(),
                'approvedCount' => User::where('status', 'approved')->count()
            ]);
        }

        // Teacher dashboard
        if ($user->role === 'Teacher') {
            return view('dashboard', [
                'user' => $user,
                'studentCount' => User::where('role', 'Student')->count(),
                'courseCount' => \App\Models\Course::where('teacher_id', $user->id)->count()
            ]);
        }

        // Student dashboard
        if ($user->role === 'Student') {
            return view('dashboard', [
                'user' => $user,
                'courseCount' => \App\Models\Course::where('student_id', $user->id)->count(),
                'completedCount' => \App\Models\CourseProgress::where('user_id', $user->id)->where('status', 'completed')->count()
            ]);
        }

        // Fallback for any other roles
        return view('dashboard', [
            'user' => $user
        ]);
    }

    // ✅ Pending Users Page - Admin only
    public function pendingUsers()
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $pendings = User::where('status', 'pending')->get();
        return view('admin.pending-users', compact('pendings'));
    }

    // ✅ Approve Pending User - Admin only
    public function approvePending($id)
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        // Send Approved Email
        Mail::to($user->email)->send(new UserApprovedMail($user));

        // Redirect back to pending users page
        return back()->with('success', 'User Approved & Email Sent ✅');
    }

    // ✅ Reject Pending User - Admin only
    public function rejectPending($id)
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $email = $user->email;
        $user->delete();

        // Send Rejected Email
        Mail::to($email)->send(new UserRejectedMail($email));

        // Redirect back to pending users page
        return back()->with('error', 'User Rejected & Email Sent ❌');
    }

    // ✅ Show All Users - Admin only
    public function indexUsers()
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // ✅ Edit User - Admin only
    public function editUser($id)
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    // ✅ Update User - Admin only
    public function updateUser(Request $request, $id)
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role' => 'required|in:Admin,Teacher,Student',
            'status' => 'required|in:pending,approved',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        if ($request->status === 'approved') {
            Mail::to($user->email)->send(new UserApprovedMail($user));
        }

        // Redirect to users list
        return redirect()->route('admin.users')->with('success', 'User updated successfully ✅');
    }

    // ✅ Delete User - Admin only
    public function destroyUser($id)
    {
        // Check if user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $email = $user->email;
        $user->delete();

        Mail::to($email)->send(new UserRejectedMail($email));

        // Redirect to users list
        return redirect()->route('admin.users')->with('success', 'User deleted ❌');
    }
}
