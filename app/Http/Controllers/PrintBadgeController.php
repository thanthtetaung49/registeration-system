<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintBadgeController extends Controller
{
    public function index()
    {
        $events = Event::get();

        return Inertia::render('PrintingPage/PrintBadge', ['events' => $events]);
    }

    public function printEvent($eventId)
    {
        $registerEvent = RegisterEvent::with('register_attendees')
            ->where('events_id', $eventId)
            ->get();

        return response()->json($registerEvent);
    }

    public function nameBadgeGenerate(Request $request)
    {
        $request->validate([
            'events_id' => ['required'],
            'users_id' => ['required'],
        ]);

        $eventsId = $request->events_id;
        $usersId = $request->users_id;

        $nameBadgeData = RegisterEvent::with('register_attendees', 'events', 'attendees_types')
            ->where('events_id', $eventsId)
            ->where('users_id', $usersId)
            ->first();

        $url = $nameBadgeData->qr_code;
        $qrCode = (string) QrCode::size(100)->generate($url);

        $attendees = User::where('role', 'admin')->get();

        return Inertia::render('PrintingPage/PrintBadge', [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
            'attendees' => $attendees,
        ]);
    }
}
