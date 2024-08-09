<?php

namespace App\Http\Controllers;

use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = RoomNumber::orderBy('id', 'desc')->paginate(20);

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

    public function edit(RoomNumber $room)
    {
        return Inertia::render('EventPage/Room/RoomEdit', ['room' => $room]);
    }

    public function update(RoomNumber $room, Request $request)
    {
        $room->update($request->validate([
            'room_number' => ['required'],
        ]));
        return to_route('roomNumber.index');
    }

    public function view(RoomNumber $room)
    {
        return Inertia::render('EventPage/Room/RoomView', ['room' => $room]);
    }

    public function delete(RoomNumber $room)
    {
        $room->delete();
        return to_route('roomNumber.index');
    }
}
