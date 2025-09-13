<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Create form
    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('courses.create', compact('students'));
    }

    // Store course
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'student_id' => 'required|exists:users,id',
            'video'      => 'nullable|mimes:mp4,mkv,avi|max:30000',
            'youtube_url' => 'nullable|url'
        ]);

        // Validate that at least one of video or youtube_url is provided
        if (!$request->hasFile('video') && !$request->filled('youtube_url')) {
            return redirect()->back()
                ->withErrors(['video' => 'Either video file or YouTube URL is required'])
                ->withInput();
        }

        $videoPath = null;
        $youtubeUrl = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lectures', 'public');
        }

        if ($request->filled('youtube_url')) {
            $youtubeUrl = $this->convertToEmbedUrl($request->youtube_url);
        }

        Course::create([
            'name'        => $request->name,
            'student_id'  => $request->student_id,
            'teacher_id'  => Auth::id(),
            'video_path'  => $videoPath, // This can be null now
            'youtube_url' => $youtubeUrl,
        ]);

        return redirect()->back()->with('success', 'Course with lecture uploaded successfully!');
    }

    // Student lectures
    public function studentLectures()
    {
        $lectures = Course::with('teacher')
            ->where('student_id', auth()->id())
            ->get();

        foreach ($lectures as $lecture) {
            $progress = CourseProgress::where('course_id', $lecture->id)
                ->where('user_id', auth()->id())
                ->first();
            $lecture->status = $progress ? $progress->status : 'pending';
        }

        return view('courses.student', compact('lectures'));
    }

    // Mark as complete
    public function markComplete(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        CourseProgress::updateOrCreate(
            [
                'course_id' => $request->course_id,
                'user_id'   => auth()->id(),
            ],
            [
                'status' => 'completed',
            ]
        );

        return response()->json(['success' => true]);
    }

    // All students (for teacher)
    public function allStudents()
    {
        $students = User::where('role', 'student')
            ->withCount(['courses as total_courses'])
            ->withCount(['courses as completed_courses' => function ($query) {
                $query->whereHas('progress', function ($q) {
                    $q->where('status', 'completed');
                });
            }])
            ->get();

        return view('courses.teacher.students', compact('students'));
    }

    // Get courses for the authenticated user (API)
    public function index()
    {
        $user = Auth::user();
        
        // If the user is a student, get their courses
        if ($user->role === 'Student') {
            $courses = Course::with('teacher')
                ->where('student_id', $user->id)
                ->get();
        } else {
            // For teachers or admins, return all courses they created
            $courses = Course::with('student')
                ->where('teacher_id', $user->id)
                ->get();
        }
        
        // Attach progress status for students
        if ($user->role === 'Student') {
            foreach ($courses as $course) {
                $progress = CourseProgress::where('course_id', $course->id)
                    ->where('user_id', $user->id)
                    ->first();
                $course->status = $progress ? $progress->status : 'pending';
            }
        }
        
        return response()->json($courses);
    }

    public function userLectures()
    {
        $lectures = Course::with('teacher') // Changed from 'Admin' to 'teacher'
            ->where('student_id', auth()->id())
            ->get();

        foreach ($lectures as $lecture) {
            $progress = CourseProgress::where('course_id', $lecture->id)
                ->where('user_id', auth()->id())
                ->first();
            $lecture->status = $progress ? $progress->status : 'pending';
        }

        return response()->json($lectures);
    }

    // Single student lectures (for teacher)
    public function studentCourses($studentId)
    {
        $student = User::findOrFail($studentId);
        $lectures = Course::with('teacher', 'progress')
            ->where('student_id', $studentId)
            ->get();

        return view('courses.teacher.student_lectures', compact('student', 'lectures'));
    }

    // Helper function to convert YouTube URL to embed format
    private function convertToEmbedUrl($url)
    {
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1];
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1];
        }
        return $url;
    }

    public function lectures()
    {
        // Fetch all courses with teacher relation (who uploaded)
        $courses = Course::with('teacher')->get();
        return response()->json($courses);
    }
    
    // Show a single course
    public function show($id)
    {
        $course = Course::with(['teacher', 'student'])->findOrFail($id);
        return response()->json($course);
    }
    
    // Get lectures for a specific course
    public function courseLectures($id)
    {
        $course = Course::with(['teacher', 'student'])->findOrFail($id);
        
        // For students, check if this is their course
        if (Auth::user()->role === 'Student' && $course->student_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get progress for this course
        $progress = CourseProgress::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->first();
            
        $course->status = $progress ? $progress->status : 'pending';
        
        return response()->json([$course]); // Return as array for consistency
    }
}