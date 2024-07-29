<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstructorController extends Controller
{
    public function index () {
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
}
