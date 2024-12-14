<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\{
    AdminDashboardController,
    Auth\VerifyEmailController,
    CourseController,
    HomePageController,
    LessonController,
    ProfileController,
    StudentController,
    StudentDasbhoardController,
    StudentEnrollController
};
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

// Public routes
Route::group([], function () {
    Route::get('/', fn() => Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]));

    Route::get('/about-us', fn() => Inertia::render('AboutUs'));
    Route::get('/contact-us', fn() => Inertia::render('ContactUs'));
    Route::get('/courses/getCourses', [CourseController::class, 'getCourses'])->name('courses.getCourses');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

    Route::get('/total-students', [HomePageController::class, 'getTotalStudents']);
    Route::get('/total-courses', [HomePageController::class, 'getTotalCourses']);
    Route::get('/total-categories', [HomePageController::class, 'getTotalCategories']);
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin', fn() => Inertia::render('Admin/AdminDashboard'))->name('admin.dashboard');
        Route::get('/admin/manage-courses', [CourseController::class, 'adminManageCourses'])->name('admin.manage-courses');
        Route::get('/admin/add-course', fn() => Inertia::render('Admin/AddCourse'));
        Route::post('/admin/add-course', [CourseController::class, 'store'])->name('admin.add-course');
        Route::get('/admin/edit-course/{course}', [CourseController::class, 'edit'])->name('admin.edit-course');
        Route::match(['PUT', 'POST'], '/admin/update-course/{course}', [CourseController::class, 'update'])->name('admin.update-course');
        Route::delete('/admin/delete-course/{course}', [CourseController::class, 'destroy'])->name('admin.delete-course');
        Route::put('/admin/publish-course/{course}', [CourseController::class, 'publish'])->name('admin.publish-course');
        Route::get('/admin/manage-students', [StudentController::class, 'index'])->name('admin.manage-students');
        Route::delete('/admin/delete-student/{student}', [StudentController::class, 'destroy'])->name('admin.delete-student');
        //lessons routes
        Route::get('/admin/add-lesson/{course}', [LessonController::class, 'create'])->name('admin.add-lesson');
        Route::post('/admin/add-lesson/{course}', [LessonController::class, 'store'])->name('admin.add-lesson');
        Route::get('/admin/edit-lesson/{lesson}', [LessonController::class, 'edit'])->name('admin.edit-lesson');
        Route::match(['PUT', 'POST'], '/admin/update-lesson/{lesson}', [LessonController::class, 'update'])->name('admin.update-lesson');
        Route::delete('/admin/delete-lesson/{lesson}', [LessonController::class, 'destroy'])->name('admin.delete-lesson');

        //dashboard routes
        Route::get('/admin/dashboard/total-students', [AdminDashboardController::class, 'getTotalStudents'])->name('admin.dashboard.total-students');
        Route::get('/admin/dashboard/total-enrollments', [AdminDashboardController::class, 'getTotalEnrollments'])->name('admin.dashboard.total-enrollments');
        Route::get('/admin/dashboard/total-courses', [AdminDashboardController::class, 'getTotalCourses'])->name('admin.dashboard.total-courses');
        Route::get('/admin/dashboard/total-students-by-month', [AdminDashboardController::class, 'getTotalStudentsByMonth'])->name('admin.dashboard.total-students-by-month');
        Route::get('/admin/dashboard/total-enrollments-by-month', [AdminDashboardController::class, 'getTotalEnrollmentsByMonth'])->name('admin.dashboard.total-enrollments-by-month');
        Route::get('/admin/dashboard/total-courses-by-category', [AdminDashboardController::class, 'getTotalCoursesByCategory'])->name('admin.dashboard.total-courses-by-category');
        Route::get('/admin/dashboard/total-admins', [AdminDashboardController::class, 'getTotalAdmins'])->name('admin.dashboard.total-admins');
    });

    // User routes
    Route::middleware(UserMiddleware::class)->group(function () {
        Route::get('/user', [StudentDasbhoardController::class, 'index'])->name('user.dashboard');
        Route::get('/courses/{course}', [StudentController::class, 'learningPage'])->name('courses.learningPage');
        Route::post('/courses/{course}/enroll', [StudentEnrollController::class, 'enroll'])->name('courses.enroll');
        Route::get('/enrolled-courses', [StudentEnrollController::class, 'getEnrolledCourses'])->name('enrolled-courses');
        Route::get('/enrolled-courses/{course}', [StudentEnrollController::class, 'checkEnrollment'])->name('enrolled-courses.check');

        //student dashboard routes
        Route::get('/student-dashboard', [StudentDasbhoardController::class, 'index'])->name('student.dashboard');
        Route::get('/student-dashboard/latest-course', [StudentDasbhoardController::class, 'getlatestCourse'])->name('student.dashboard.latest-course');
        Route::get('/student-dashboard/completed-courses', [StudentDasbhoardController::class, 'completedCourses'])->name('student.dashboard.completed-courses');
        Route::get('/student-dashboard/enrolled-courses', [StudentDasbhoardController::class, 'enrolledCourses'])->name('student.dashboard.enrolled-courses');
        Route::get('/student-dashboard/recommended-courses', [StudentDasbhoardController::class, 'recommendedCourses'])->name('student.dashboard.recommended-courses');
    });

    // Shared authenticated routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email verification routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => Inertia::render('Auth/VerifyEmail'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', fn(Request $request) => $request->fulfill())->name('verification.verify')->middleware('signed');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->name('verification.send')->middleware('throttle:6,1');
});

// Route::get('/debug', function () {
//     dd(auth()->user());
// });

require __DIR__ . '/auth.php';
