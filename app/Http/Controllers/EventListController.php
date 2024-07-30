<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventListController extends Controller
{
    public function index () {
        $events = Event::with('lead_instructors', 'assists_instructors', 'categories')->orderBy('id', 'desc')->paginate(5);

        return Inertia::render('EventPage/Event/EventList', [
            'events' => $events,
        ]);
    }

    public function eventAttendeesList ($eventId) {
        $registerEvents = RegisterEvent::with('register_attendees')->where('events_id', $eventId)->orderBy('id', 'desc')->get();

        return response()->json($registerEvents);
    }
}
