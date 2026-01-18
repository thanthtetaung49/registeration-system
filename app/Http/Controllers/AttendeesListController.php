<?php

namespace App\Http\Controllers;

use App\Exports\AttendeesExport;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AttendeesListController extends Controller
{
    public function index()
    {
        // 1 => superadmin
        // 4 => admin
        // 0, 3 => user
        // 2 => security
        $users = User::with('attendees_types', 'attendees_groups', 'register_events')
            ->orderBy('id', 'desc')
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->paginate(20);

        return Inertia::render('AttendeesPage/AttendeesList', ['users' => $users]);
    }

    public function search(Request $request)
    {
        $search = $request->query('query');

        if ($search == 'null') {
            $users = User::with('attendees_types', 'attendees_groups', 'register_events')
                ->orderBy('id', 'desc')
                ->whereIn('role', ['attendees', 'self_checkin_user'])
                ->paginate(20);
        } else {
            $users = User::with('attendees_types', 'attendees_groups', 'register_events')
                ->when($search, function ($query) use ($search) {
                    return $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->whereIn('role', ['attendees', 'self_checkin_user'])
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        return Inertia::render('AttendeesPage/AttendeesList', ['users' => $users]);
    }

    public function excelExport()
    {
        $attendees = $this->exportAttendees();
        return Excel::download(new AttendeesExport($attendees), 'attendees.xlsx');
    }

    public function csvExport()
    {
        $attendees = $this->exportAttendees();
        return Excel::download(new AttendeesExport($attendees), 'attendees.csv');
    }

    private function exportAttendees()
    {
        $attendees = User::with(['attendees_types', 'register_events'])
            ->whereIn('role', ['attendees', 'self_checkin_user'])
            ->get();
        return $attendees;
    }
}
