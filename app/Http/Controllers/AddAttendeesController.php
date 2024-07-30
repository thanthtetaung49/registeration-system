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
        $request->validate([
            "name"           => ['required'],
            "age"            => ['required'],
            "sex"            => ['required'],
            "phone_number"   => ['required'],
            "nrc_number"     => ['required'],
            "edu_background" => ['required'],
            "position"       => ['required'],
            "department"     => ['required'],
            "address"        => ['required'],
            "email"          => ['required'],
            "avatar" => ['image', 'mimes:png,jpeg,jpg,svg']
        ]);

        $file = $request->file('avatar');
        $filename = uniqid() . time() . $request->file('avatar')->getClientOriginalName();
        
        User::create([
            "name"           => $request->name,
            "age"            => $request->age,
            "sex"            => $request->sex,
            "phone_number"   => $request->phone_number,
            "nrc_number"     => $request->nrc_number,
            "edu_background" => $request->edu_background,
            "position"       => $request->position,
            "department"     => $request->department,
            "address"        => $request->address,
            "email"          => $request->email,
            "profile_path" => 'profile/' . $filename,
        ]);

        $file->storeAs('public/profile', $filename);

        return to_route('attendees.add.index');
    }
}
