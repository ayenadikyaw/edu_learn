<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentEnrolled;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('User/LearningPage', [
            'course' => $course
        ]);
    }
}
