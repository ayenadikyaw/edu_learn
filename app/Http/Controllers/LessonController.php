<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        return Inertia::render('Admin/AddLesson');
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
    public function store(Request $request, Course $course)
    {
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
        $validated['course_id'] = $course->id;
        $lesson = Lesson::create($validated);
        $course = Course::find($course->id)->load('lessons');
        return redirect()->route('admin.edit-course', ['course' => $course]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $lesson->load('course');
        return Inertia::render('Admin/EditLesson', ['lesson' => $lesson]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($request->all());
        return redirect()->route('admin.edit-course', $lesson->course_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.edit-course', $lesson->course_id);
    }
}
