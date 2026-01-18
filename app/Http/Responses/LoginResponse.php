<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->role == 'security' || $user->role == 'self_checkin_user') {
            return redirect()->intended(route('selfCheckInUser.index'));
        }

        return redirect()->intended(route('calendar.index'));
    }
}
