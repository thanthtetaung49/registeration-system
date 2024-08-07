<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::orderBy('id', 'desc')->paginate(5);

        return Inertia::render('EventPage/Instructor/Instructor', ['instructors' => $instructors]);
    }

    // submit instructor
    public function submitInstructor(Request $request)
    {
        Instructor::create($request->validate([
            'name' => ['required']
        ]));

        return to_route('instructor.index');
    }

    public function edit(Instructor $instructor)
    {
        return Inertia::render('EventPage/Instructor/InstructorEdit', ['instructor' => $instructor]);
    }

    public function update(Instructor $instructor, Request $request)
    {
        $instructor->update($request->validate([
            'name' => ['required']
        ]));

        return to_route('instructor.index');
    }

    public function view(Instructor $instructor)
    {
        return Inertia::render('EventPage/Instructor/InstructorView', ['instructor' => $instructor]);
    }

    public function delete(Instructor $instructor)
    {
        $instructor->delete();
        return to_route('instructor.index');
    }
}
