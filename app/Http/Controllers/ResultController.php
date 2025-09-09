<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'Admin' || $user->role == 'Teacher') {
            $results = Result::with('student')->latest()->get();
        } else {
            $results = Result::with('student')
                ->where('student_id', $user->id)
                ->latest()
                ->get();
        }

        return view('results.index', compact('results'));
    }

    public function create()
    {
        $students = User::where('role', 'Student')->get();
        return view('results.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'marks' => 'required|integer|min:0',
            'total_marks' => 'required|integer|min:1',
        ]);

        $percentage = ($request->marks / $request->total_marks) * 100;
        $grade = $this->calculateGrade($percentage);

        Result::create([
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'marks' => $request->marks,
            'total_marks' => $request->total_marks,
            'grade' => $grade,
        ]);

        return redirect()->back()->with('success', 'Result saved successfully!');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
}
