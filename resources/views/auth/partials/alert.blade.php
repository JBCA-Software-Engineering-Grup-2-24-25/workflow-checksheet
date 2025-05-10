@if (session('status'))
    @if (session('status') === 'verification-link-sent')
        <x-alert type="success" :show="true">
            <span
                class="font-medium">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</span>
        </x-alert>
    @else
        <x-alert type="success" :show="true">
            <span class="font-medium">{{ session('status') }}</span>
        </x-alert>
    @endif
@endif
