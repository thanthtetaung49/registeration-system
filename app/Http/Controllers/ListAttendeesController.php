<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListAttendeesController extends Controller
{
    public function index () {
        $users = User::orderBy('id', 'desc')->where('is_admin', 0)->paginate(5);

        return Inertia::render('AttendeesPage/ListAttendees', ['users' => $users]);
    }
}
