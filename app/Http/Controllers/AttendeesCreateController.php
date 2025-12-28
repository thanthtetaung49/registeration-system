<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
use App\Models\AttendeesType;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AttendeesCreateController extends Controller
{
    public function index()
    {
        $states = State::get();
        $types = AttendeesType::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/AttendeesCreate', [
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
            "sex"            => ['required'],
            "phone_number"   => ['required'],
            "edu_background" => ['required'],
            "nrc_number" => ['unique:users,nrc_number'],
            "position"       => ['required'],
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
            'baseUrl' => env('APP_URL'),
        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::where('id', $id)->first();
        $is_admin = $user->is_admin;
        $password = $request->password;

        $request->validate([
            "name"           => ['required'],
            "sex"            => ['required'],
            "phone_number"   => ['required'],
            "edu_background" => ['required'],
            "nrc_number" => [Rule::unique('users', 'nrc_number')->ignore($user->id)],
            "position"       => ['required'],
            "address"        => ['required'],
            "email"          => ['required', Rule::unique('users', 'email')->ignore($user->id)],
            "attendees_types_id" => $is_admin != 1 && $is_admin != 4 ? ['required'] : '',
            "attendees_groups_id" => $is_admin != 1 && $is_admin != 4 ? ['required'] : '',
            "password" => isset($password) ? ['required', 'min:8'] : '',
            "password_confirmation" => isset($password) ? ["required", "same:password"] : ''
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

        $data = [
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
            "password" => Hash::make($password),
        ];

        $user->update($data);

        return to_route('attendees.list.index');
    }

    public function view($id)
    {
        $user = User::with('attendees_types', 'attendees_groups')->where('id', $id)->first();
        $types = AttendeesType::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/AttendeesView', [
            'user' => $user,
            'types' => $types,
            'groups' => $groups,
            'baseUrl' => env('APP_URL'),
        ]);
    }

    public function delete($id)
    {
        $user = User::with('register_events')->where('id', $id)->first();
        $oldFilename = $user->profile_path;

        if (Storage::exists('public/' . $oldFilename)) {
            Storage::delete('public/' . $oldFilename);
        }

        foreach ($user->register_events as $event) {
            $event->delete();
        }

        $user->delete();

        return to_route('attendees.list.index');
    }
}
