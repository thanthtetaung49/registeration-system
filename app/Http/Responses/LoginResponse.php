<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->is_admin == 2 || $user->is_admin == 3) {
            return redirect()->intended(route('selfCheckInUser.index'));
        }

        return redirect()->intended(route('calendar.index'));
    }
}
