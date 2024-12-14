<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentEnrolled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentDasbhoardController extends Controller
{
    public function index()
    {
        $enrolledCourses = StudentEnrolled::where('student_enrolled.user_id', Auth::user()->id)
            ->join('courses', 'student_enrolled.course_id', '=', 'courses.id')
            ->select('courses.*')
            ->paginate(3);
        return Inertia::render('User/Dashboard', [
            'enrolledCourses' => $enrolledCourses
        ]);
    }
    public function getlatestCourse()
    {
        $course = StudentEnrolled::where('student_enrolled.user_id', Auth::user()->id)
            ->join('courses', 'student_enrolled.course_id', '=', 'courses.id')
            ->select('courses.*')
            ->latest('student_enrolled.created_at')
            ->take(1)
            ->get();
        return response()->json($course);
    }

    public function completedCourses()
    {
        $completedCourse = StudentEnrolled::where('student_enrolled.user_id', Auth::user()->id)
            ->join('courses', 'student_enrolled.course_id', '=', 'courses.id')
            ->where('student_enrolled.is_completed', 1)
            ->select('courses.*')
            ->get();
        return response()->json($completedCourse);
    }



    public function recommendedCourses()
    {
        $recommendedCourses = Course::where('status', 'popular')->take(6)->get();
        return response()->json($recommendedCourses);
    }
}
