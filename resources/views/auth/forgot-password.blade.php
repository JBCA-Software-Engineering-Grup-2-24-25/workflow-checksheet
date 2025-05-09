<x-guest-layout>
    {{-- Alert Start --}}
    @include('auth.partials.alert')
    {{-- Alert End --}}
    <!-- Session Status -->
    <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
        <div class="mb-8 text-center">
            <p class="text-xl font-semibold">Forgot Password</p>
            <span class="block mt-3 text-sm italic text-gray-600">Forgot your password? No problem. Just let us know your
                email address and we will email you a password reset link that will allow you to choose a new
                one.</span>
        </div>
        {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

        <form method="POST" action="{{ route(name: 'password.email', absolute: false) }}">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full mt-1" type="text" name="email" :value="old('email')"
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-button color="primary" class="w-full">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
