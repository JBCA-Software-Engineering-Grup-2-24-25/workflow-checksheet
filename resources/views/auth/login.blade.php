<x-guest-layout>
    {{-- Alert Start --}}
    @include('auth.partials.alert')
    {{-- Alert End --}}

    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
    <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
        <div class="mb-8 text-center">
            <p class="text-xl font-semibold">Sign In</p>
            <span class="block mt-3 text-sm italic text-gray-600">Welcome back!</span>
        </div>

        <form method="POST" action="{{ route(name: 'login', absolute: false) }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="py-2 mt-2 text-sm text-gray-900 border-gray-300 rounded focus:outline-none focus:ring-0 focus:border-gray-300"
                    type="text" name="email" :value="old('email')" autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="flex flex-col">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input ::type="show ? 'text' : 'password'" id="password" type="password" name="password"
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <!-- Remember Me -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>
                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-500 rounded-md hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route(name: 'password.request', absolute: false) }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="mt-4">
                <x-button color="primary" class="w-full">
                    {{ __('Sign In') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
