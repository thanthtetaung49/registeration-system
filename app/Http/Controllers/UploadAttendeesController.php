<?php

namespace App\Http\Controllers;

use App\Imports\AttendeesImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class UploadAttendeesController extends Controller
{
    public function index()
    {
        return Inertia::render('AttendeesPage/UploadAttendees');
    }

    public function importAttendee(Request $request) {
        $request->validate([
            'import_file' => ['required', 'mimes:xlsx,xls,csv']
        ]);


        Excel::import(new AttendeesImport, $request->file('import_file'));
    }
}
