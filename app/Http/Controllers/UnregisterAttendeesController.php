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
        $usersId = $request->users_id;

        $request->validate([
            'events_id' => ['required'],
            'users_id' => ['required'],
            'attendees_groups_id' => ['required'],
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

        dd($users->toArray());

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users'  => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function filterAttendees(Request $request)
    {
        $users = User::select('users.name', 'users.phone_number', 'users.email', 'users.created_at', 'users.id as id')
            ->leftJoin('register_events', 'users.id', 'register_events.users_id')
            ->where('attendees_groups_id', $request['data']['attendeesGroupId'])
            ->whereNotNull('register_events.id')
            ->distinct()
            ->paginate(20);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees/UnRegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $request['data']['attendeesGroupId'],
            'eventsId' => $request['data']['eventsId'],
        ]);
    }
}
