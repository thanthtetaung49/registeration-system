<?php

namespace App\Http\Controllers;

use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodePrintController extends Controller
{
    public function index ($registerEventId) {
        $nameBadgeData = RegisterEvent::with('register_attendees', 'events')->where('id', $registerEventId)->first();

        $url = url('/qrcode/scan?code=' . $nameBadgeData->qr_code);

        $qrCode = QrCode::size(100)->generate($url);
        $qrCode = preg_replace('/<\?xml.*?\?>/', '', $qrCode);
        $data = [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
        ];

        $html = view('pdf', $data)->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('pdf.pdf', 'I');
    }

    public function scanQrCode(Request $request) {
        $scanQr = RegisterEvent::where('qr_code', $request->query('code'))->first();
        $scanQr->update([
            'registration_status' => 1,
        ]);

        return 'attendees register successfully';
    }
}
