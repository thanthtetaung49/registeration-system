<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddAttendeesController extends Controller
{
    public function index()
    {
        $states = State::get();

        return Inertia::render('AttendeesPage/AddAttendees', ['states' => $states]);
    }

    public function submitAttendee(Request $request)
    {
        // dd($request->all());
        User::create($request->validate([
            "name" => ['required'],
            "age" => ['required'],
            "sex" => ['required'],
            "phone_number" => ['required'],
            "nrc_number" => ['required'],
            "edu_background" => ['required'],
            "position" => ['required'],
            "department" => ['required'],
            "address" => ['required'],
            "email" => ['required'],
        ]));

        return to_route('attendees.add.index');
    }
}
