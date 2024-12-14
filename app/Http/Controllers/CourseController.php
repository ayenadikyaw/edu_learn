<?php

namespace App\Http\Controllers;

use App\Events\CourseCreate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCourseNotification;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Course $course)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|array',
            'category.*' => 'integer',
            'level' => 'nullable|array',
            'level.*' => 'integer',
            'duration' => 'nullable|array',
            'duration.*' => 'integer',
        ]);
    
        try {
            // Base query
            $query = Course::where('status', 1)->with('lessons');
    
            // Apply search filter
            if (!empty($validated['search'])) {
                $query->where('title', 'like', '%' . $validated['search'] . '%');
            }
    
            // Apply category filter
            if (!empty($validated['category'])) {
                $query->whereIn('category_id', $validated['category']);
            }
    
            // Apply level filter
            if (!empty($validated['level'])) {
                $query->whereIn('level_id', $validated['level']);
            }
    
            // Apply duration filter
            if (!empty($validated['duration'])) {
                $query->where(function ($q) use ($validated) {
                    foreach ($validated['duration'] as $duration) {
                        switch ($duration) {
                            case "1": // Short duration
                                $q->orWhere('duration', '<=', 2);
                                break;
                            case "2": // Medium duration
                                $q->orWhereBetween('duration', [3, 6]);
                                break;
                            case "3": // Long duration
                                $q->orWhere('duration', '>=', 7);
                                break;
                        }
                    }
                });
            }
    
            // Paginate the results
            $courses = $query->paginate(9);
    
            // Return results with filters
            return Inertia::render('Course/courses', [
                'courses' => $courses,
                'filters' => $request->only(['search', 'category', 'level', 'duration'])
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Course fetch error: ', ['message' => $e->getMessage()]);
    
            return redirect()->route('courses.index')->with('error', 'An error occurred while fetching courses.');
        }
    }
    



    public function adminManageCourses()
    {
        $courses = Course::with('lessons')->latest()->get();
        return Inertia::render('Admin/ManageCourses', ['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'price' => 'required|numeric|min:0',
                'level_id' => 'required',
                'category_id' => 'required',
                'duration' => 'required|integer',
                'short_description' => 'required|string',
                'learning_points' => 'nullable|array',
                'learning_points.*' => 'string',
            ]);


            if ($request->hasFile('image')) {
                $imagePath = '/storage/' . $request->file('image')->store('course_images', 'public');
            }

            $course = Course::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'profile_image' => $imagePath ?? null,
                'price' => $validated['price'],
                'level_id' => $validated['level_id'],
                'category_id' => $validated['category_id'],
                'duration' => $validated['duration'],
                'user_id' => Auth::user()->id,
                'status' => 0,
                'short_description' => $validated['short_description'],
                'learning_points' => $validated['learning_points'] ?? null,
                'badge' => 'new',
            ]);

            $course = Course::find($course->id)->load('lessons');
          
        
            return redirect()->route('admin.edit-course', ['course' => $course]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.add-course')->withErrors($e->errors());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course = Course::find($course->id)->load('lessons');
        return Inertia::render('Course/courseShow', ['course' => $course]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $course->load('lessons');
        return Inertia::render('Admin/EditCourse', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {

        //dd($request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
            'level_id' => 'required',
            'category_id' => 'required',
            'duration' => 'required|integer',
            'short_description' => 'required|string',
            'learning_points' => 'nullable|array',
            'learning_points.*' => 'string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = '/storage/' . $request->file('image')->store('course_images', 'public');
        }

        $course->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'level_id' => $validated['level_id'],
            'category_id' => $validated['category_id'],
            'duration' => $validated['duration'],
            'profile_image' => $imagePath ?? $course->profile_image,
            'short_description' => $validated['short_description'],
            'learning_points' => $validated['learning_points'] ?? null,
        ]);

        return redirect()->route('admin.manage-courses')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
    }

    /**
     * Publish the course
     */
    public function publish(Course $course)
    {
        $course->update(['status' => 1, 'published_at' => now(),'badge' => "new"]);
          // notify all users that a new course has been created
        event(new CourseCreate($course));
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->notify(new NewCourseNotification($course));
        }
        return redirect()->route('admin.manage-courses')->with('success', 'Course published successfully!');
    }

    public function getCourses()
    {
        $courses = Course::with('lessons')->latest()->take(3)->get();
        return response()->json($courses);
    }

}
