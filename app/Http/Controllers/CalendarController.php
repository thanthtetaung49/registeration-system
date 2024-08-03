<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index () {
        $events = Event::get()->select('event_name', 'start_date', 'end_date', 'end_time');
        return Inertia::render('CalendarPage/CalendarPage', ['events' => $events]);
    }
}
