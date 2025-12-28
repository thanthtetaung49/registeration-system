<?php

namespace App\Http\Controllers;

use App\Models\AttendeesGroup;
use App\Models\Event;
use App\Models\RegisterEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnregisterAttendeesController extends Controller
{
    public function index()
    {
        $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees', [
            'registerEvents' => $registerEvents,
            'events' => $events,
            'groups' => $groups,
        ]);
    }

    public function unregisterEvent(Request $request)
    {
        $registerEventsId = $request->registerEvents_id;

        $request->validate([
            'registerEvents_id' => ['required'],
            'events_id' => ['required'],
        ]);


        foreach ($registerEventsId as $regEventId) {
            RegisterEvent::where('id', $regEventId)
                ->delete();
        }

        return to_route('attendees.unregisterAttendees.index');
    }

    public function search(Request $request)
    {
        $search = $request['query'];
        $eventId = $request['eventId'];

        $events = Event::get();
        $groups = AttendeesGroup::get();

        if ($eventId) {
            if (empty($search)) {
                $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
                    ->orderBy('id', 'desc')
                    ->paginate(20);

                $eventId = null;
            } else {
                $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
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
            $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
                ->whereHas('register_attendees', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        return Inertia::render('AttendeesPage/UnRegisterAttendees', [
            'registerEvents'  => $registerEvents,
            'events' => $events,
            'groups' => $groups,
            'eventsId' => $eventId,
        ]);
    }

    public function filterAttendees(Request $request)
    {
        $eventId = $request['data']['eventsId'] ??  $request['data']['eventsId'];

        if (empty($eventId)) {
            $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
                ->orderBy('id', 'desc')
                ->paginate(20);
        } else {
            $registerEvents = RegisterEvent::with(['register_attendees', 'events'])
                ->where('events_id', $eventId)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        $events = Event::get();
        $groups = AttendeesGroup::get();

        return Inertia::render('AttendeesPage/UnRegisterAttendees', [
            'registerEvents' => $registerEvents,
            'events' => $events,
            'groups' => $groups,
            'eventsId' => $eventId,
        ]);
    }
}
