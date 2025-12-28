<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Instructor;
use App\Models\RegisterEvent;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventListController extends Controller
{
    public function index()
    {
        $events = Event::with('lead_instructors', 'assists_instructors', 'categories')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return Inertia::render('EventPage/Event/EventList', [
            'events' => $events,
        ]);
    }

    public function eventAttendeesList($eventId)
    {
        $registerEvents = RegisterEvent::with('register_attendees')
            ->where('events_id', $eventId)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($registerEvents);
    }

    public function view($eventId)
    {
        $event = Event::with('lead_instructors', 'assists_instructors', 'categories')
            ->where('id', $eventId)
            ->first();

        return Inertia::render('EventPage/Event/EventView', ['event' => $event]);
    }

    public function edit($eventId)
    {
        $event = Event::with('lead_instructors', 'assists_instructors', 'categories')
            ->where('id', $eventId)
            ->first();

        $instructors = Instructor::get();
        $categories = Category::get();
        $roomNumbers = RoomNumber::get();

        return Inertia::render('EventPage/Event/EventEdit', [
            'event' => $event,
            'instructors' => $instructors,
            'categories' => $categories,
            'rooms' => $roomNumbers,
        ]);
    }

    public function update(Event $event, Request $request)
    {
        $validation = $request->validate([
            "event_name" => ['required'],
            "description" => ['required'],
            "location" => ['required'],
            "credits" => ['required'],
            "lead_instructors_id" => ['required'],
            "assist_instructors_id" => ['required'],
            "categories_id" => ['required'],
            "max_seats" => ['required'],
            "event_reference_id" => ['required'],
            "start_date" => [
                'required',
                'date',
                'after_or_equal:' . $event->start_date,
            ],
            "end_date" => [
                'required',
                'date',
                'after:' . $event->start_date,
            ],
            "start_time" => ['required'],
            "end_time" => ['required'],
            "early_attendance_min" => ['required'],
            "late_attendance_min" => ['required'],
            "room_numbers_id" => ['required'],
            "event_type" => ['required'],
        ]);

        $letters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
        $digits = rand(100, 999);
        $code = $letters . $digits;
        $eventCode = ['event_code' => $code, 'event_type' => $request->event_type ? 2 : 1];
        $mergeEvent = array_merge($validation, $eventCode);

        $event->update($mergeEvent);

        return to_route('event.list.index');
    }

    public function delete(Event $event)
    {
        $event->delete();
        return to_route('event.list.index');
    }

    public function search(Request $request)
    {
        $search = $request->query('query');

        if ($search === "null") {
            $events = Event::with('lead_instructors', 'assists_instructors', 'categories')
                ->orderBy('id', 'desc')
                ->paginate(20);
        } else {
            $events = Event::with('lead_instructors', 'assists_instructors', 'categories')
                ->when($search, function ($query) use ($search) {
                    return $query->where('event_name', 'LIKE', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        return Inertia::render('EventPage/Event/EventList', [
            'events' => $events,
        ]);
    }

    public function selfCheckInUserQRCodeGenerate($eventId)
    {
        $event = Event::findOrFail($eventId);
        $eventCode = $event->event_code;

        $qrCode = (string) QrCode::size(300)->generate($eventCode);

        return response()->json([
            'qrCode' => $qrCode,
            'event' => $event,
        ]);
    }
}
