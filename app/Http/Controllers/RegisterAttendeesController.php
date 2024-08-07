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
        $users = User::with('register_events')->where('is_admin', 0)->paginate(5);
        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => "",
        ]);
    }

    public function submitAttendeeEvent(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'users_id' => ['required'],
            'events_id' => ['required'],
            'attendees_groups_id' => ['required']
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

    public function search(Request $request)
    {
        $search = $request->query('query');
        $events = Event::get();
        $groups = AttendeesGroup::get();

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('phone_number', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->where('is_admin', 0)
            ->paginate(5);


        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function filterAttendees(Request $request)
    {
        $users = User::select('users.name', 'users.phone_number', 'users.email', 'users.created_at', 'register_events.id as registerEvent')
            ->leftJoin('register_events', 'users.id', 'register_events.users_id')
            ->where('attendees_groups_id', $request['data']['attendeesGroupId'])
            ->whereNull('register_events.id') // not registered
            ->paginate(5);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $request['data']['attendeesGroupId'],
            'eventsId' => $request['data']['eventsId'],
        ]);
    }

    public function export()
    {
        $users = User::with(['register_events' => function ($query) {
            $query->with('events')->whereNotNull('id');
        }])
            ->get();

        return Excel::download(new RegisterAttendeesExport($users), 'registerAttendeesReport.xlsx');
    }
}
