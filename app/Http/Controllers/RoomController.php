<?php

namespace App\Http\Controllers;

use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index () {
        $rooms = RoomNumber::orderBy('id', 'desc')->paginate(5);

        return Inertia::render('EventPage/Room/Room', ['rooms' => $rooms]);
    }

    // submit room number
    public function submitRoomNumber(Request $request)
    {
        RoomNumber::create($request->validate([
            'room_number' => ['required'],
        ]));

        return to_route('roomNumber.index');
    }
}
