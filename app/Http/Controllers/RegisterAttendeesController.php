<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterAttendeesController extends Controller
{
    public function index () {
        $users = User::where('is_admin', 0)->get();
        $events = Event::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', ['users' => $users, 'events' => $events]);
    }
}
