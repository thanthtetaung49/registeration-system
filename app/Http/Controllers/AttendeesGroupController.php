<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendeesGroupController extends Controller
{
    public function index()
    {
        $attendeesGroup = AttendeesGroup::orderBy('id', 'desc')->paginate(20);

        return Inertia::render('AttendeesPage/AttendeesGroup/AttendeesGroup', [
            'groups' => $attendeesGroup
        ]);
    }

    public function create(Request $request)
    {
        AttendeesGroup::create($request->validate([
            'name' => ['required']
        ]));

        return to_route('attendees.group.index');
    }

    public function view(AttendeesGroup $attendeesGroup)
    {
        return Inertia::render('AttendeesPage/AttendeesGroup/AttendeesGroupView', [
            'group' => $attendeesGroup
        ]);
    }

    public function  edit(AttendeesGroup $attendeesGroup)
    {
        return Inertia::render('AttendeesPage/AttendeesGroup/AttendeesGroupEdit', [
            'group' => $attendeesGroup
        ]);
    }

    public function  update(AttendeesGroup $attendeesGroup, Request $request)
    {
        $attendeesGroup->update($request->validate([
            'name' => ['required']
        ]));

        return to_route('attendees.group.index');
    }

    public function delete(AttendeesGroup $attendeesGroup)
    {
        $attendeesGroup->delete();

        return to_route('attendees.group.index');
    }
}
