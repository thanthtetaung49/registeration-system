<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Instructor;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    // index
    public function index()
    {
        $instructors = Instructor::get();
        $categories = Category::get();
        $roomNumbers = RoomNumber::get();

        return Inertia::render('EventPage/Event/Event', [
            'instructors' => $instructors,
            'categories' => $categories,
            'rooms' => $roomNumbers,
        ]);
    }

    public function submitEvent(Request $request)
    {
        Event::create($request->validate([
            "event_name" => ['required'],
            "description" => ['required'],
            "location" => ['required'],
            "credits" => ['required'],
            "lead_instructors_id" => ['required'],
            "assist_instructors_id" => ['required'],
            "categories_id" => ['required'],
            "max_seats" => ['required'],
            "event_reference_id" => ['required'],
            "start_date" => ['required', 'date', 'after_or_equal:today'],
            "end_date" => ['required','date', 'after:start_date'],
            "start_time" => ['required'],
            "end_time" => ['required'],
            "early_attendance_min" => ['required'],
            "late_attendance_min" => ['required'],
            "room_numbers_id" => ['required'],
        ]));

        return to_route('event.index');
    }
}
