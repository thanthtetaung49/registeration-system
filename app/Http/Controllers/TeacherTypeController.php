<?php

namespace App\Http\Controllers;

use App\Models\TeacherType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherTypeController extends Controller
{
    public function index()
    {
        $teacherTypes = TeacherType::orderBy('id', 'desc')->paginate(20);

        return Inertia::render('AttendeesPage/TeacherType/TeacherType', [
            'teacherTypes' => $teacherTypes
        ]);
    }

    public function create(Request $request)
    {
        TeacherType::create($request->validate([
            'teacher_type' => ['required']
        ]));

        return to_route('attendees.teacherType.index');
    }

    public function edit(TeacherType $teacherType)
    {
        return Inertia::render('AttendeesPage/TeacherType/TeacherTypeEdit', ['teacherType' => $teacherType]);
    }

    public function update(TeacherType $teacherType, Request $request)
    {
        $teacherType->update($request->validate([
            'teacher_type' => ['required']
        ]));

        return to_route('attendees.teacherType.index');
    }

    public function view(TeacherType $teacherType)
    {
        return Inertia::render('AttendeesPage/TeacherType/TeacherTypeView', ['teacherType' => $teacherType]);
    }

    public function delete(TeacherType $teacherType)
    {
        $teacherType->delete();
    }
}
