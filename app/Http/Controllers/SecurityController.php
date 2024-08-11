<?php

namespace App\Http\Controllers;

use App\Models\RegisterEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SecurityController extends Controller
{
    public function index () {
        return Inertia::render('SecurityPage/Scan');
    }

    public function scanQrCode(Request $request)
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
}
