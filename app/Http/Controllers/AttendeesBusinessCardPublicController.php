<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendeesBusinessCardPublicController extends Controller
{
    public function index()
    {
        $users = User::with('attendees_types', 'attendees_groups', 'register_events')
            ->orderBy('id', 'desc')
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->where('disable_status', 0)
            // ->where('is_public_url', 1)
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
            ->where('disable_status', 0)
            ->orderBy('id', 'desc')
            ->paginate(20);


        return Inertia::render('AttendeesBusinessCardPage/AttendeesPublic', ['users' => $users, 'baseUrl' => url('/')]);
    }

    public function viewPublic($id)
    {
        $user = User::findOrFail($id);

        $joinDate = Carbon::parse($user->join_date);
        $currentDate = Carbon::now();
        $diff = $joinDate->diff($currentDate);
        $serviceYears = $diff->y . ' years, ' . $diff->m . ' months, ' . $diff->d . ' days';

        return Inertia::render('AttendeesBusinessCardPage/AttendeesBusinessCardViewPublic', ['user' => $user, 'serviceYears' => $serviceYears, 'baseUrl' => url('/')]);
    }
}
