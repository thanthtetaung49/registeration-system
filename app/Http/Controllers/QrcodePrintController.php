<?php

namespace App\Http\Controllers;

use App\Models\RegisterEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class QrcodePrintController extends Controller
{
    public function index($registerEventId)
    {
        $nameBadgeData = RegisterEvent::with(['register_attendees', 'events', 'attendees_types'])->where('id', $registerEventId)->first();
        // dd($nameBadgeData->toArray());

        $url = $nameBadgeData->qr_code;

        $qrCode = QrCode::size(100)->generate($url);
        $qrCode = preg_replace('/<\?xml.*?\?>/', '', $qrCode);
        $data = [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
        ];

        $registerAttendeesId = $nameBadgeData->register_attendees->id;

        // return view('pdf', $data);

        $htmlContent = View::make('pdf', $data)->render();

        $imagePath = storage_path('app/public/qrCode/' . $registerAttendeesId . '_' .$nameBadgeData->register_attendees->name .  '_qrCode.png');
        Browsershot::html($htmlContent)->save($imagePath);

        return response()->download($imagePath);
    }

    public function scanQrCode(Request $request)
    {
        $scanQr = RegisterEvent::where('qr_code', $request->code)->first();
        if ($scanQr->scan_time) {
            return response()->json(['message' => 'You already register your Qr code preferences']);
        } else {
            $scanQr->update([
                'registration_status' => 1,
                'scan_time' => Carbon::now()
            ]);
        }


        return response()->json(['message' => 'You have successfully register your Qr code preferences.']);
    }
}
