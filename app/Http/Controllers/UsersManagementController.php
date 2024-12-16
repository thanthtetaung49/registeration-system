<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\AttendeesType;
use App\Models\AttendeesGroup;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersManagementController extends Controller
{
    public function index () {
        $users = User::orderByDesc('id')->paginate(10);
        $superAdmin = auth()->user()->is_admin;


        return Inertia::render('UsersManagement/UsersManagement', [
            'users' => $users,
            'superAdmin' => $superAdmin
        ]);
    }

    // edit
    public function edit($id)
    {
        $user = User::with('attendees_types', 'attendees_groups')->where('id', $id)->first();
        $types = AttendeesType::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('UsersManagement/EditUsersManagement', [
            'user' => $user,
            'types' => $types,
            'groups' => $groups,
            'baseUrl' => env('APP_URL'),
        ]);
    }

    // update
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

        return to_route('users.management');
    }


    // view
    public function  view (User $user) {
        return response()->json([
            'user' => $user,
            'baseUrl' => env('APP_URL')
        ]);
    }

    // update role
    public function updateRole (Request $request) {
        $id = $request->id;
        $is_admin = $request->role;
        $user = User::findOrFail($id);

        $user->update(['is_admin' => $is_admin]);

        return response()->json([
            'userId' => $user->id,
            'baseUrl' => env('APP_URL')
        ]);
    }

    // disabled users
    public function disabledUser (Request $request) {
        $user = User::findOrFail($request->userId);

        $user->update(['disable_status' => 1]); // account is disabled

        return response()->json([
            'userId' => $user
        ]);
    }

    // activate users
    public function activateUser (Request $request) {
        $user = User::findOrFail($request->userId);

        $user->update(['disable_status' => 0]); // account is activate

        return response()->json([
            'userId' => $user
        ]);
    }

    // delete users
    public function deleteUser (Request $request) {
        $user = User::findOrFail($request->userId);

        $user->delete(); // account is activate

        return response()->json([
            'message' => 'delete successfully.'
        ]);
    }
}
