<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RegisterEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SelfCheckInUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return Inertia::render('SelfCheckInUserPage/SelfCheckInUserScanQR', [
            'user' => $user,
        ]);
    }


    // security scan
    public function SecurityScanQrCode(Request $request)
    {
        $code = $request->code;
        $scanQr = RegisterEvent::where('qr_code', $code)->first();
        $existsOrNotStatus = RegisterEvent::where('qr_code', $code)->exists();

        $message = $this->qrCodeScan($existsOrNotStatus, $scanQr);

        return response()->json($message);
    }

    // attendees scan
    public function attendeesScanQrCode(Request $request)
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

    // QR code scan logic
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
