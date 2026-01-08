<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Two Factor Authentication
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Add additional security to your account using an authenticator app.
        </p>
    </header>

    @if (! auth()->user()->two_factor_secret)
        {{-- Enable 2FA --}}
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            <x-primary-button>
                Enable Two Factor Authentication
            </x-primary-button>
        </form>
    @else
        {{-- QR Code --}}
        <div class="mt-4">
            <p class="text-sm text-gray-600 mb-2">
                Scan this QR code using Google Authenticator or Authy.
            </p>

            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>

        {{-- Disable 2FA --}}
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}" class="mt-4">
            @csrf
            @method('DELETE')

            <x-danger-button>
                Disable Two Factor Authentication
            </x-danger-button>
        </form>
    @endif
</section>
