<?php

namespace App\Http\Controllers;

use App\Exports\RegisterAttendeesCheckInStatusExport;
use App\Models\RegisterEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class EventReportController extends Controller
{
    public function index()
    {
        $registerEvents = RegisterEvent::with(['register_attendees', 'attendees_types', 'events'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return Inertia::render('EventPage/EventReport/EventReport', ['registerEvents' => $registerEvents]);
    }

    public function search(Request $request)
    {
        $search = $request->query('query');

        if ($search == 'null') {
            $registerEvents = RegisterEvent::with(['register_attendees', 'attendees_types', 'events'])->orderBy('id', 'desc')->paginate(20);
        } else {
            $registerEvents = RegisterEvent::with('register_attendees', 'attendees_types', 'events')
                ->whereHas('register_attendees', function ($query) use ($search) {
                    $query->where('users.name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('attendees_types', function ($query) use ($search) {
                    $query->where('attendees_types.name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('events', function ($query) use ($search) {
                    $query->where('events.event_name', 'like', '%' . $search . '%');
                })
                ->paginate(20);
        }

        return Inertia::render('EventPage/EventReport/EventReport', ['registerEvents' => $registerEvents]);
    }

    public function excelExport()
    {
        $registerEvents = RegisterEvent::with(['register_attendees', 'attendees_types', 'events'])
            ->orderBy('id', 'desc')
            ->get();

        return Excel::download(new RegisterAttendeesCheckInStatusExport($registerEvents), 'attendeesCheckin.xlsx');
    }
}
