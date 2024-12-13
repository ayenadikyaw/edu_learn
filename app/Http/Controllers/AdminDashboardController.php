<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentEnrolled;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AdminDashboard');
    }

    public function getTotalAdmins()
    {
        $totalAdmins = User::where('role', 'admin')->count();
        return response()->json(['totalAdmins' => $totalAdmins]);
    }

    public function getTotalStudents()
    {
        $totalStudents = User::where('role', 'user')->count();
        return response()->json(['totalStudents' => $totalStudents]);
    }

    public function getTotalCourses()
    {
        $totalCourses = Course::where('status', 1)->count();
        return response()->json(['totalCourses' => $totalCourses]);
    }

    public function getTotalEnrollments()
    {
        $totalEnrollments = StudentEnrolled::count();
        return response()->json(['totalEnrollments' => $totalEnrollments]);
    }

    public function getTotalStudentsByMonth()
    {
        $totalStudentsByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        return response()->json(['totalStudentsByMonth' => $totalStudentsByMonth]);
    }

    public function getTotalCoursesByCategory()
    {
        try {
            $totalCoursesByCategory = Course::with('CourseCategory')
                ->select('category_id', FacadesDB::raw('COUNT(*) as count'))
                ->where('status', 1)
                ->groupBy('category_id')
                ->get()
                ->map(function ($course) {
                    return [
                        'category' => $course->CourseCategory ? $course->CourseCategory->name : 'Uncategorized',
                        'count' => $course->count
                    ];
                });
            
            return response()->json(['totalCoursesByCategory' => $totalCoursesByCategory]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTotalEnrollmentsByMonth()
    {
        $totalEnrollmentsByMonth = StudentEnrolled::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        return response()->json(['totalEnrollmentsByMonth' => $totalEnrollmentsByMonth]);
    }
}
