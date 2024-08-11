<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
use App\Models\Event;
use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnregisterAttendeesController extends Controller
{
    public function index()
    {
        $users = RegisterEvent::with(['register_attendees', 'events'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function unregisterEvent(Request $request)
    {
        // dd($request->all());
        $usersId = $request->users_id;

        $request->validate([
            'events_id' => ['required'],
            'users_id' => ['required'],
        ]);

        foreach ($usersId as $id) {
            RegisterEvent::where('users_id', $id)->delete();
        }

        $users = RegisterEvent::with('register_attendees')->orderBy('id', 'desc')->paginate(20);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request['query'];
        $eventId = $request['eventId'];

        $events = Event::get();
        $groups = AttendeesGroup::get();

        if ($eventId) {
            if (empty($search)) {
                $users = RegisterEvent::with(['register_attendees', 'events'])
                    ->orderBy('id', 'desc')
                    ->paginate(20);

                $eventId = null;
            } else {
                $users = RegisterEvent::with(['register_attendees', 'events'])
                    ->whereHas('register_attendees', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone_number', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->where('events_id', $eventId)
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        } else {
            $users = RegisterEvent::with(['register_attendees', 'events'])
                ->whereHas('register_attendees', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users'  => $users,
            'events' => $events,
            'groups' => $groups,
            'eventsId' => $eventId,
        ]);
    }

    public function filterAttendees(Request $request)
    {
        $eventId = $request['data']['eventsId'] ??  $request['data']['eventsId'];

        if (empty($eventId)) {
            $users = RegisterEvent::with(['register_attendees', 'events'])->orderBy('id', 'desc')->paginate(20);
        } else {
            $users = RegisterEvent::with(['register_attendees', 'events'])
                ->where('events_id', $eventId)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'eventsId' => $eventId,
        ]);
    }
}
