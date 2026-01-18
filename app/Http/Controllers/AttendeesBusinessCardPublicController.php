<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AttendeesBusinessCardPublicController extends Controller
{
    public function index()
    {
        $users = User::with('attendees_types', 'attendees_groups', 'register_events')
            ->orderBy('id', 'desc')
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->where('is_public_url', 1)
            ->paginate(20);

        return Inertia::render('AttendeesBusinessCardPage/AttendeesPublic', ['users' => $users, 'baseUrl' => url('/')]);
    }

    public function search(Request $request)
    {
        $search = $request->query('query');

        $users = User::with('attendees_types', 'attendees_groups', 'register_events')
            ->when($search != "null", function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->orderBy('id', 'desc')
            ->paginate(20);


        return Inertia::render('AttendeesBusinessCardPage/AttendeesPublic', ['users' => $users, 'baseUrl' => url('/')]);
    }
}
