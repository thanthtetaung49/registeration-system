<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index () {
        $events = Event::get();
        return Inertia::render('CalendarPage/CalendarPage', ['events' => $events]);
    }
}
