<?php

namespace App\Http\Controllers;

use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class QrcodePrintController extends Controller
{
    public function index ($registerEventId) {
        $nameBadgeData = RegisterEvent::with(['register_attendees', 'events', 'attendees_types'])->where('id', $registerEventId)->first();
        // dd($nameBadgeData->toArray());

        $url = url('/qrcode/scan?code=' . $nameBadgeData->qr_code);

        $qrCode = QrCode::size(100)->generate($url);
        $qrCode = preg_replace('/<\?xml.*?\?>/', '', $qrCode);
        $data = [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
        ];

        // return view('pdf', $data);

        $htmlContent = View::make('pdf', $data)->render();

        $imagePath = storage_path('app/public/qrCode/' . uniqid() . time() . 'qrCode.png');
        Browsershot::html($htmlContent)->save($imagePath);

        return response()->download($imagePath);
    }

    public function scanQrCode(Request $request) {
        $scanQr = RegisterEvent::where('qr_code', $request->query('code'))->first();
        $scanQr->update([
            'registration_status' => 1,
        ]);

        return 'attendees register successfully';
    }
}
