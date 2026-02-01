<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('id', 'desc')->paginate(20);

        return Inertia::render('AttendeesPage/Course/Course', [
            'courses' => $courses
        ]);
    }

    public function create(Request $request)
    {
        Course::create($request->validate([
            'course_name' => ['required']
        ]));

        return to_route('attendees.course.index');
    }

    public function edit(Course $course)
    {
        return Inertia::render('AttendeesPage/Course/CourseEdit', ['course' => $course]);
    }

    public function update(Course $course, Request $request)
    {
        $course->update($request->validate([
            'course_name' => ['required']
        ]));

        return to_route('attendees.course.index');
    }

    public function view(Course $course)
    {
        return Inertia::render('AttendeesPage/Course/CourseView', ['course' => $course]);
    }

    public function delete(Course $course)
    {
        $course->delete();
    }
}
