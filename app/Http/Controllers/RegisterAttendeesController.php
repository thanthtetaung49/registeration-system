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
            ->where('is_admin', 0)
            ->whereDoesntHave('register_events')
            ->paginate(20);

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

        foreach ($usersId as $id) {
            $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $digits = rand(100, 999);
            $code = $letters . $digits;

            RegisterEvent::create([
                'users_id'  => $id,
                'events_id' => $request->events_id,
                'qr_code'   => $code,
            ]);
        }

        return redirect()->route('attendees.register.index');
    }

    // public function search(Request $request)
    // {
    //     $search = $request->query('query');
    //     $events = Event::get();
    //     $groups = AttendeesGroup::get();

    //     if (empty($search)) {
    //         $users = User::with('register_events')
    //             ->whereNotNull('attendees_groups_id')
    //             ->where('is_admin', 0)
    //             ->whereDoesntHave('register_events')
    //             ->paginate(20);
    //     } else {
    //         $users = User::with('register_events')
    //             ->when($search, function ($query) use ($search) {
    //                 $query->where('name', 'like', '%' . $search . '%')
    //                     ->where('is_admin', 0)
    //                     ->orWhere('phone_number', 'like', '%' . $search . '%')
    //                     ->orWhere('email', 'like', '%' . $search . '%');
    //             })
    //             ->whereNotNull('attendees_groups_id')
    //             ->whereDoesntHave('register_events')
    //             ->paginate(20);
    //     }

    //     return Inertia::render('AttendeesPage/RegisterAttendees', [
    //         'users' => $users,
    //         'events' => $events,
    //         'groups' => $groups,
    //     ]);
    // }

    public function filterAttendees(Request $request)
    {
        $groupId = $request['data']['attendeesGroupId'];

        if (!$groupId) {
            $users = User::with(['register_events', 'attendees_groups'])
                ->whereNotNull('attendees_groups_id')
                ->where('is_admin', 0)
                ->whereDoesntHave('register_events')
                ->paginate(20);
        } else {
            $users = User::with(['register_events', 'attendees_groups'])
                ->where('is_admin', 0)
                ->where('attendees_groups_id', $groupId)
                ->whereNotNull('attendees_groups_id')
                ->whereDoesntHave('register_events') // not registered
                ->paginate(20);
        }


        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/RegisterAttendees', [
            'users' => $users,
            'events' => $events,
            'groups' => $groups,
            'groupId' => $groupId,
        ]);
    }

    public function export()
    {
        $users = User::with(['register_events', 'attendees_types', 'attendees_groups'])
            ->whereHas('register_events')
            ->where('is_admin', 0)
            ->get();

        return Excel::download(new RegisterAttendeesExport($users), 'registerAttendeesReport.xlsx');
    }
}
