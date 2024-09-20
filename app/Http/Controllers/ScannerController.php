<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use App\Models\RegisterEvent;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    // security scan
    public function SecurityScanQrCode(Request $request)
    {
        $code = $request->code;
        $scanQr = RegisterEvent::where('qr_code', $code)->first();
        $existsOrNotStatus = RegisterEvent::where('qr_code', $code)->exists();

        $message = $this->qrCodeScan($existsOrNotStatus, $scanQr);

        return response()->json($message);
    }

    // student scan
    public function SelfCheckinScanQrCode(Request $request)
    {
        $code = $request->code;
        $userId = $request->authId;
        $event = Event::where('event_code', $code)->first();
        $eventId = $event?->id;

        $scanQr = RegisterEvent::where('events_id', $eventId)
            ->where('users_id', $userId)
            ->first();

        $existsOrNotStatus = RegisterEvent::where('events_id', $eventId)
            ->where('users_id', $userId)
            ->exists();

        $message = $this->qrCodeScan($existsOrNotStatus, $scanQr);

        return response()->json($message);
    }

    // qrcode scan logic
    public function qrCodeScan($existsOrNotStatus, $scanQr)
    {
        $message = [];

        if ($existsOrNotStatus) {
            if ($scanQr->scan_time) {
                $message['alreadyRegisterMessage'] = 'You have already registered your Qr code preferences.';
            } else {
                $scanQr->update([
                    'registration_status' => 1,
                    'scan_time' => Carbon::now()->setTimezone('Asia/Yangon'),
                ]);
                $message['successMessage'] = 'You have successfully registered your Qr code preferences.';
            }
        } else {
            $message['notRegisterMessage'] = 'You are not registered for your Qr code preferences.';
        }

        return $message;
    }
}
