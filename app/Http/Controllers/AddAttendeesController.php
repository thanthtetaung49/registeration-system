<?php

namespace App\Http\Controllers;

use App\Models\AttendeesType;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AddAttendeesController extends Controller
{
    public function index()
    {
        $states = State::get();
        $types = AttendeesType::get();

        return Inertia::render('AttendeesPage/AddAttendees', ['states' => $states, 'types' => $types]);
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
            "avatar" => ['image', 'mimes:png,jpeg,jpg,svg'],
            "attendees_types_id" => ['required']
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
            "attendees_types_id" => $request->attendees_types_id,
        ]);

        $file->storeAs('public/profile', $filename);

        return to_route('attendees.list.index');
    }

    public function edit($id)
    {
        $types = AttendeesType::get();
        $user = User::with('attendees_types')->where('id', $id)->first();

        return Inertia::render('AttendeesPage/AttendeesEdit', ['user' => $user, 'types' => $types]);
    }

    public function update($id, Request $request)
    {
        $user = User::where('id', $id)->first();

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
            "attendees_types_id" => ['required']
        ]);

        $oldFilename = $user->profile_path;
        $file = $request->file('avatar');


        if (isset($file) && $oldFilename != $file->getClientOriginalName()) {
            $filename = uniqid() . time() . $file->getClientOriginalName();
            // new update photo
            if (Storage::exists('public/' . $oldFilename)) {
                Storage::delete('public/' . $oldFilename);
            }

            $file->storeAs('public/profile', $filename);

            $user->update([
                'profile_path' => 'profile/' . $filename,
            ]);
        } else {
            // not update photo
            $user->update([
                'profile_path' => $oldFilename,
            ]);
        }

        $user->update([
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
            "attendees_types_id" => $request->attendees_types_id
        ]);

        return to_route('attendees.list.index');
    }

    public function view($id)
    {
        $user = User::with('attendees_types')->where('id', $id)->first();
        $types = AttendeesType::get();

        return Inertia::render('AttendeesPage/AttendeesView', ['user' => $user , 'types' => $types]);
    }

    public function delete(User $user)
    {
        $oldFilename = $user->profile_path;

        if (Storage::exists('public/' . $oldFilename)) {
            Storage::delete('public/' . $oldFilename);
        }

        $user->delete();

        return to_route('attendees.list.index');
    }
}
