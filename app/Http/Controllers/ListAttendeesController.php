<?php

namespace App\Http\Controllers;

use App\Exports\AttendeesExport;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ListAttendeesController extends Controller
{
    public function index () {
        $users = User::with('attendees_types', 'attendees_groups', 'register_events')->orderBy('id', 'desc')->where('is_admin', 0)->paginate(5);

        return Inertia::render('AttendeesPage/ListAttendees', ['users' => $users]);
    }

    public function search (Request $request) {
        $search = $request->query('query');

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->where('is_admin', 0)
        ->orderBy('id', 'desc')
        ->paginate(5);

        return response()->json($users);
    }

    public function excelExport () {
        $attendees = $this->exportAttendees();
        return Excel::download(new AttendeesExport($attendees), 'attendees.xlsx');
    }

    public function csvExport () {
        $attendees = $this->exportAttendees();
        return Excel::download(new AttendeesExport($attendees), 'attendees.csv');
    }

    private function exportAttendees () {
        $attendees = User::with('attendees_types')->where('is_admin', 0)->get();
        return $attendees;
    }
}
