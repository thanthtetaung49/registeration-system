<?php

namespace App\Http\Controllers;

use App\Exports\RegisterAttendeesExport;
use App\Models\AttendeesGroup;
use App\Models\Event;
use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class RegisterAttendeesController extends Controller
{
    public function index()
    {
        $users = User::with(['register_events', 'attendees_groups'])
            ->whereNotNull('attendees_groups_id')
            ->whereIn('is_admin', [0, 3])
            ->whereDoesntHave('register_events')
            ->paginate(20);

        // dd($users->get()->toArray());

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function submitAttendeeEvent(Request $request)
    {
        $request->validate([
            'events_id' => ['required'],
            'users_id' => ['required'],
            'attendees_groups_id' => ['required']
        ]);

        $usersId = $request->users_id;
        $eventId = $request->events_id;

        $event = Event::where('id', $eventId)->first();

        if ($event->event_type == 2) {
            User::whereIn('id', $usersId)->update([
                'is_admin' => 3 // change user type to self check-in user
            ]);
        }

        foreach ($usersId as $id) {
            $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $digits = rand(100, 999);
            $code = $letters . $digits;

            RegisterEvent::create([
                'users_id'  => $id,
                'events_id' => $eventId,
                'qr_code'   => $code,
            ]);
        }

        return redirect()->route('attendees.registerAttendees.index');
    }

    public function filterAttendees(Request $request)
    {
        $groupId = $request['data']['attendeesGroupId'];

        $users = User::with(['register_events', 'attendees_groups'])
            ->whereIn('is_admin', [0, 3])
            ->when($groupId, fn($u) => $u->where('attendees_groups_id', $groupId))
            ->whereNotNull('attendees_groups_id')
            ->whereDoesntHave('register_events')
            ->paginate(20);

        // if (!$groupId) {
        //     $users = User::with(['register_events', 'attendees_groups'])
        //         ->where('is_admin', 0)
        //         ->whereNotNull('attendees_groups_id')
        //         ->whereDoesntHave('register_events')
        //         ->paginate(20);
        // } else {
        //     $users = User::with(['register_events', 'attendees_groups'])
        //         ->where('is_admin', 0)
        //         ->where('attendees_groups_id', $groupId)
        //         ->whereNotNull('attendees_groups_id')
        //         ->whereDoesntHave('register_events') // not registered
        //         ->paginate(20);
        // }


        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $groupId,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $groupId = $request->query('groupId');
        $eventsId = $request->query('eventsId');

        $users = User::with(['register_events', 'attendees_groups'])
            ->whereNotNull('attendees_groups_id')
            ->whereIn('is_admin', [0, 3])
            ->whereDoesntHave('register_events')
            ->when($query, fn($u) => $u->where('name', 'like', '%' . $query . '%'))
            ->paginate(20);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $groupId,
            'eventsId' => $eventsId
        ]);
    }

    public function export()
    {
        $users = User::with(['register_events', 'attendees_types', 'attendees_groups'])
            ->whereHas('register_events')
            ->whereIn('is_admin', [0, 3]) // 0,3 user
            ->get();

        return Excel::download(new RegisterAttendeesExport($users), 'registerAttendeesReport.xlsx');
    }
}
