<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index () {
        $events = Event::get();
        $disable_status = auth()->user()->disable_status;

        return Inertia::render('CalendarPage/CalendarPage', [
            'events' => $events,
            'status' => $disable_status
        ]);
    }
}
