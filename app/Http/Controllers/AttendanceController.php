<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now()->toDateString();

        // Har student ka ek hi record per day
        $students = User::where('role', 'Student')->get();
        foreach ($students as $student) {
            Attendance::firstOrCreate(
                ['student_id' => $student->id, 'date' => $today],
                ['status' => 'absent', 'created_by' => $user->id]
            );
        }

        if ($user->role === 'Student') {
            $attendances = Attendance::where('student_id', $user->id)
                ->with('student')
                ->orderBy('date', 'desc')
                ->get();
        } else {
            $attendances = Attendance::with('student')
                ->orderBy('date', 'desc')
                ->get();
        }

        $chartData = $attendances->map(function ($att) {
            return [
                'name'   => $att->student->name ?? 'Unknown',
                'date'   => $att->date,
                'status' => $att->status,
            ];
        });

        return view('attendance.index', compact('attendances', 'students', 'user', 'chartData'));
    }

    public function store(Request $request)
    {
        if (!$request->has('attendance')) {
            return redirect()->back()->with('error', 'No attendance data submitted.');
        }

        foreach ($request->attendance as $data) {
            if (!isset($data['id'])) {
                continue;
            }

            // ✅ Update or Create to prevent duplicates
            Attendance::updateOrCreate(
                ['id' => $data['id']],
                [
                    'status'     => strtolower($data['status']),
                    'created_by' => auth()->id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }

    public function criteArea()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['Admin', 'Teacher'])) {
            return redirect()->route('dashboard')->with('error', 'Access denied!');
        }

        $attendances = Attendance::with('student')->orderBy('date', 'asc')->get();
        $students = User::where('role', 'Student')->get();

        $chartData = $attendances->map(function ($att) {
            return [
                'name'   => $att->student->name ?? 'Unknown',
                'date'   => $att->date,
                'status' => $att->status,
            ];
        });

        return view('attendance.crite', compact('attendances', 'students', 'user', 'chartData'));
    }

    public function calendar()
    {
        $user = Auth::user();

        $attendances = Attendance::with('student')->orderBy('date', 'asc')->get();
        $students = User::where('role', 'Student')->get();

        $chartData = $attendances->map(function ($att) {
            return [
                'name'   => $att->student->name ?? 'Unknown',
                'date'   => $att->date,
                'status' => $att->status,
            ];
        });

        return view('attendance.calendar', compact('attendances', 'students', 'user', 'chartData'));
    }

    public function exportCsv()
    {
        $filename = "attendance_report_" . date('Y-m-d') . ".csv";
        $attendances = Attendance::with('student')->get();

        $handle = fopen('php://output', 'w');
        ob_start();
        fputcsv($handle, ['Student Name', 'Email', 'Status', 'Date']);

        foreach ($attendances as $att) {
            fputcsv($handle, [
                $att->student->name,
                $att->student->email,
                ucfirst($att->status),
                $att->date
            ]);
        }

        fclose($handle);
        $content = ob_get_clean();

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=$filename");
    }

    public function exportPdf()
    {
        if (auth()->user()->email === 'admin@example.com') {
            $attendances = Attendance::with('student')->get();
        } else {
            $attendances = Attendance::with('student')
                ->where('student_id', auth()->id())
                ->get();
        }

        if ($attendances->isEmpty()) {
            return back()->with('error', 'No attendance record found.');
        }

        $pdf = \Pdf::loadView('attendance.report_pdf', compact('attendances'));
        return $pdf->download('attendance_report_' . date('Y-m-d') . '.pdf');
    }
}
