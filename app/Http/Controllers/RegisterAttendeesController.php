<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
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

    public function submitAttendeeEvent(Request $request) {
        $request->validate([
            'users_id' => ['required'],
            'events_id' => ['required'],
        ]);

        $usersId = $request->users_id;

        foreach ($usersId as $users_id) {
            $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $digits = rand(100, 999);
            $code = $letters . $digits;
            
            $registerEvents = new RegisterEvent();
            $registerEvents->users_id = $users_id;
            $registerEvents->events_id = $request->events_id;
            $registerEvents->qr_code = $code;

            $registerEvents->save();
        }

        return to_route('attendees.register.index');
    }
}
