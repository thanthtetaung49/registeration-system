<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersManagementController extends Controller
{
    public function index () {
        $users = User::orderByDesc('id')->paginate(10);
        return Inertia::render('UsersManagement/UsersManagement', [
            'users' => $users
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
        // dd($request->all());
    }
}
