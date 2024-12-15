<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
