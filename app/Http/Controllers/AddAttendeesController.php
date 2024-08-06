<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
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
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/AddAttendees', [
            'states' => $states,
            'types' => $types,
            'groups' => $groups,
        ]);
    }

    public function submitAttendee(Request $request)
    {
        // dd($request->all());
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
            "email"          => ['required', 'email', 'unique:users,email'],
            "attendees_types_id" => ['required'],
            "attendees_groups_id" => ['required']
        ]);

        $file = $request->file('avatar');
        if (!empty($file)) {
            // dd('file has');
            $filename = uniqid() . time() . $request->file('avatar')->getClientOriginalName();
            $file->storeAs('public/profile', $filename);

            $imageArray = ["profile_path" => 'profile/' . $filename];
        } else {
            $imageArray = ["profile_path" => null];
        }

        $array = [
            "name"               => $request->name,
            "age"                => $request->age,
            "sex"                => $request->sex,
            "phone_number"       => $request->phone_number,
            "nrc_number"         => $request->nrc_number,
            "edu_background"     => $request->edu_background,
            "position"           => $request->position,
            "department"         => $request->department,
            "address"            => $request->address,
            "email"              => $request->email,
            "attendees_types_id" => $request->attendees_types_id,
            "attendees_groups_id" => $request->attendees_groups_id,
        ];

        $mergeArray = array_merge($array, $imageArray);

        User::create($mergeArray);

        return to_route('attendees.list.index');
    }

    public function edit($id)
    {
        $user = User::with('attendees_types', 'attendees_groups')->where('id', $id)->first();
        $types = AttendeesType::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/AttendeesEdit', [
            'user' => $user,
            'types' => $types,
            'groups' => $groups,
        ]);
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
            "attendees_types_id" => ['required'],
            "attendees_groups_id" => ['required']
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
            "attendees_types_id" => $request->attendees_types_id,
            "attendees_groups_id" => $request->attendees_groups_id,
        ]);

        return to_route('attendees.list.index');
    }

    public function view($id)
    {
        $user = User::with('attendees_types', 'attendees_groups')->where('id', $id)->first();
        $types = AttendeesType::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/AttendeesView', [
            'user' => $user ,
            'types' => $types,
            'groups' => $groups,
        ]);
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
