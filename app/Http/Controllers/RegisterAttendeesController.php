<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
use App\Models\Event;
use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterAttendeesController extends Controller
{
    public function index()
    {
        $users = User::with('register_events')->where('is_admin', 0)->paginate(5);
        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups
        ]);
    }

    public function submitAttendeeEvent(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'users_id' => ['required'],
            'events_id' => ['required'],
        ]);

        $usersId = $request->users_id;

        foreach ($usersId as $users_id) {
            $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $digits = rand(100, 999);
            $code = $letters . $digits;

            RegisterEvent::create([
                'users_id'  => $users_id,
                'events_id' => $request->events_id,
                'qr_code'   => $code,
            ]);
        }


        return to_route('attendees.register.index');
    }

    public function filterGroup (Request $request) {
        $id = $request->id;
        $users = User::with('register_events')->where('attendees_groups_id', $id)
                ->where('is_admin', 0)
                ->paginate(5);
        return response()->json($users);
    }

    public function search (Request $request) {
        $search = $request['query'];

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('phone_number', 'like', '%' . $search. '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->where('is_admin', 0)
            ->paginate(5);

        return response()->json($users);
    }
}
