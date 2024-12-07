<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodePrintController extends Controller
{
    public function attendeesQrcodeIndex($registerEventId)
    {
        $nameBadgeData = RegisterEvent::with(['register_attendees', 'events', 'attendees_types'])->where('id', $registerEventId)->first();

        $qrCode = $nameBadgeData->qr_code;

        $qrCode = QrCode::size(100)->generate($qrCode);
        $qrCode = preg_replace('/<\?xml.*?\?>/', '', $qrCode);

        // $imagePath = base_path('public/img/car.png');
        // $imageData = 'data:image/png;base64,' . base64_encode(file_get_contents($imagePath));

        $data = [
            'nameBadgeData' => $nameBadgeData,
            'qrCode' => $qrCode,
            'carImagePath' => public_path('img/car.png'),
        ];

        $registerAttendeesId = $nameBadgeData->register_attendees->id;
        $mpdf = new Mpdf([
            'format' => [210, 100],  // Size in millimeters: [width, height]
            'orientation' => 'P'  // Portrait orientation
        ]);

        $html = View::make('pdf.AttendeesPdf', $data)->render();
        $mpdf->WriteHTML($html);

        $filename = $registerAttendeesId . '_' . $nameBadgeData->register_attendees->name . '_qrCode.pdf';

        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
    }



    public function eventQrcodeIndex($eventId)
    {
        $event = Event::findOrFail($eventId);
        $eventCode = $event->event_code;
        $eventName = $event->event_name;

        $qrCode = (string) QrCode::size(100)->generate($eventCode);
        $qrCode = preg_replace('/<\?xml.*?\?>/', '', $qrCode);

        $data = [
            'nameBadgeData' => $eventName,
            'qrCode' => $qrCode,
        ];

        $mpdf = new Mpdf([
            'format' => [210, 100],  // Size in millimeters: [width, height]
            'orientation' => 'P'  // Portrait orientation
        ]);

        $html = View::make('pdf.eventSelfCheckinPdf', $data)->render();
        $mpdf->WriteHTML($html);

        $filename = $eventName . '.pdf';

        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
    }
}
