<?php

namespace App\Http\Controllers;

use App\Events\CourseEnrolled;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\StudentEnrolled;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\CourseEnrolledNotification;

class StudentEnrollController extends Controller
{
    public function enroll(Course $course)
    {
        // Check if user is already enrolled in this course
        $existingEnrollment = StudentEnrolled::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.show', $course->id)
                ->with('error', 'You are already enrolled in this course.');
        }

        $studentEnrolled = new StudentEnrolled();
        $studentEnrolled->user_id = Auth::user()->id;
        $studentEnrolled->course_id = $course->id;
        $studentEnrolled->save();

        // notify all users that a new course has been created
        event(new CourseEnrolled($course, Auth::user()));
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CourseEnrolledNotification($course, Auth::user()));
        }
        return redirect()->route('courses.show', $course->id)
            ->with('success', 'You have enrolled in this course successfully!');
    }

    public function getEnrolledCourses()
    {
        $enrolledCourses = StudentEnrolled::where('user_id', Auth::user()->id)->get();
        return response()->json($enrolledCourses);
    }

    public function checkEnrollment(Course $course)
    {
        $enrolledCourses = StudentEnrolled::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->first();
        return response()->json($enrolledCourses);
    }
}
