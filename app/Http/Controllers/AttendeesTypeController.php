<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\AttendeesType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AttendeesTypeController extends Controller
{
    public function index()
    {
        $types = AttendeesType::orderBy('id', 'desc')->paginate(5);

        return Inertia::render('AttendeesPage/AttendeesType/AttendeesType', ['types' => $types]);
    }

    public function create(Request $request)
    {
        AttendeesType::create($request->validate([
            'name' => ['required']
        ]));

        return to_route('attendees.type.index');
    }

    public function edit(AttendeesType $attendeesType)
    {

        return Inertia::render('AttendeesPage/AttendeesType/AttendeesTypeEdit', ['type' => $attendeesType]);
    }

    public function update(AttendeesType $attendeesType, Request $request)
    {

        $attendeesType->update($request->validate([
            'name' => ['required']
        ]));

        return to_route('attendees.type.index');
    }

    public function view(AttendeesType $attendeesType)
    {

        return Inertia::render('AttendeesPage/AttendeesType/AttendeesTypeView', ['type' => $attendeesType]);
    }

    public function delete(AttendeesType $attendeesType)
    {
        $attendeesType->delete();

        // return to_route('attendees.type.index');
    }
}
