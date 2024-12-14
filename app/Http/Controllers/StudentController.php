<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentEnrolled;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'user')->withCount('enrollments')->get();
        return Inertia::render('Admin/ManageStudents', [
            'students' => $students
        ]);
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->back()->with('success', 'Student deleted successfully');
    }

    public function learningPage(Course $course)
    {
        $enrolledCourse = StudentEnrolled::where('course_id', $course->id)
            ->where('user_id', Auth::user()->id)
            ->with('course.lessons')
            ->first();

        return Inertia::render('User/LearningPage', [
            'course' => $enrolledCourse,
        ]);
    }

    public function courseComplete(Course $course)
    {
        $enrolledCourse = StudentEnrolled::where('course_id', $course->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        $enrolledCourse->is_completed = 1;
        $enrolledCourse->save();
        return response()->json(['completed' => $enrolledCourse->is_completed]);
    }
}
