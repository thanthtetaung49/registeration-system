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

        if ($existsOrNotStatus) {
            if ($scanQr->scan_time) {
                return response()->json(['alreadyRegisterMessage' => 'You already register your Qr code preferences']);
            } else {
                $scanQr->update([
                    'registration_status' => 1,
                    'scan_time' => Carbon::now()->setTimezone('Asia/Yangon')
                ]);

                return response()->json([
                    'successMessage' => 'You have successfully register your Qr code preferences.'
                ]);
            }
        } else {
            return response()->json([
                'notRegisterMessage' => 'You are not register your Qr code preferences.',
            ]);
        }
    }

    // student scan
    public function SelfCheckinScanQrCode(Request $request)
    {
        $code = $request->code;
        $userId = $request->authId;
        $event = Event::where('event_code', $code);
        $eventId = $event->id;

        $scanQr = RegisterEvent::where('events_id', $eventId)
            ->where('users_id', $userId)
            ->first();

        $existsOrNotStatus = RegisterEvent::where('events_id', $eventId)
            ->where('users_id', $userId)
            ->exists();

        if ($existsOrNotStatus) {
            if ($scanQr->scan_time) {
                return response()->json(['alreadyRegisterMessage' => 'You already register your Qr code preferences']);
            } else {
                $scanQr->update([
                    'registration_status' => 1,
                    'scan_time' => Carbon::now()->setTimezone('Asia/Yangon')
                ]);

                return response()->json([
                    'successMessage' => 'You have successfully register your Qr code preferences.'
                ]);
            }
        } else {
            return response()->json([
                'notRegisterMessage' => 'You are not register your Qr code preferences.',
            ]);
        }
    }
}
