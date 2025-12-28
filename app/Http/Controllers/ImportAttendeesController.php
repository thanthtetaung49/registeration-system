<?php

namespace App\Http\Controllers;

use App\Imports\AttendeesImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ImportAttendeesController extends Controller
{
    public function index()
    {
        return Inertia::render('AttendeesPage/AttendeesImport');
    }

    public function importAttendee(Request $request) {
        $request->validate([
            'import_file' => ['required', 'mimes:xlsx,xls,csv']
        ]);

        Excel::import(new AttendeesImport, $request->file('import_file'));
    }

    public function export () {
        $excelFilePath = storage_path('app/public/sampleTemplate/sampleTemplate.xlsx');

        return response()->download($excelFilePath);
    }
}
