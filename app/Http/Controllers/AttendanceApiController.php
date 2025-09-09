<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceApiController extends Controller
{
    // 1. Get all attendances
    public function index()
    {
        $attendances = Attendance::with('student')->orderBy('date', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $attendances
        ]);
    }

    // 2. Mark or update today's attendance
    public function store(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array'
        ]);

        $today = now()->format('Y-m-d');
        $userId = Auth::id();

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $student_id, 'date' => $today],
                ['status' => $status, 'created_by' => $userId]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance marked for today'
        ]);
    }

    // 3. Attendance chart/data for all students
    public function chart()
    {
        $attendances = Attendance::with('student')->orderBy('date', 'asc')->get();
        $chartData = [];

        foreach ($attendances as $att) {
            $chartData[] = [
                'name' => $att->student->name,
                'date' => $att->date,
                'status' => $att->status
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $chartData
        ]);
    }

    // 4. Get attendance of specific student
    public function studentAttendance($id)
    {
        $student = User::findOrFail($id);

        if ($student->role !== 'Student') {
            return response()->json([
                'status' => 'error',
                'message' => 'User is not a student'
            ], 400);
        }

        $attendances = Attendance::where('student_id', $id)->orderBy('date', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'student' => $student->name,
            'data' => $attendances
        ]);
    }
}
