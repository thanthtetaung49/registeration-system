<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'locale' => app()->getLocale(),
            'language' => function () {
                return trans('messages');
            },
            'auth' => [
                'user' => $request->user() ? [
                    ...$request->user()->toArray(),
                    'two_factor_qr_code_svg' =>
                    $request->user()->two_factor_secret
                        ? $request->user()->twoFactorQrCodeSvg()
                        : null,
                    'two_factor_confirmed' => !is_null($request->user()->two_factor_confirmed_at),
                    'recovery_codes' => ($request->user()->two_factor_secret && $request->user()->two_factor_confirmed_at)
                        ? $request->user()->recoveryCodes()
                        : [],
                ] : null
            ],
        ];
    }
}
