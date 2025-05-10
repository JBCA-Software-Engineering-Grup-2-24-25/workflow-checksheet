<x-app-layout>
    <div class="flex flex-col h-full gap-2">
        @if (session('status') === 'login-success')
            <div class="mt-5">
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::now()->format('D, j M Y') }}</p>
                <h1 class="text-xl font-bold">Welcome Back, {{ auth()->user()->name }}!</h1>
            </div>
        @endif
    </div>
</x-app-layout>
