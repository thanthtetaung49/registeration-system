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
        $users = User::with('register_events')
            ->whereNotNull('attendees_groups_id')
            ->where('is_admin', 0)
            ->whereHas('register_events')
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

        $users = User::with('register_events')
            ->whereNotNull('attendees_groups_id')
            ->where('is_admin', 0)
            ->whereHas('register_events')
            ->paginate(20);

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
        $search = $request->query('query');
        $events = Event::get();
        $groups = AttendeesGroup::get();

        if (empty($search)) {
            $users = User::with('register_events')
                ->whereNotNull('attendees_groups_id')
                ->where('is_admin', 0)
                ->whereHas('register_events')
                ->paginate(20);
        } else {
            $users = User::with('register_events')
                ->when($search, function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->where('is_admin', 0)
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->whereNotNull('attendees_groups_id')
                ->whereHas('register_events')
                ->get();
        }

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users'  => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function filterAttendees(Request $request)
    {
        $eventId = $request['data']['eventId'] ??  $request['data']['eventId'];

        $users = User::with([
            'register_events' => function ($query) use ($eventId) {
                $query->where('register_events.id', $eventId);
        }])
            ->where('is_admin', 0)
            ->whereNotNull('attendees_groups_id')
            ->whereHas('register_events') // not registered
            ->get();

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $request['data']['attendeesGroupId'],
            'eventsId' => $request['data']['eventId'],
        ]);
    }
}
