<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendeesBusinessCardController extends Controller
{
    public function index()
    {
        $users = User::with('attendees_types', 'attendees_groups', 'register_events')
            ->orderBy('id', 'desc')
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->paginate(20);

        return Inertia::render('AttendeesBusinessCardPage/Attendees', ['users' => $users, 'baseUrl' => url('/')]);
    }

    public function view($id)
    {
        $user = User::findOrFail($id);

        return Inertia::render('AttendeesBusinessCardPage/AttendeesBusinessCardView', ['user' => $user, 'baseUrl' => url('/')]);
    }

    public function viewPublic($id)
    {
        $user = User::findOrFail($id);

        return Inertia::render('AttendeesBusinessCardPage/AttendeesBusinessCardViewPublic', ['user' => $user, 'baseUrl' => url('/')]);
    }

    public function changePublicStatus ($id) {
        $user = User::findOrFail($id);

        $user->is_public_url = !$user->is_public_url;

        $user->save();

        return redirect()->back();
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


        return Inertia::render('AttendeesBusinessCardPage/Attendees', ['users' => $users, 'baseUrl' => url('/')]);
    }
}
