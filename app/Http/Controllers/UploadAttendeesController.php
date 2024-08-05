<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\AttendeesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

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

    public function export () {
        $excelFilePath = storage_path('app/public/sampleTemplate/sampleTemplate.xlsx');

        return response()->download($excelFilePath);
        
        // $excelExport = Excel::raw(new TemplateExport, \Maatwebsite\Excel\Excel::XLSX);

        // $zipFileName = 'files.zip';
        // $zip = new ZipArchive;

        // if ($zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE) === TRUE) {
        //     $zip->addFile($excelFilePath, 'sampleTemplate.xlsx');
        //     $zip->addFromString('template.xlsx', $excelExport);
        //     $zip->close();
        // } else {
        //     return response()->json(['error' => 'Could not create ZIP archive'], 500);
        // }

        // return response()->download(storage_path('app/public/' . $zipFileName))->deleteFileAfterSend(tru
    }
}
