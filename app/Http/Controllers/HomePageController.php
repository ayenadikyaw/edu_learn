<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function getTotalStudents()
    {
        $totalStudents = User::where('role', 'user')->count(); //students
        return response()->json($totalStudents);
    }

    public function getTotalCourses()
    {
        $totalCourses = Course::where('status', 1)->count(); //published
        return response()->json($totalCourses);
    }

    public function getTotalCategories()
    {
        $totalCategories = CourseCategory::count();
        return response()->json($totalCategories);
    }
}
