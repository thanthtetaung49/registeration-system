<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintController extends Controller
{
    public function index () {
        $attendees = User::where('is_admin', 0)->get();

        return Inertia::render('PrintingPage/Print', ['attendees' => $attendees]);
    }

    public function printEvent($userId) {
        $registerEvent = RegisterEvent::with('events')->where('users_id', $userId)->get();

        return response()->json($registerEvent);
    }

    public function nameBadgeGenerate(Request $request) {
        $eventsId = $request->events_id;
        $usersId = $request->users_id;

        $nameBadgeData = RegisterEvent::with('register_attendees', 'events')->where('events_id', $eventsId)
            ->where('users_id', $usersId)
            ->first();

        $url = url('/qrcode/scan?code=' . $nameBadgeData->qr_code);
        $qrCode = (string) QrCode::size(100)->generate($url);

        $attendees = User::where('is_admin', 0)->get();
        
        return Inertia::render('PrintingPage/Print', [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
            'attendees' => $attendees,
        ]);
    }
}
